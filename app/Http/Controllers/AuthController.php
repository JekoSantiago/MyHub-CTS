<?php

namespace App\Http\Controllers;

use App\Models\Common;
use Illuminate\Http\Request;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Session;
use App\Helper\MyHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Throwable;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;
use Laracasts\Utilities\JavaScript;

class AuthController extends Controller
{
    public function index()
    {
        // dd(request());
        try
        {
            $userEmpID= MyHelper::decryptMYHUB($_COOKIE['Usr_ID']);
        }
        catch (Throwable $e)
        {
            return redirect()->away(env('MYHUB_URL'));
        }


        $userDetails = UserDetails::getUserDetails($userEmpID);


        if(count($userDetails) > 0)
        {
            $data['moduleRoleID'] = 0;
            $data['appID']        = env('APP_ID');
            $data['moduleID']     = 0;
            $data['roleID']       = $userDetails[0]->Role_ID;

            $userAccess = Common::getUserModuleRole($data);
            $sessionAccess =[];
            foreach($userAccess as $access):
                array_push($sessionAccess,array(
                'Module_ID'=>$access->Module_ID,
                'Action_ID'=>$access->Action_ID,
                'ActionName'=>$access->ActionName));
            endforeach;


                Session::put('UserAccess',       $sessionAccess);
                Session::put('Employee_ID',      MyHelper::encrypt($userDetails[0]->Emp_ID));
                Session::put('EmployeeNo',       MyHelper::encrypt($userDetails[0]->EmployeeNo));
                Session::put('FullName',         MyHelper::encrypt($userDetails[0]->empl_name));
                Session::put('Role_ID',          MyHelper::encrypt($userDetails[0]->Role_ID));
                Session::put('Department_ID',    MyHelper::encrypt($userDetails[0]->Department_ID));
                Session::put('Department',       MyHelper::encrypt($userDetails[0]->Department));
                Session::put('Email',            MyHelper::encrypt($userDetails[0]->Email));
                Session::put('Location_ID',      MyHelper::encrypt($userDetails[0]->SLocation_ID));
                Session::put('Location',         MyHelper::encrypt($userDetails[0]->SLocation));
                Session::put('Position',         MyHelper::encrypt($userDetails[0]->Position));

                Session::save();

                $checkAccessParams['userAccess'] = $sessionAccess;
                $checkAccessParams['moduleID'] = env('MODULE_COMP');
                if(MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ALL')]) && $userDetails[0]->Department_ID == env('OPS_DEPT_ID'))
                {
                    return redirect(route('compliance'));
                }
                else
                {
                    return redirect(route('monitoring'));
                }
            }
            else
            {
            return  redirect('/error/401');
            }


    }
    public function logout()
    {
        Artisan::call('cache:clear');
        Session::flush();
        return  Redirect::to(env('MYHUB_LOGOUT_URL'));
    }
}
