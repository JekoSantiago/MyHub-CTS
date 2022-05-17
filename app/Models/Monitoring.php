<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Monitoring extends Model
{
    public static function getmCTS($data)
    {
        return DB::select('sp_MonitoringCTS_Get ?,?,?,?', $data);
    }

    public static function getTallySheet($data)
    {
        return DB::select('sp_TallySheet_Get ?,?,?', $data);
    }

    public static function getCTSInfo($data)
    {
       return DB::select('sp_RPTCTSInfo_Get ?,?', $data);
    }
}
