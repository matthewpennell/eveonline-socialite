<?php

namespace matthewpennell\Socialite\EveOnline\Traits;

use Exception;
use GuzzleHttp\Client;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

trait EveAuth {

    protected $user;

    public function login()
    {
        try {
            return Socialite::driver('eveonline-sisi')->redirect();
        } catch (Exception $e) {
            return back();
        }
    }

    public function callback()
    {
        try {
            $this->user = Socialite::driver('eveonline-sisi')->user();
        } catch (InvalidStateException $e) {
            return back();
        }

        return $this->user;
    }

    public function get_character()
    {
        // Get more detailed character data from CREST
        $httpClient = new Client();
        $url = "https://esi.tech.ccp.is/latest/characters/{$this->user->id}/?datasource=singularity";

        try {
            $response = $httpClient->get($url);
        } catch (Exception $exception) {
            return abort(504, 'ESI is not reachable, try again later.');
        }

        return json_decode($response->getBody()->getContents());
    }
}