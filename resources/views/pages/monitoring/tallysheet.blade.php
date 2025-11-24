@extends('layouts.main')

@section('css_plugins')
    <link href="{{asset('assets/libs/c3/c3.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')

@php
use App\Helper\MyHelper;
$checkAccessParams['userAccess'] = Session::get('UserAccess');
@endphp

<div id="preloader">
    <div id="status">
        <div class="spinner">Loading...</div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ env('APP_NAME') }}</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ $title }}</h4>
            </div>
        </div>
    </div>
</div>


<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="text-sm-right">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-2 mr-1" data-toggle="modal" data-target="#modal_filter_tally"><i class="mdi mdi-filter-menu"></i></button>
                        </div>
                        @php $checkAccessParams['moduleID'] = env('MODULE_MONITORING');@endphp
                        @if(MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ALL'),env('APP_ACTION_PRINT')]))
                        <div>
                            <button type="button" class="btn btn-success waves-effect waves-light mb-2 mr-1"  id="printcts"><i class="mdi mdi-printer"></i></button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-5"><h4>CTS # {{ $CTSNo }} </h4></div>
                <div class="col-4"><h4 id="t-shift"></h4></div>
            </div>
            <div class="row">
                <div class="col"><h5>{{ $info[0]->Store  }}</h5></div>
            </div>
            <input type="hidden" id="CTSNo" value="{{ $CTSNo }}">
            <table id="tbl_denum" class="table table-centered table-bordered w-100 nowrap text-center">
                <thead>
                    <tr>
                        <th rowspan="3">CASH</th>
                        <th colspan="8">CONSOLIDATED CASH SALES COLLECTION AS OF {{ strtoupper(date('F d, Y',strtotime($info[0]->CTSDate))) }}</th>
                        <th colspan="2" rowspan="2">END OF SHIFT</th>
                        <th colspan="2" rowspan="2">OVERALL TOTAL</th>
                    </tr>
                    <tr>
                        <th colspan="2">1ST PICK-UP</th>
                        <th colspan="2">2ND PICK-UP</th>
                        <th colspan="2">3RD PICK-UP</th>
                        <th colspan="2">4TH PICK-UP</th>

                    </tr>
                    <tr>
                        <th>QTY</th>
                        <th>AMOUNT</th>
                        <th>QTY</th>
                        <th>AMOUNT</th>
                        <th>QTY</th>
                        <th>AMOUNT</th>
                        <th>QTY</th>
                        <th>AMOUNT</th>
                        <th>QTY</th>
                        <th>AMOUNT</th>
                        <th>QTY</th>
                        <th>AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th>TOTAL CASH:</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="11" class="text-left" >LESS: LOOSE CHANGE FUND</th>
                        <th colspan="2" id="lcf"></th>
                    </tr>
                    <tr>
                        <th colspan="11" class="text-left">TOTAL CASH SALES DURING THE DAY</th>
                        <th colspan="2" id="tcs"></th>
                    </tr>
                    <tr>
                        <th colspan="11" class="text-left">&emsp; POS SALES</th>
                        <th colspan="2" id="ps"></th>
                    </tr>
                    <tr>
                        <th colspan="11" class="text-left">&emsp; E-SERVICES</th>
                        <th colspan="2" id="es"></th>
                    </tr>
                    <tr>
                        <th colspan="11" class="text-left">LESS: CHECK ENCASHMENT</th>
                        <th colspan="2" id="lcc"></th>
                    </tr>
                    <tr>
                        <th colspan="11" class="text-left">NET CASH COLLECTION DURING THE DAY</th>
                        <th colspan="2" id="net"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</div>

@include('pages.monitoring.modals.filtertally')

@endsection
@section('js_plugins')
    {{-- <script src="{{asset('assets/libs/d3/d3.min.js')}}"></script>
    <script src="{{asset('assets/libs/c3/c3.min.js')}}"></script> --}}
@endsection

@section('js')
    <script src="{{asset('assets/js/custom/tally.js')}}"></script>
@endsection
