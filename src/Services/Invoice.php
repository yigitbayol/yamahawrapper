<?php

namespace Yigitbayol\Yamahawrapper\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Invoice
{
    private $yamaha;

    public function __construct(Yamaha $yamaha)
    {
        $this->yamaha = $yamaha;
    }
    /**
     * spareRetailInvoice Return spare retail invoice information
     *
     * @param  mixed $retailInvoiceNo
     * @param  mixed $fromDate
     * @param  mixed $toDate
     * @return void
     */
    public function spareRetailInvoice($retailInvoiceNo = '', $fromDate = '', $toDate = '')
    {
        $this->yamaha->initialize();

        $parameters = ['RetailInvoiceNo' => $retailInvoiceNo];

        if ($fromDate) {
            $parameters['FromDate'] = $fromDate;
            if (!$toDate) {
                // Eğer sadece FromDate verilmişse, ToDate'i FromDate'den 3 ay sonraya ayarla
                $toDate = Carbon::parse($fromDate)->addMonths(3)->format('Y-m-d');
            }
        }

        if ($toDate) {
            $parameters['ToDate'] = $toDate;
            if (!$fromDate) {
                // Eğer sadece ToDate verilmişse, FromDate'i ToDate'den 3 ay öncesine ayarla
                $fromDate = Carbon::parse($toDate)->subMonths(3)->format('Y-m-d');
            }
        }

        $response = Http::withToken($this->yamaha->getAccessToken())
            ->post('https://dms-tr.yamnet.com/ymtr_webapi/api/spares/', $parameters);

        return $response->json();
    }


    /**
     * unitRetailInvoice - Return unit retail invoice information
     *
     * @param  mixed $frameNo
     * @param  mixed $fromDate
     * @param  mixed $toDate
     * @return void
     */
    public function unitRetailInvoice($frameNo = '', $fromDate = '', $toDate = '')
    {
        $this->yamaha->initialize();

        $parameters = ['FrameNo' => $frameNo];

        if ($fromDate) {
            $parameters['FromDate'] = $fromDate;
            if (!$toDate) {
                // Eğer sadece FromDate verilmişse, ToDate'i FromDate'den 3 ay sonraya ayarla
                $toDate = Carbon::parse($fromDate)->addMonths(3)->format('Y-m-d');
            }
        }

        if ($toDate) {
            $parameters['ToDate'] = $toDate;
            if (!$fromDate) {
                // Eğer sadece ToDate verilmişse, FromDate'i ToDate'den 3 ay öncesine ayarla
                $fromDate = Carbon::parse($toDate)->subMonths(3)->format('Y-m-d');
            }
        }

        $response = Http::withToken($this->yamaha->getAccessToken())
            ->post('https://dms-tr.yamnet.com/ymtr_webapi/api/unit/get-all-retailinvoices', $parameters);

        return $response->json();
    }


    /**
     * allSpareInvoicesByYamaha - Returns all spare invoices by Yamaha
     *
     * @param  mixed $partNo
     * @param  mixed $dmsOrderNo
     * @param  mixed $fromDate
     * @param  mixed $toDate
     * @return void
     */
    public function allSpareInvoicesByYamaha($partNo = '', $dmsOrderNo = '', $fromDate = '', $toDate = '')
    {
        $this->yamaha->initialize();

        $parameters = [
            'PartNo' => $partNo,
            'DMSOrderNo' => $dmsOrderNo,
            'FromDate' => $fromDate,
            'ToDate' => $toDate
        ];

        // Tarih filtrelemesi için mantık
        if (!$fromDate && $toDate) {
            $parameters['FromDate'] = Carbon::parse($toDate)->subMonths(3)->format('Y-m-d');
        }

        if ($fromDate && !$toDate) {
            $parameters['ToDate'] = Carbon::parse($fromDate)->addMonths(3)->format('Y-m-d');
        }

        $response = Http::withToken($this->yamaha->getAccessToken())
            ->post('https://dms-tr.yamnet.com/ymtr_webapi/api/spares/get-all-ymtr-invoiced-spares', $parameters);

        return $response->json();
    }



    /**
     * allUnitInvoicesByYamaha -  Return all unit invoices by Yamaha
     *
     * @param  mixed $engineNo
     * @param  mixed $chassisNo
     * @param  mixed $fromDate
     * @param  mixed $toDate
     * @return void
     */
    public function allUnitInvoicesByYamaha($engineNo = '', $chassisNo = '', $fromDate = '', $toDate = '')
    {
        $this->yamaha->initialize();

        $parameters = [
            'EngineNo' => $engineNo,
            'ChassisNo' => $chassisNo,
            'FromDate' => $fromDate,
            'ToDate' => $toDate
        ];

        // Tarih filtrelemesi için mantık
        if (!$fromDate && $toDate) {
            $parameters['FromDate'] = Carbon::parse($toDate)->subMonths(3)->format('Y-m-d');
        }

        if ($fromDate && !$toDate) {
            $parameters['ToDate'] = Carbon::parse($fromDate)->addMonths(3)->format('Y-m-d');
        }

        $response = Http::withToken($this->yamaha->getAccessToken())
            ->post('https://dms-tr.yamnet.com/ymtr_webapi/api/unit/get-all-ymtr-invoiced-units', $parameters);

        return $response->json();
    }


    /**
     * allSpareInvoices - Returns all spare invoices by Yamaha
     *
     * @param  mixed $partNo
     * @param  mixed $dmsOrderNo
     * @param  mixed $fromDate
     * @param  mixed $toDate
     * @return void
     */
    public function allSpareInvoices($retailInvoiceNo = '', $fromDate = '', $toDate = '')
    {
        $this->yamaha->initialize();

        $parameters = [
            'RetailInvoiceNo' => $retailInvoiceNo,
            'FromDate' => $fromDate,
            'ToDate' => $toDate
        ];

        // Tarih filtrelemesi için mantık
        if (!$fromDate && $toDate) {
            $parameters['FromDate'] = Carbon::parse($toDate)->subMonths(3)->format('Y-m-d');
        }

        if ($fromDate && !$toDate) {
            $parameters['ToDate'] = Carbon::parse($fromDate)->addMonths(3)->format('Y-m-d');
        }

        $response = Http::withToken($this->yamaha->getAccessToken())
            ->post('https://dms-tr.yamnet.com/ymtr_webapi/api/spares/get-all-retail', $parameters);

        return $response->json();
    }

}
