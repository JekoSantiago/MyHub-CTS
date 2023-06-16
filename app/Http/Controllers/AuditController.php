<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Helper\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuditController extends Controller
{
    public function getAuditDT(Request $request)
    {

        $param = [
            $request -> filter_dateFrom,
            $request -> filter_dateTo,
            $request -> filter_store,
            MyHelper::decrypt(Session::get('Employee_ID'))
        ];

        $data = Audit::getAuditDT($param);

        return datatables($data)->toJson();

    }

    public function getImage(Request $request)
    {

        $param = [
            $request->res[0],
            $request->res[1]

        ];

        // dd($param);
        $data = Audit::getImage($param);

        return $data;
    }
}
