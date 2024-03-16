<?php

namespace Yigitbayol\Yamahawrapper\Services;

use Illuminate\Support\Facades\Http;

class Stock
{
    private $yamaha;

    public function __construct(Yamaha $yamaha)
    {
        $this->yamaha = $yamaha;
    }
    /**
     * Get dealer stock information for a specific unit based on FrameNo and StockQuality.
     *
     * @param string $frameNo
     * @param string $stockQuality
     * @return array
     */
    public function getUnit($frameNo = '', $stockQuality = '')
    {
        $this->yamaha->initialize();

        $parameters = [
            'FrameNo' => $frameNo,
            'StockQuality' => $stockQuality
        ];

        $response = Http::withToken($this->yamaha->getAccessToken())
            ->post('https://dms-tr.yamnet.com/ymtr_webapi/api/unit/get-all-dealerstock', $parameters);

        return $response->json();
    }

    /**
     * Get dealer stock information for spares based on PartNo and VendorName.
     *
     * @param string $partNo
     * @param string $vendorName
     * @return array
     */
    public function getSpare($partNo = '', $vendorName = '')
    {
        $this->yamaha->initialize();

        $parameters = [
            'PartNo' => $partNo,
            'VendorName' => $vendorName
        ];

        $response = Http::withToken($this->yamaha->getAccessToken())
            ->post('https://dms-tr.yamnet.com/ymtr_webapi/api/spares/get-all-dealerstock', $parameters);

        return $response->json();
    }
}
