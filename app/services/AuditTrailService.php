<?php

namespace App\services;

use App\Models\AuditTrail;
use Illuminate\Support\Facades\Auth;

class AuditTrailService
{

    /**
     * @param $objectId
     * @param $auditType
     * @return void
     */
    public function logAuditTrail($objectId, $auditType): void
    {
        $user = Auth::user();
        $request = request();
        $ipAddress = $request->ip();

        AuditTrail::create([
            'object_id' => $objectId,
            'description' => (string) $auditType,
            'name' => $user['email'],
            'ip_address' => $ipAddress,
        ]);
    }

}
