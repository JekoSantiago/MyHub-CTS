<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use App\Models\Compliance;
use Illuminate\Http\Request;

class ComplianceController extends Controller
{

    public function getCompliance(Request $request)
    {
        MyHelper::checkSession();

        $param = [
            $request -> filter_dateFrom,
            $request -> filter_dateTo,
            $request -> filter_store,
        ];

        $data = Compliance::getCompliance($param);

        return datatables($data)->toJson();
    }
}
