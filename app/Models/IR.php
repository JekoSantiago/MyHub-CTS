<?php

namespace App\Models;

use App\Helper\MyHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class IR extends Model
{
    public static function getIR($data)
    {
        return DB::select('ATPI_CashDeposit.dbo.[sp_IR_Get] ' . MyHelper::generateQM($data), $data);
    }

    public static function getStatus($data)
    {
        return DB::select('ATPI_CashDeposit.dbo.sp_IRStatus_Get ' . MyHelper::generateQM($data), $data);
    }

    public static function saveIR($data)
    {
        return DB::select('ATPI_CashDeposit.dbo.sp_IR_InsertUpdate ' . MyHelper::generateQM($data), $data);
    }

    public static function reportIR($data)
    {
        return DB::select('ATPI_CashDeposit.dbo.[sp_Report_IR_Get] ' . MyHelper::generateQM($data), $data);
    }

    public static function getEmailNotif($data)
    {
        return DB::select('ATPI_CashDeposit.dbo.[sp_EmailNotif_Get] ' . MyHelper::generateQM($data), $data);
    }
}
