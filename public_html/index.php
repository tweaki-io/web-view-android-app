<!DOCTYPE html>
<html>
<head>
    <title>WebView APK Generator</title>
</head>
<body>
    <h2>Enter Website URL to Generate APK</h2>
    <form method="POST">
        <input type="text" name="url" placeholder="Enter Website URL" required>
        <button type="submit">Generate APK</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $url = $_POST["url"];
        $repo_owner = "your-github-username"; // Change this
        $repo_name = "WebView-APK-Generator"; // Change this
        $github_token = "your-github-personal-access-token"; // Generate from GitHub settings

        $data = json_encode(["event_type" => "apk_build", "client_payload" => ["url" => $url]]);

        $ch = curl_init("https://api.github.com/repos/$repo_owner/$repo_name/dispatches");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: application/vnd.github.everest-preview+json",
            "Authorization: token $github_token",
            "User-Agent: cURL"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);

        echo "<p>Build started! Check your GitHub Actions for the APK.</p>";
    }
    ?>
</body>
</html>
