<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Helper\MyHelper;
use App\Services\GoogleCloudServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class AuditController extends Controller
{
    public function getAuditDT(Request $request)
    {

        $param = [
            $request -> filter_dateFrom,
            $request -> filter_dateTo,
            $request -> filter_store,
            MyHelper::decrypt(Session::get('Employee_ID')),
            $request -> filter_am,
            $request -> filter_ac,
            $request -> filter_status
        ];

        // dd($param);
        $data = Audit::getAuditDT($param);

        return datatables($data)->toJson();

    }

    public function getImage(Request $request)
    {

        $param = [
            $request->res[0],
            $request->res[1]

        ];
        $image = '';
        $type = $request->res[0];
        $id = $request->res[1];
        $loc = $request->res[2];
        $base_path = dirname(dirname(storage_path()));
        if($type == 1)
        {
            $folder = 'deposits';
        }
        else
        {
            $folder = 'validated-deposits';
        }
        $path =  $base_path . env('CSDA_STORAGE') . $folder . '/' . $loc . '/' . $id;
        if(File::exists($path)):
            $images = File::allFiles($path);
            if(count($images) > 0):
                $imagePath = $images[0]->getPathname();
                $image = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($imagePath));
            endif;
        else:
                $path = $folder . '/' . $loc . '/' . $id;
                $googleCloudService = new GoogleCloudServices();
                if ($googleCloudService->folderExists($path)):
                    $files = $googleCloudService->listFilesInFolder($path);
                    $data['images'] = [];
                    foreach ($files as $file) {
                        $data['images'][] = $googleCloudService->getTemporaryLink($file);
                    }
                    $image = $data['images'][0];

                    // dd($image);
                endif;
        endif;
        $data = Audit::getImage($param);

        foreach ($data as &$entry)
        {
            if ($entry->Image === null)
            {
                $entry->Image = $image; // Replace with your default image name
            }
        }

        // dd($data);
        return $data;
    }

    public function insertRemStatus(Request $request)
    {
        $param = [
            $request->locID,
            $request->salesDate,
            $request->status ? : 0,
            $request->new_tRemarks ? : NULL,
            MyHelper::decrypt(Session::get('Employee_ID')),
        ];

        // dd($param);

        $insert = Audit::insertRemStatus($param);


        $num = $insert[0]->RETURN;
        $msg = $insert[0]->Message;

        $result = array('num' => $num, 'msg' => $msg);
        return $result;

    }
}
