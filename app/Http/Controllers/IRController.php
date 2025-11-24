<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use App\Models\IR;
use App\Services\GoogleCloudServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class IRController extends Controller
{
    public function showIR($id)
    {
        $userID = MyHelper::decrypt(Session::get('Employee_ID'));
        $param = [
            $userID,
            $id,
        ];
        $data['info'] = IR::getIR($param);
        $data['status'] = IR::getStatus([]);
        $data['deptID'] = MyHelper::decrypt(Session::get('Department_ID'));
        $data['posID'] = MyHelper::decrypt(Session::get('PositionLevel_ID'));


        if (!is_null($data['info'][0]->Attachment)):
            $folder = 'ir/' . $data['info'][0]->Location_ID . '/' . $data['info'][0]->CLK_ID . '/' . $data['info'][0]->Attachment;
            $googleCloudService = new GoogleCloudServices();
            if ($googleCloudService->fileExists($folder)):
                $image = $googleCloudService->getTemporaryLink($folder);
                $data['image'] = $image;
                $data['basename'] =  $data['info'][0]->Attachment;
                $data['fileType'] =  $data['fileType'] = substr($data['info'][0]->Attachment, -3);
            endif;
        endif;
        return view('pages.audit.modals.content.ir_content', $data);
    }

    public function getIR($loc,$date)
    {
        $param = [
            MyHelper::decrypt(Session::get("Employee_ID")),
            0,
            $loc,
            $date,
            $date,
            0,
            0,
            0,
            1
        ];
        // dd($param);
        $ir = IR::getIR($param);

        // dd($data);
        return $ir;
    }

    public function saveIR(Request $request)
    {
        $userID = MyHelper::decrypt(Session::get('Employee_ID'));

        $param = [
            $userID,
            $request->ctsID,
            $request->ir_status,
            $request->ir_remarks
        ];


        $save = IR::saveIR($param);

        $num = $save[0]->RETURN;
        $msg = $save[0]->MESSAGE;

        if ($request->ir_status == 1):
            if ($num > 0):
                EmailController::sendEmailNotif($request->ctsID);
            endif;
        endif;

        $result = array('num' => $num, 'msg' => $msg);

        return $result;
    }

    public function downloadATC(Request $request)
    {
        $locationID = $request->query('location');
        $CLK_ID = $request->query('cts');
        $originalName = $request->query('file');

        $gcpPath = "ir/{$locationID}/{$CLK_ID}/{$originalName}";

        $googleCloudService = new \App\Services\GoogleCloudServices();
        $url = $googleCloudService->getTemporaryLink($gcpPath);

        $response = Http::get($url);
        if (!$response->ok()) {
            abort(404); // If the file is not found in GCS
        }
        $file = $response->body();
        $type = $response->header('Content-Type');

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        $response->header("Content-Disposition", "attachment; filename=\"{$originalName}\"");

        return $response;
    }



}
