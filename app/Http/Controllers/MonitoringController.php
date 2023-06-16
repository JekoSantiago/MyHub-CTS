<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use App\Models\Cts;
use App\Models\Monitoring;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{

    public function getMCTS(Request $request)
    {
        MyHelper::checkSession();

        $param = [
            $request -> filter_dateFrom,
            $request -> filter_dateTo,
            $request -> filter_store,
            MyHelper::decrypt(Session::get("Employee_ID"))
        ];

        $data = Monitoring::getmCTS($param);

        return datatables($data)->toJson();

    }


    public function getTallySheet(Request $request)
    {
        MyHelper::checkSession();

        $param = [
            $request->ctsNo,
            $request->filter_emp,
            $request->filter_shift,
            MyHelper::decrypt(Session::get("Employee_ID"))
        ];

        $data = Monitoring::getTallySheet($param);

        return datatables($data)->toJson();
    }

}
