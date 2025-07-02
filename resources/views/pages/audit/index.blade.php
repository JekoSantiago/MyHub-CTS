@extends('layouts.main')

@section('css_plugins')
    <link href="{{asset('assets/libs/c3/c3.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')

@php use App\Helper\MyHelper; @endphp

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
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-2 mr-1" data-toggle="modal" data-target="#modal_filter_audit"><i class="mdi mdi-filter-menu"></i></button>
                        </div>
                        {{-- <div>
                            <button type="button" id="audit_dl" class="btn btn-success waves-effect waves-light mb-2 mr-1"><i class="mdi mdi-download"></i></button>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <h3 id="filter_title"></h3>
                </div>
            </div>
            <table id="tbl_audit" class="table table-centered w-100 nowrap">
                <thead>
                    <tr>
                        <th>STORE</th>
                        <th>DPU FREQUENCY</th>
                        <th>SALES DATE</th>
                        <th style="width: 15%">STATUS</th>
                        <th>TREASURY <br> REMARKS</th>
                        <th class="text-center">CTS TOTAL NET <br> CASH COLLECTION</th>
                        <th>DPAS / DPR</th>
                        <th>VDS</th>
                        <th>DISCREPANCY</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

@include('pages.audit.modals.filter')
@include('pages.audit.modals.image')
@include('pages.audit.modals.remarks')



@endsection

@section('js_plugins')
    {{-- <script src="{{asset('assets/libs/d3/d3.min.js')}}"></script>
    <script src="{{asset('assets/libs/c3/c3.min.js')}}"></script> --}}
@endsection

@section('js')
    <script src="{{asset('assets/js/custom/audit.js')}}"></script>
@endsection
