<?php

namespace App\Models;

use App\Helper\MyHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Audit extends Model
{
    public static function getAuditDT($data)
    {
        return  DB::select('sp_CashSalesAudit_Get ' . MyHelper::generateQM($data), $data);
    }

    public static function getImage($data)
    {
        return DB::select('sp_Image_Get ' . MyHelper::generateQM($data), $data);
    }

    public static function insertRemStatus($data)
    {
        return DB::select('sp_RemarkStatus_InsertUpdate ' . MyHelper::generateQM($data),$data);
    }
}
