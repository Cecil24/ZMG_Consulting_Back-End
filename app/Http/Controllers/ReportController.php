<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuditRequest;
use App\services\ReportService;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    /**
     * @param ReportService $service
     * @return Response
     */
    public  function getClientTypesReport(ReportService $service): Response
    {
        return $this->json($service->getClientTypesReport());
    }

    /**
     * @param ReportService $service
     * @return Response
     */
    public  function getClientStatusReport(ReportService $service): Response
    {
        return $this->json($service->getClientStatusReport());
    }

    /**
     * @param ReportService $service
     * @return Response
     */
    public  function getAssetTypesReport(ReportService $service): Response
    {
        return $this->json($service->getAssetTypesReport());
    }

    /**
     * @param ReportService $service
     * @return Response
     */
    public  function getAssetStatusReport(ReportService $service): Response
    {
        return $this->json($service->getAssetStatusReport());
    }

    /**
     * @param ReportService $service
     * @return Response
     */
    public  function getEmployeeTypesReport(ReportService $service): Response
    {
        return $this->json($service->getEmployeeTypesReport());
    }

    /**
     * @param ReportService $service
     * @return Response
     */
    public  function getEmployeeStatusReport(ReportService $service): Response
    {
        return $this->json($service->getEmployeeStatusReport());
    }

    /**
     * @param ReportService $reportService
     * @param AuditRequest $request
     * @return Response
     */
    public function getAuditReport(ReportService $reportService, AuditRequest $request): Response
    {
        return $this->json($reportService->getAuditReport($request->validated())->toArray());
    }
}
