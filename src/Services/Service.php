<?php
namespace Yigitbayol\Yamahawrapper\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Service
{
    private $yamaha;

    public function __construct(Yamaha $yamaha)
    {
        $this->yamaha = $yamaha;
    }
    /**
     * getAllServices - Tüm servisleri getirir.
     *
     * @param  mixed $fromDate
     * @param  mixed $toDate
     * @return void
     */
    public function getAllServices($fromDate = null, $toDate = null)
    {
        $this->yamaha->initialize();

        if (empty ($fromDate) && empty ($toDate)) {
            // Her iki tarih de belirtilmediyse varsayılan olarak bugünden 3 ay sonrasını ve öncesini hesapla
            $fromDate = Carbon::now()->format('Y-m-d');
            $toDate = Carbon::now()->addMonths(3)->format('Y-m-d');
        } elseif (!empty ($fromDate) && empty ($toDate)) {
            // Sadece FromDate belirtilmişse, ToDate'i FromDate'den 3 ay sonrası olarak ayarla
            $fromDate = Carbon::parse($fromDate)->format('Y-m-d');
            $toDate = Carbon::parse($fromDate)->addMonths(3)->format('Y-m-d');
        } elseif (empty ($fromDate) && !empty ($toDate)) {
            // Sadece ToDate belirtilmişse, FromDate'i ToDate'den 3 ay öncesi olarak ayarla
            $toDate = Carbon::parse($toDate)->format('Y-m-d');
            $fromDate = Carbon::parse($toDate)->subMonths(3)->format('Y-m-d');
        } else {
            // Her iki tarih de belirtilmişse, doğrudan kullan
            $fromDate = Carbon::parse($fromDate)->format('Y-m-d');
            $toDate = Carbon::parse($toDate)->format('Y-m-d');
        }

        $parameters = [
            "FromDate" => $fromDate,
            "ToDate" => $toDate
        ];

        $response = $this->makeRequest($parameters);

        return $response;
    }

    private function makeRequest($parameters)
    {
        $accessToken = $this->yamaha->getAccessToken();

        $response = Http::withToken($accessToken)
            ->post('https://dms-tr.yamnet.com/ymtr_webapi/api/services/get-all-services', $parameters);

        return $response->json();
    }
}


