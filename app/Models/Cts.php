<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cts extends Model
{
    public static function insertCTS($data)
    {
        return DB::select('sp_CTS_Insert ?,?,?,?', $data);
    }

    public static function getCTS($data)
    {
        return DB::select('sp_CTS_Get ?,?,?,?,?', $data);
    }

    public static function getDenom()
    {
        return DB::select('sp_Denom_Get');
    }

    public static function insertDenom($data)
    {
        return DB::select('sp_Denom_Insert ?,?,?,?,?,?,?,?',$data);
    }

    public static function getPickup($data)
    {
        return DB::select('sp_PickupType_Get ?', $data);
    }
}
