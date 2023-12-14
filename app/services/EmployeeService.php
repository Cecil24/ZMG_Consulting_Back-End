<?php

namespace App\services;

use App\Common\Roles;
use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Collection;
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
            'role' => $data['role'],
            'marital_status' => $data['marital_status'],
            'next_kin' => $data['next_kin'],
            'kin_number' => $data['kin_number'],
            'start_date' => $data['start_date'],
            'employee_status' => $data['employee_status'],
            'id_number' => $data['id_number'],
            'date_of_birth' => $data['date_of_birth'],
            'tax_number' => $data['tax_number'],
            'disability' => $data['disability'],
            'disabilityYes' => $data['disabilityYes'],
            'bank_details' => $data['bank_details'],
            'benefit_details' => $data['benefit_details'],
            'address_details' => $data['address_details'],
            'office' => $data['office'],

        ]);

        $noteService = new NoteService();
        $noteService->captureNote($data['note'],$employee->id,'EMPLOYEE');

        //Assign Role
        $this->assignRole($employee,$data['role']);

        AttachmentService::processAttachedFiles($data, $employee);

        return $employee;
    }

    /**
     * @return Collection
     */
    public function getEmployees(): Collection
    {
        return User::get();
    }

    /**
     * @param $id
     * @return User
     */
    public function getEmployee($id): User
    {
        $employee = User::where('id',$id)->first();
        $employee->notes = Note::with('By')->where('type','EMPLOYEE')->where('object_id', $id)->get();
        $media = $employee->getMedia('media');
        $employee->media = $media ?: null;

        return $employee;
    }

    /**
     * @param $data
     * @return User
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws \Exception
     */
    public function updateEmployee($data):User
    {
        $employee = User::where('id', $data['id'])->first();

        if($employee !== null){
            //Update Employee
            $employee->name = $data['name'];
            $employee->surname = $data['surname'];
            $employee->email = $data['email'];
            $employee->employee_number = $data['employee_number'];
            $employee->phone_number = $data['phone_number'];
            $employee->gender = $data['gender'];
            $employee->race = $data['race'];
            $employee->role = $data['role'];
            $employee->marital_status = $data['marital_status'];
            $employee->next_kin = $data['next_kin'];
            $employee->kin_number = $data['kin_number'];
            $employee->start_date = $data['start_date'];
            $employee->employee_status = $data['employee_status'];
            $employee->id_number = $data['id_number'];
            $employee->date_of_birth = $data['date_of_birth'];
            $employee->tax_number = $data['tax_number'];
            $employee->disability = $data['disability'];
            $employee->disabilityYes = $data['disabilityYes'];
            $employee->bank_details = $data['bank_details'];
            $employee->benefit_details = $data['benefit_details'];
            $employee->address_details = $data['address_details'];
            $employee->office = $data['office'];

            $employee->save();
        }else{
            throw new \Exception('Employee not found');
        }

        $noteService = new NoteService();
        $noteService->captureNote($data['note'],$employee->id,'EMPLOYEE');

        //Remove any roles already assigned
        $employee->roles()->detach();

        //Assign Role
        $this->assignRole($employee,$data['role']);

        AttachmentService::processAttachedFiles($data, $employee);

        return $employee;
    }

    /**
     * @param $model
     * @param $role
     * @return void
     */
    public function assignRole ($model,$role):void
    {
        //Assign Role
        switch ($role){
            case 'CEO':
                $model->assignRole(strtoupper(Roles::CEO));
                break;

            case 'Administrator':
                $model->assignRole(strtoupper(Roles::ADMINISTRATOR));
                break;

            case 'HR Manager':
                $model->assignRole(strtoupper(Roles::HR_MANAGER));
                break;

            case 'OPS Manager':
                $model->assignRole(strtoupper(Roles::OPS_MANAGER));
                break;

            case 'Tax/Accounting Consultant':
                $model->assignRole(strtoupper(Roles::TAX_CONSULTANTS));
                break;

            case 'Business Developer':
                $model->assignRole(strtoupper(Roles::BUSINESS_DEVELOPER));
                break;
        }
    }

}
