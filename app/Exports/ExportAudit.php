<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;




class ExportAudit implements FromView
{
    private $data;

	public function __construct($data)
	{
		$this->data = $data;
	}

	public function view(): View
	{

        $audit = $this->data;
        $data['audit'] = $audit;

		return view('reports.audit',$data);
	}
}
