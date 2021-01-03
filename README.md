<h2 align="center">oauth2-discord</h2>
<p align="center">This package provides Discord's OAuth 2 and supports League's OAuth 2.0 client.</p>

<br />

## 📖 Example
```php
<?php

require __DIR__ . '/vendor/autoload.php';
session_start();

$discordProvider = new \Romitou\OAuth2\Client\DiscordProvider([
    'clientId' => '', // The ID of your application
    'clientSecret' => '', // The secret of your application
    'redirectUri' => '', // The callback URI where the user will be redirected
    'scopes' => [], // The scopes you want (e.g. ['identify', 'email'])
    'state' => '' // Optional, the state of the provider
]);

if (isset($_GET['code'])) {

    if ($_SESSION['oauth2_state'] !== $_GET['state'])
        exit('The returned state doesn\'t match with your local state.');
        
    $discordToken = $discordProvider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);
    
    $discordUser = $discordProvider->getResourceOwner($discordToken);
    
    // Now, you will be able to retrieve user's informations.
    echo 'Your token is ' . $discordToken->getToken();
    echo 'Your username is ' . $discordUser->getUsername();
    
} else {

    $oauthUrl = $discordProvider->getAuthorizationUrl();
    $_SESSION['oauth2_state'] = $discordProvider->getState();
    header('Location: ' . $oauthUrl);
    
}
```
