<?php

namespace App\Models;

use App\Helper\MyHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Monitoring extends Model
{
    public static function getmCTS($data)
    {
        return DB::select('sp_MonitoringCTS_Get ' . MyHelper::generateQM($data), $data);
    }

    public static function getTallySheet($data)
    {
        return DB::select('sp_TallySheet_Get ' . MyHelper::generateQM($data), $data);
    }

    public static function getCTSInfo($data)
    {
        return DB::select('sp_RPTCTSInfo_Get ' . MyHelper::generateQM($data), $data);
    }
}
