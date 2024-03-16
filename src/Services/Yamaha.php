<?php

namespace Yigitbayol\Yamahawrapper\Services;

use Carbon\Carbon;
use App\Models\YamahaSetting;
use Illuminate\Support\Facades\Http;


class Yamaha
{
    private $access_token;
    private $expire_at;
    private $expire_in;

    public $customer;
    public $invoice;
    public $service;
    public $stock;

    public function __construct()
    {
        $this->initialize();
        $this->customer = new Customer($this);
        $this->invoice = new Invoice($this);
        $this->service = new Service($this);
        $this->stock = new Stock($this);
    }

    public function initialize()
    {
        $tokenDetails = $this->getAccessTokenFromDatabaseOrApi();
        $this->access_token = $tokenDetails['access_token'];
        $this->expire_at = $tokenDetails['expire_at'];
        $this->expire_in = $tokenDetails['expire_in'];
    }

    private function getAccessTokenFromDatabaseOrApi()
    {
        // Önce veritabanından token'i deneyin
        $setting = YamahaSetting::first();
        if ($setting && $setting->access_token && $setting->expires_at > Carbon::now()) {
            return [
                'access_token' => $setting->access_token,
                'expire_at' => $setting->expires_at,
                'expire_in' => $setting->expires_in
            ];
        }

        // Token yoksa veya süresi dolmuşsa, API'den yeni bir token alın
        return $this->fetchAccessTokenFromApi();
    }

    private function fetchAccessTokenFromApi()
    {
        $parameters = [
            'grant_type' => config('yamaha.grant_type'),
            'username' => config('yamaha.username'),
            'password' => config('yamaha.password')
        ];

        $response = Http::asForm()->post('https://dms-tr.yamnet.com/ymtr_webapi/token', $parameters);
        $responseBody = json_decode($response->body(), true);

        if (isset ($responseBody['access_token'])) {
            $this->setAccessToken($responseBody['access_token'], $responseBody['expires_in']);
        }

        return [
            'access_token' => $this->access_token,
            'expire_at' => $this->expire_at,
            'expire_in' => $this->expire_in
        ];
    }

    private function setAccessToken($token, $expire_in)
    {
        $expire_at = Carbon::now()->addSeconds($expire_in);
        $this->access_token = $token;
        $this->expire_at = $expire_at;
        $this->expire_in = $expire_in;

        // Veritabanında token ve süresini güncelleyin
        YamahaSetting::updateOrCreate(['id' => 1], [
            'access_token' => $token,
            'expires_at' => $expire_at,
            'expires_in' => $expire_in
        ]);
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function getExpireAt()
    {
        return $this->expire_at;
    }
}


