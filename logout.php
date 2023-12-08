<?php
session_start();

// Store the current page URL before destroying the session
$redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'; // Use a default URL if HTTP_REFERER is not set
$_SESSION['redirect_url'] = $redirect_url;

// Destroy the session
session_destroy();

// Redirect to the stored URL
header("Location: $redirect_url");
exit();
?>