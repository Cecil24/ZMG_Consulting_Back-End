<?php

namespace App\services;

use App\Common\Roles;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class EmployeeService
{
    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function captureEmployee($data): User
    {

        //Create User
        $employee = User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => 'Zmg@123#',
            'employee_number' => $data['employee_number'],
            'phone_number' => $data['phone_number'],
            'gender' => $data['gender'],
            'race' => $data['race'],
            'marital_status' => $data['marital_status'],
            'next_kin' => $data['next_kin'],
            'kin_number' => $data['kin_number'],
            'start_date' => $data['start_date'],
            'employee_status' => $data['employee_status'],
            'id_number' => $data['id_number'],
            'date_of_birth' => $data['date_of_birth'],
            'tax_number' => $data['tax_number'],
            'disability' => $data['disability'],
            'disabilityYes' => $data['disabilityYes']
        ]);

        //Assign Role
        switch ($data['role']){
            case 'CEO':
                $employee->assignRole(strtoupper(Roles::CEO));
                break;

            case 'Administrator':
                $employee->assignRole(strtoupper(Roles::ADMINISTRATOR));
                break;

            case 'HR Manager':
                $employee->assignRole(strtoupper(Roles::HR_MANAGER));
                break;

            case 'OPS Manager':
                $employee->assignRole(strtoupper(Roles::OPS_MANAGER));
                break;

            case 'Tax/Accounting Consultant':
                $employee->assignRole(strtoupper(Roles::TAX_CONSULTANTS));
                break;

            case 'Business Developer':
                $employee->assignRole(strtoupper(Roles::BUSINESS_DEVELOPER));
                break;
        }

        AttachmentService::processAttachedFiles($data, $employee);

        return $employee;
    }
}
