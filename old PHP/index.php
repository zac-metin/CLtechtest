<?php
session_start(); // self explanatory starts the session

require_once __DIR__ . '/vendor/autoload.php';

$provider = new \League\OAuth2\Client\Provider\GenericProvider([
    'clientId' => '<id>',
    'clientSecret' => '<secret>',
    'redirectUri' => 'http://localhost:8080?action=oauth_callback',
    'urlAuthorize' => 'https://appcenter.intuit.com/connect/oauth2',
    'urlAccessToken' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
    'urlResourceOwnerDetails' => null,
    'scopes' => ['com.intuit.quickbooks.accounting']
]);
$restClient = new \GuzzleHttp\Client();

$result = '';
$action = isset($_GET['action']) ? $_GET['action'] : 'none';
$token = isset($_SESSION['token']) ? $_SESSION['token'] : null;

if ($action == 'connect') {
    $authorizationUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authorizationUrl);
}

if ($action == 'oauth_callback') {
    if ($_GET['state'] !== $_SESSION['oauth2state']) {
        unset($_SESSION['oauth2state']);
        exit("State mismatch");
    }

    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    $_SESSION['company_id'] = $_GET['realmId'];
    $_SESSION['token'] = $token->getToken();

}

if ($action == 'disconnect') {
    unset($_SESSION['company_id']);
    unset($_SESSION['token']);
    header('Location: http://localhost:8080');
}

if ($action == 'query') {
    try {
        $response = $restClient->request('GET', 'https://sandbox-quickbooks.api.intuit.com/v3/company/' . $_POST['company'] . '/query?query=' . $_POST['query'], [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        ]);

        $result = json_decode($response->getBody());
    } catch (\Exception $e) {
        $result = $e->getMessage();
    }
}

if ($action == 'entity') {
    try {
        $response = $restClient->request('GET', 'https://sandbox-quickbooks.api.intuit.com/v3/company/' . $_POST['company'] . '/' . strtolower($_POST['entity']) . '/' . $_POST['id'], [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        ]);

        $result = json_decode($response->getBody());
    } catch (\Exception $e) {
        $result = $e->getMessage();
    }
}

?>

<?php
if (is_null($token)) {
    ?>
<a href="?action=connect">Connect</a><br><br>
<?php

}
else {
    ?>
<a href="?action=disconnect">Disconnect</a><br><br>
<?php

}
?>

<form method="post" action="?action=query">
    <div>Company: <input type="text" name="company" value="<?= $_SESSION['company_id'] ?>"/></div>
    <div>Query: <input type="text" name="query" value="Select * From Account"/></div>
    <div><input type="submit" /></div>
</form>

<form method="post" action="?action=entity">
    <div>Company: <input type="text" name="company" value="<?= $_SESSION['company_id'] ?>"/></div>
    <div>Entity: <select name="entity"><option>Account</select></div>
    <div>Entity Id: <input type="text" name="id" /></div>
    <div><input type="submit" /></div>
</form>

<pre>
<?php
print_r($result);
?>
</pre>
