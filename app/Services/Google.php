<?php


namespace App\Services;


class Google
{
    protected $client;

    public function __construct()
    {
        $client = new \Google_Client();
        $client->setApplicationName('library-calendar');
        $client->setScopes([\Google_Service_Calendar::CALENDAR]);
        $client->setAuthConfig([
            'installed' => [
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'redirect_uris' => [
                    config('services.google.redirect'),
                ],
            ]
        ]);
        $client->setApprovalPrompt(true);
        $client->setAccessType('offline');
        $this->client = $client;
    }

    public function fetchAccessTokenWithCode($code)
    {
        return $this->client->fetchAccessTokenWithAuthCode($code);
    }

    public function setAuthCode()
    {
        $this->client->setAccessToken(session('accessToken'));
        if ($this->client->isAccessTokenExpired()) {
            $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
        }
    }

    /**
     * @return \Google_Client
     */
    public function getClient(): \Google_Client
    {
        return $this->client;
    }
}
