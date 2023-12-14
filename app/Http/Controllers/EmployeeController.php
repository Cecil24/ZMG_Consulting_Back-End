<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\GetEmployeeRequest;
use App\services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class EmployeeController extends Controller
{
    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function captureEmployee(EmployeeRequest $request, EmployeeService $service): Response
    {
        return $this->json($service->captureEmployee($request)->toArray());
    }

    /**
     * @param EmployeeService $service
     * @return Response
     */
    public function getEmployees(EmployeeService $service): Response
    {
        return $this->json($service->getEmployees()->toArray());
    }

    /**
     * @param GetEmployeeRequest $request
     * @param EmployeeService $service
     * @return Response
     */
    public function getEmployee(GetEmployeeRequest $request,EmployeeService $service): Response
    {
        return $this->json($service->getEmployee($request->validated())->toArray());
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function updateEmployee(EmployeeRequest $request, EmployeeService $service): Response
    {
        return $this->json($service->updateEmployee($request)->toArray());
    }
}
