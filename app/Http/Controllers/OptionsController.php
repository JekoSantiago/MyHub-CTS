<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use App\Models\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OptionsController extends Controller
{


    public function getStatus()
    {
       return Common::getStatus();
    }

    public function getAM(Request $request)
    {

        $param = [
            $request ->dc,
        ];

        $data = Common::getAM($param);

        $output = '<option></option>';

        foreach($data as $am) :
            $output .= '<option value="'. $am->AM_ID .'">'. $am->AreaManager .'</option>';
        endforeach;

        echo $output;
    }

    public function getAC(Request $request)
    {

        $param = [
            0,
            0,
            $request->am,
        ];

        $data = Common::getAC($param);

        $output = '<option></option>';

        foreach($data as $ac) :
            $output .= '<option value="'. $ac->AC_ID .'">'. $ac->AreaCoordinator .'</option>';
        endforeach;

        echo $output;
    }

    public function getStoreAC(Request $request)
    {

        $param = [
            $request->ac,
        ];

        $data = Common::getStoreAC($param);

        $output = '<option></option>';

        foreach($data as $s) :
            $output .= '<option value="'. $s->Location_ID .'">'. $s->LocationCode . ' - ' . $s->Location . '</option>';
        endforeach;

        echo $output;
    }


}
