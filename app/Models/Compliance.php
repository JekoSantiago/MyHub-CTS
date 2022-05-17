<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Compliance extends Model
{
    public static function getCompliance($data)
    {
        return DB::select('sp_Compliance_Get ?,?,?', $data);
    }
}
