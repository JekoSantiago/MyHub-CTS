<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use App\Models\Compliance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ComplianceController extends Controller
{

    public function getCompliance(Request $request)
    {
        MyHelper::checkSession();

        $param = [
            $request -> filter_dateFrom,
            $request -> filter_dateTo,
            $request -> filter_store,
            MyHelper::decrypt(Session::get("Employee_ID"))
        ];

        $data = Compliance::getCompliance($param);

        return datatables($data)->toJson();
    }
}
