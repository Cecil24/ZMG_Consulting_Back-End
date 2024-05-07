<?php

namespace App\services;

use App\Common\EmployeeTitles;
use App\Models\Asset;
use App\Models\AuditTrail;
use App\Models\Client;
use App\Common\ClientTypes;
use App\Models\User;
use Illuminate\Support\Collection;

class ReportService
{
    /**
     * @return array
     */
    public function getClientTypesReport():array
    {
        $report['series'] = [];
        $report['labels'] = [];

        $dataCo = count(Client::where('type', ClientTypes::COOPS)->get());
        $dataAd = count(Client::where('type', ClientTypes::ADMINISTRATOR)->get());
        $dataC = count(Client::where('type', ClientTypes::COMPANY)->get());
        $dataTr = count(Client::where('type', ClientTypes::TRUST)->get());

        array_push($report['labels'], ClientTypes::COOPS,ClientTypes::ADMINISTRATOR, ClientTypes::COMPANY, ClientTypes::TRUST);
        array_push($report['series'],$dataCo,$dataAd,$dataC,$dataTr);

        return $report;
    }

    /**
     * @return array
     */
    public function getClientStatusReport():array
    {
        $report['series'] = [];
        $report['labels'] = [];

        $dataA = count(Client::where('status', 'Active')->get());
        $dataD = count(Client::where('status', 'Dormant')->get());

        array_push($report['labels'], 'Active', 'Dormant');
        array_push($report['series'],$dataA,$dataD);

        return $report;
    }

    /**
     * @return array
     */
    public function getAssetTypesReport():array
    {
        $report['series'] = [];
        $report['labels'] = [];

        $dataL = count(Asset::where('type', 'Laptop')->get());
        $dataP = count(Asset::where('type', 'Phone')->get());
        $dataF = count(Asset::where('type', 'Furniture')->get());

        array_push($report['labels'], 'Laptop','Phone','Furniture');
        array_push($report['series'],$dataL,$dataP,$dataF);

        return $report;
    }

    /**
     * @return array
     */
    public function getAssetStatusReport():array
    {
        $report['series'] = [];
        $report['labels'] = [];

        $dataA = count(Asset::where('status', 'Active')->get());
        $dataS = count(Asset::where('status', 'Stolen/Lost')->get());
        $dataD = count(Asset::where('status', 'Damaged')->get());
        $dataR = count(Asset::where('status', 'In Repairs')->get());

        array_push($report['labels'], 'Active', 'Stolen/Lost', 'Damaged', 'In Repairs');
        array_push($report['series'],$dataA,$dataS,$dataD,$dataR);

        return $report;
    }

    /**
     * @return array
     */
    public function getEmployeeTypesReport():array
    {
        $report['series'] = [];
        $report['labels'] = [];

        $dataA = count(User::where('role', EmployeeTitles::ADMINISTRATOR)->get());
        $dataO = count(User::where('role', EmployeeTitles::OPS_MANAGER)->get());
        $dataC = count(User::where('role', EmployeeTitles::CEO)->get());
        $dataB = count(User::where('role', EmployeeTitles::BUSINESS_DEVELOPER)->get());
        $dataT = count(User::where('role', EmployeeTitles::TAX_CONSULTANTS)->get());
        $dataH = count(User::where('role', EmployeeTitles::HR_MANAGER)->get());

        array_push($report['labels'], EmployeeTitles::ADMINISTRATOR,EmployeeTitles::OPS_MANAGER, EmployeeTitles::CEO, EmployeeTitles::BUSINESS_DEVELOPER,EmployeeTitles::TAX_CONSULTANTS, EmployeeTitles::HR_MANAGER);
        array_push($report['series'],$dataA,$dataO,$dataC,$dataB,$dataT,$dataH);

        return $report;
    }

    /**
     * @return array
     */
    public function getEmployeeStatusReport():array
    {
        $report['series'] = [];
        $report['labels'] = [];

        $dataA = count(User::where('employee_status', 'Active')->get());
        $dataR = count(User::where('employee_status', 'Resigned')->get());
        $dataF = count(User::where('employee_status', 'Fired/Dismissed')->get());
        $dataRt = count(User::where('employee_status', 'Retired')->get());

        array_push($report['labels'], 'Active', 'Resigned','Fired/Dismissed','Retired');
        array_push($report['series'],$dataA,$dataR,$dataF,$dataRt);

        return $report;
    }

    /**
     * @param $data
     * @return Collection
     */
    public function getAuditReport($data):Collection
    {
        $name = null;
        if (isset($data['name'])) {
            $start = $data['start_date'];
            $end = $data['end_date'];
            $name = $data['name'];
            $type = $data['type'];
        } else {
            $start = $data['start_date'];
            $end = $data['end_date'];
            $type = $data['type'];
        }

        if ($name) {
            $report = AuditTrail::where('name', $name)->where('description', $type)->whereBetween('created_at', [$start, $end])->get();
        } else {
            $report = AuditTrail::where('description', $type)->whereBetween('created_at', [$start, $end])->get();
        }

        return $report;
    }
}
