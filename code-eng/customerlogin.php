<?php
session_start();

$clientId = ";
$tenantId = "";
$redirectUri = "";

$authUrl = "https://login.microsoftonline.com/$tenantId/oauth2/v2.0/authorize?" . http_build_query([
    'client_id' => $clientId,
    'response_type' => 'code',
    'redirect_uri' => $redirectUri,
    'response_mode' => 'query',
    'scope' => 'openid profile email',
]);

header("Location: $authUrl");
exit;