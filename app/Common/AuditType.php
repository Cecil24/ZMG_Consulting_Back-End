<?php

namespace App\Common;

enum AuditType
{
    public const LOG_IN = 'LOGGED IN';
    public const LOG_OUT = 'LOGGED OUT';
    public const ERROR = 'ERROR';
    public const CAPTURED_EMPLOYEE = 'CAPTURED EMPLOYEE';
    public const UPDATED_PASSWORD = 'UPDATED PASSWORD';
    public const UPDATED_EMPLOYEE = 'UPDATED EMPLOYEE';
    public const CAPTURED_ASSET = 'CAPTURED ASSET';
    public const UPDATED_ASSET = 'UPDATED ASSET';
    public const CAPTURED_CLIENT = 'CAPTURED CLIENT';
    public const UPDATED_CLIENT = 'UPDATED CLIENT';
    public const REQUESTED_DOCUMENTS = 'REQUESTED DOCUMENTS';

}
