<?php

namespace Yigitbayol\Yamahawrapper\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Customer
{
    private $yamaha;

    public function __construct(Yamaha $yamaha)
    {
        $this->yamaha = $yamaha;
    }
    /**
     * getCustomer - Returns customer info
     *
     * @param  mixed $taxNumber
     * @param  mixed $phoneNo
     * @return void
     */
    public function getCustomer($taxNumber = null, $phoneNo = null)
    {
        $this->yamaha->initialize(); // Ebeveyn sınıfın initialize metodunu çağırarak gerekli ayarlamaları yapın

        $parameters = [];
        if ($taxNumber) {
            $parameters['TaxNumber'] = $taxNumber;
        }
        if ($phoneNo) {
            $parameters['PhoneNo'] = $phoneNo;
        }

        $response = Http::withToken($this->yamaha->getAccessToken())
            ->post('https://dms-tr.yamnet.com/ymtr_webapi/api/customer/get-customer', $parameters);

        return $response->json(); // Yanıtı JSON olarak döndür
    }
}
