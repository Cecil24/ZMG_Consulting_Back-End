<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
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
}
