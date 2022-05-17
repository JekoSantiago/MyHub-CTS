<?php

namespace App\Exports;

use App\Cms;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;




class ExportComp implements FromView
{
    private $data;

	public function __construct($data)
	{
		$this->data = $data;
	}

	public function view(): View
	{

        $comp = $this->data;

        $data['comp'] = $comp;


		return view('reports.compliance',$data);
	}
}
