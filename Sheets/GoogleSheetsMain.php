<?php
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Magic5');
    $client->setScopes(Google_Service_Sheets::DRIVE);
    $client->setAuthConfig(__DIR__ . '/credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = __DIR__ . '/token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            if(empty($_GET['code'])) {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                echo 'Open the following link in your browser: <a href="' . $authUrl . '">link</a>';
                die;
            }
            $authCode = $_GET['code'];
            echo 'Authorization has been completed. Please, go back for work with Google Sheets';
            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

function SetNewRow($GS, $spreadsheetId)
{
    if(empty($GS))
    {
        return;
    }
    // Get the API client and construct the service object.
    $client = getClient();
    $service = new Google_Service_Sheets($client);

    $range = 'A:H';
    $valueRange= new Google_Service_Sheets_ValueRange();
    $valueRange->setValues(['values' => [
        addslashes( $GS->GetUserId() ),
        addslashes( $GS->GetUserName() ),
        addslashes( $GS->GetFirstName() ),
        addslashes( $GS->GetLastName() ),
        addslashes( $GS->GetTelegramTime() ),
        addslashes( $GS->GetServerTime() ),
        addslashes( $GS->GetDay() ),
        addslashes( $GS->GetContext() )
    ]]);
    $conf = ["valueInputOption" => "RAW"];
    $ins = ["insertDataOption" => "INSERT_ROWS"];
    $service->spreadsheets_values->append($spreadsheetId, $range, $valueRange, $conf, $ins);
}

if(!empty($_GET['code']))
{
    getClient();
}