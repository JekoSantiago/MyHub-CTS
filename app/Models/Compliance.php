<?php

namespace App\Models;

use App\Helper\MyHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Compliance extends Model
{
    public static function getCompliance($data)
    {
        return DB::select('sp_Compliance_Get ' . MyHelper::generateQM($data), $data);
    }
}
