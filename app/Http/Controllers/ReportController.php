<?php

namespace App\Http\Controllers;

use App\Exports\ExportAudit;
use App\Exports\ExportComp;
use App\Exports\ExportCTS;
use App\Helper\MyHelper;
use App\Models\Audit;
use App\Models\Compliance;
use App\Models\Monitoring;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function exportCTS(Request $request)
    {
        MyHelper::checkSession();

        $param = [
            $request->segment(2),
            MyHelper::decrypt(Session::get('Employee_ID')),
            $request->segment(3),
        ];

        $param2 = [
            $request->segment(2),
            $request->segment(3),
        ];

        $tally = Monitoring::getTallySheet($param);

        $info = Monitoring::getCTSInfo($param2);
        // dd($info);

        $p1Tot = 0;
        $p2Tot = 0;
        $p3Tot = 0;
        $p4Tot = 0;
        $p5Tot = 0;

        foreach($tally as $t)
        {
            $p1Tot += $t->P1_Amount;
            $p2Tot += $t->P2_Amount;
            $p3Tot += $t->P3_Amount;
            $p4Tot += $t->P4_Amount;
            $p5Tot += $t->P5_Amount;
        }

        $totcash = $p1Tot + $p2Tot + $p3Tot + $p4Tot + $p5Tot ;
        $data['info'] = $info;
        $data['tally'] = $tally;
        $data['cts'] =  $request->segment(2);
        $data['p1tot'] = number_format((float)$p1Tot, 2, '.', '');
        $data['p2tot'] = number_format((float)$p2Tot, 2, '.', '');
        $data['p3tot'] = number_format((float)$p3Tot, 2, '.', '');
        $data['p4tot'] = number_format((float)$p4Tot, 2, '.', '');
        $data['p5tot'] = number_format((float)$p5Tot, 2, '.', '');
        $data['totcash'] = number_format((float)$totcash, 2, '.', '');
        $data['name'] = MyHelper::decrypt(Session::get('FullName'));
        $data['position'] = MyHelper::decrypt(Session::get('Position'));


        $invoice = Pdf::loadView('reports.ctsreport',$data)->setPaper('letter', 'landscape');
        // Instead of saving the PDF, directly stream it
        return $invoice->stream();
    }


    public function exportCompliance(Request $request)
    {
        MyHelper::checkSession();


        $params = base64_decode($request->segment(2));
        $detail = explode('@@', $params);
        $dateFrom  = $detail[0];
        $dateTo = $detail[1];
        $store   = $detail[2];

        $param = [
            $dateFrom,
            $dateTo,
            $store,
        ];


        $data = Compliance::getCompliance($param);
        $storecode = explode(' - ',$data[0]->Store);
        $filename = $storecode[0] . '_ComplianceReport_'.date('Ymd', strtotime($dateFrom)).'To'.date('Ymd', strtotime($dateTo)).'.xlsx';



        return Excel::download(new ExportComp($data), $filename);

    }

    public function exportCTSAll(Request $request)
    {
        MyHelper::checkSession();

        $param = [
            $request->segment(2),
            0,
            $request->segment(3),
        ];

        $tally = Monitoring::getTallySheet($param);

        $p1Tot = 0;
        $p2Tot = 0;
        $p3Tot = 0;
        $p4Tot = 0;
        $p5Tot = 0;

        foreach($tally as $t)
        {
            $p1Tot += $t->P1_Amount;
            $p2Tot += $t->P2_Amount;
            $p3Tot += $t->P3_Amount;
            $p4Tot += $t->P4_Amount;
            $p5Tot += $t->P5_Amount;
        }

        $totcash = $p1Tot + $p2Tot + $p3Tot + $p4Tot + $p5Tot ;

        $data['tally'] = $tally;
        $data['cts'] =  $request->segment(2);
        $data['p1tot'] = number_format((float)$p1Tot, 2, '.', '');
        $data['p2tot'] = number_format((float)$p2Tot, 2, '.', '');
        $data['p3tot'] = number_format((float)$p3Tot, 2, '.', '');
        $data['p4tot'] = number_format((float)$p4Tot, 2, '.', '');
        $data['p5tot'] = number_format((float)$p5Tot, 2, '.', '');
        $data['totcash'] = number_format((float)$totcash, 2, '.', '');
        $data['name'] = MyHelper::decrypt(Session::get('FullName'));
        $data['position'] = MyHelper::decrypt(Session::get('Position'));


        $invoice = Pdf::loadView('reports.ctsreport',$data)->setPaper('letter', 'landscape');
        $invoice->save(storage_path().'/app/public/'. $request->segment(2) .'.pdf');
        return $invoice->stream();
    }

    public function exportCTS2(Request $request)
    {
        MyHelper::checkSession();

        $param = [
            $request->segment(2),
            0,
            $request->segment(3),
        ];

        $param2 = [
            $request->segment(2),
            $request->segment(3),
        ];

        $tally = Monitoring::getTallySheet($param);

        $info = Monitoring::getCTSInfo($param2);
        // dd($info);

        $p1Tot = 0;
        $p2Tot = 0;
        $p3Tot = 0;
        $p4Tot = 0;
        $p5Tot = 0;

        foreach($tally as $t)
        {
            $p1Tot += $t->P1_Amount;
            $p2Tot += $t->P2_Amount;
            $p3Tot += $t->P3_Amount;
            $p4Tot += $t->P4_Amount;
            $p5Tot += $t->P5_Amount;
        }

        $totcash = $p1Tot + $p2Tot + $p3Tot + $p4Tot + $p5Tot ;
        $data['info'] = $info;
        $data['tally'] = $tally;
        $data['cts'] =  $request->segment(2);
        $data['p1tot'] = number_format((float)$p1Tot, 2, '.', '');
        $data['p2tot'] = number_format((float)$p2Tot, 2, '.', '');
        $data['p3tot'] = number_format((float)$p3Tot, 2, '.', '');
        $data['p4tot'] = number_format((float)$p4Tot, 2, '.', '');
        $data['p5tot'] = number_format((float)$p5Tot, 2, '.', '');
        $data['totcash'] = number_format((float)$totcash, 2, '.', '');
        $data['name'] = MyHelper::decrypt(Session::get('FullName'));
        $data['position'] = MyHelper::decrypt(Session::get('Position'));


        $invoice = Pdf::loadView('reports.ctsreport',$data)->setPaper('letter', 'landscape');
        $invoice->save(storage_path().'/app/public/'. $request->segment(2) .'.pdf');
        return $invoice->stream();
    }


    public function exportAudit(Request $request)
    {
        MyHelper::checkSession();


        $params = base64_decode($request->segment(2));
        $detail = explode('@@', $params);
        $dateFrom  = $detail[0];
        $dateTo = $detail[1];
        $store   = $detail[2];

        $param = [
            $dateFrom,
            $dateTo,
            $store,
            MyHelper::decrypt(Session::get('Employee_ID'))
        ];


        $data = Audit::getAuditDT($param);
        $filename = 'CashSales_Deposit_Audit_Monitoring'.date('Ymd', strtotime($dateFrom)).'To'.date('Ymd', strtotime($dateTo)).'.xlsx';


        return Excel::download(new ExportAudit($data), $filename);

    }
}
