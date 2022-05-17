<?php

namespace App\Http\Controllers;

use App\Models\Common;
use App\Helper\MyHelper;
use App\Models\Cts;
use App\Models\Monitoring;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class PageController extends Controller
{


    public function CTS()
    {
        MyHelper::checkSession();

        $data['title']= 'Denomination';

        $loc = Common::getLocation(MyHelper::decrypt(Session::get('Location_ID')));
        $shift = Common::getShift();
        $denom = Cts::getDenom();


        $data['loc'] = $loc[0];
        $data['shift'] = $shift;
        $data['denom'] = $denom;

        JavaScriptFacade::put([
            'userID' =>  MyHelper::decrypt(Session::get('Employee_ID'))
        ]);

        return view('pages.CTS.index',$data);

    }

    public function monitoring()
    {
        MyHelper::checkSession();

        $data['title'] = 'Monitoring';

        $param = [
            MyHelper::decrypt(Session::get('Employee_ID')),
            MyHelper::decrypt(Session::get('Department_ID'))
        ];

        JavaScriptFacade::put([
            'DeptID' =>   MyHelper::decrypt(Session::get('Department_ID')),
            'OpsID'  =>   env('OPS_DEPT_ID'),
            'userID' =>  MyHelper::decrypt(Session::get('Employee_ID'))
        ]);

        $stores = Common::getStores($param);


        $data['stores'] = $stores;

        return view('pages.monitoring.index', $data);
    }

    public function tallySheet(Request $request)
    {
        MyHelper::checkSession();
        $ctsNo = $request->segment(2);
        $shift = Common::getShift();
        $emp = Common::getEmpCTS([$ctsNo]);
        $data['title'] = 'Tally Sheet';
        $data['CTSNo'] = $ctsNo;
        $data['shift'] = $shift;
        $data['employee'] = $emp;
        $data['isOps'] = MyHelper::checkDept(MyHelper::decrypt(Session::get('Department_ID')));
        $data['info'] = Monitoring::getCTSInfo([$ctsNo,0]);


        return view('pages.monitoring.tallysheet',$data);
    }

    public function compliance(Request $request)
    {
        MyHelper::checkSession();

        $data['title'] = 'Compliance';
        $param = [
            MyHelper::decrypt(Session::get('Employee_ID')),
            MyHelper::decrypt(Session::get('Department_ID'))
        ];

        $stores = Common::getStores($param);

        $data['stores'] = $stores;
        return view('pages.compliance.index', $data);

    }


}
