<?php

namespace App\Models;

use App\Helper\MyHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Common extends Model
{
    public static function getUserModuleRole($data)
    {
        $moduleRoleID     = $data['moduleRoleID'];
        $appID            = $data['appID'];
        $moduleID         = $data['moduleID'];
        $roleID           = $data['roleID'];

        $result = DB::select('UserMgt.dbo.sp_User_ModuleRole_Get ?,?,?,?', [$moduleRoleID,$appID,$moduleID,$roleID]);
        return $result;
    }


    public static function getLocation($data)
    {
        return DB::select('ATPI_HR.dbo.sp_Location_Get ?',[$data]);
    }

    public static function getShift()
    {
        return DB::select('sp_Shift_get');
    }

    public static function getStores($data)
    {
        return DB::select('sp_StoresAMAC_Get ?,?', $data);
    }

    public static function getEmpCTS($data)
    {
        return DB::select('sp_EmpCTS_Get ?', $data);
    }


}
