<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use App\Models\Cts;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CtsController extends Controller
{


    public function insertCTS(Request $request)
    {
        MyHelper::checkSession();

        $param = [
            $request -> cts_date,
            $request -> cts_store,
            $request -> cts_shift,
            MyHelper::decrypt(Session::get('Employee_ID'))
        ];

        $insert = Cts::insertCTS($param);

        $num = $insert[0]->RETURN;
        $msg = $insert[0]->Message;

        $result = array('num' => $num, 'msg' => $msg);
        return $result;

    }

    public function getCTS(Request $request)
    {
        MyHelper::checkSession();

        $param = [
            0,
            MyHelper::decrypt(Session::get('Location_ID')),
            $request -> filter_dateFrom,
            $request -> filter_dateTo,
            Myhelper::decrypt(Session::get('Employee_ID'))
        ];

        $data = Cts::getCTS($param);

        // dd($data);

        return datatables($data)->toJson();

    }

    public function insertDenom(Request $request)
    {
        MyHelper::checkSession();

        $data = $request->except('_token');

        $success = 0;
        $fail = 0;
        foreach ($data as $key => $value) {
            if(is_numeric($key) && $value > 0)
            {
                $param = [
                    intval($request->cts_ID),
                    $key,
                    $value,
                    intval($request->pickup_type),
                    intval($request->denom_lcf),
                    intval($request->denom_lcc),
                    Myhelper::decrypt(Session::get('Employee_ID'))
                ];

                $insert = Cts::insertDenom($param);

                $num = $insert[0]->RETURN;
                $msg = $insert[0]->Message;

                if($num<0)
                {
                    $result = array('num' => $num, 'msg' => $msg);
                    return $result;
                }
                else
                {
                    $success++;
                }

            }
        }

        if($success > 0)
        {
            $num = $success;
            $msg = $msg;

        }
        else
        {
            $num = -1;
            $msg = "Total encoded denomination is zero";
        }

        $result = array('num' => $num, 'msg' => $msg);
        return $result;

    }

    public function getPickupType(Request $request)
    {
        MyHelper::checkSession();

        $id = $request->segment(2);

        $pickup = Cts::getPickup([$id]);

        return $pickup;

    }

    public function tallySheet(Request $request)
    {
        MyHelper::checkSession();

        $data['title'] = 'Cashier Tally Sheet';
        $data['denum'] = Cts::getTallySheet();

        return view('pages.CTS.tallysheet', $data);
    }
}
