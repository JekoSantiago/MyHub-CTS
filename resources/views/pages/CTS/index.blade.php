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
                        {{-- @php
                         $checkAccessParams['userAccess'] = Session::get('UserAccess');
                         $checkAccessParams['moduleID'] = env('MODULE_EMP');
                        @endphp --}}
                        {{-- @if (MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ALL')]) || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ADD')])) --}}
                        <div class="text-sm-left">
                            <button type="button" data-toggle="modal" data-target="#modal_new_cts" class="btn btn-primary waves-effect waves-light mb-2 mr-1"><i class="mdi mdi-plus-circle mr-1"></i>Add New CTS</button>
                        </div>
                        {{-- @endif --}}
                        <div class="text-sm-right">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-2 mr-1" data-toggle="modal" data-target="#modal_filter_cts"><i class="mdi mdi-filter-menu"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <table id="tbl_CTS" class="table table-centered w-100 nowrap">
                <thead>
                    <tr>
                        <th style="width: 5% !important"></th>
                        <th>CTS #</th>
                        <th>Employee</th>
                        <th>Store</th>
                        <th>Date</th>
                        <th>Shift</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

@include('pages.CTS.modals.new_CTS')
@include('pages.CTS.modals.filter')
@include('pages.CTS.modals.denom')

@endsection

@section('js_plugins')
    {{-- <script src="{{asset('assets/libs/d3/d3.min.js')}}"></script>
    <script src="{{asset('assets/libs/c3/c3.min.js')}}"></script> --}}
@endsection

@section('js')
    <script src="{{asset('assets/js/custom/cts.js')}}"></script>
@endsection
