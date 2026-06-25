<?php
// Secure token verification to prevent unauthorized execution
$secret_token = "mWfjhZ6k7vvLxDJ6oJhEhzleZpmLPvcxcFpOoVITCJh2IFWC";

if (!isset($_GET['token']) || $_GET['token'] !== $secret_token) {
    header('HTTP/1.0 403 Forbidden');
    echo 'Unauthorized Access.';
    exit;
}

echo "=== Deployment Started ===\n";
// Force system execution to pull updates cleanly
$output = shell_exec("git fetch --all && git reset --hard origin/main 2>&1");
echo "<pre>$output</pre>";
echo "=== Deployment Finished ===";
?>