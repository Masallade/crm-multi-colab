<?php

namespace App\Services;

use Google_Client;
use GuzzleHttp\Client;

class FirebaseService
{
    protected $projectId;
    protected $credentials;

    public function __construct()
    {
        $this->projectId = config('firebase.project_id');
        $this->credentials = base_path(config('firebase.credentials'));
    }

    protected function getAccessToken()
    {
        $client = new Google_Client();
        $client->setAuthConfig($this->credentials);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->fetchAccessTokenWithAssertion();
        return $client->getAccessToken()['access_token'];
    }

    public function sendNotification($firebaseToken, $title, $body)
    {
        $accessToken = $this->getAccessToken();

        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        $client = new Client();

        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'message' => [
                    'token' => $firebaseToken,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ]
                ]
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
