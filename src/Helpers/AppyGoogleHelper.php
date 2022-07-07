<?php

namespace Appy\FcmHttpV1\Classes;

use Google\Client as GClient;
use Google\Service\FirebaseCloudMessaging;
use Google_Exception;

class AppyFcmHttpV1
{
    public static function configureClient()
    {
        $path = base_path() . '/' . env('FCM_JSON');

        $client = new GClient();
        try {
            $client->setAuthConfig($path);
            $client->addScope(FirebaseCloudMessaging::CLOUD_PLATFORM);

            $accessToken = AppyFcmHttpV1::generateToken($client);

            $client->setAccessToken($accessToken);

            $oauthToken = $accessToken["access_token"];

            return $oauthToken;
            // the client is configured, now you can send the push notification using the $oauthToken.

        } catch (Google_Exception $e) {
            return $e;
        }
    }

    private static function generateToken($client)
    {
        $client->fetchAccessTokenWithAssertion();
        $accessToken = $client->getAccessToken();

        return $accessToken;
    } 
}
