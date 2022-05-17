@extends('layouts.main')

@section('css_plugins')
    {{-- <link href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css"/> --}}
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
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-2 mr-1" data-toggle="modal" data-target="#modal_filter_comp"><i class="mdi mdi-filter-menu"></i></button>
                        </div>
                        <div>
                            <button type="button" id="comp_dl" class="btn btn-success waves-effect waves-light mb-2 mr-1"><i class="mdi mdi-download"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <table id="tbl_comp" class="table table-centered w-100 nowrap text-center">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Graveyard</th>
                        <th>Opening</th>
                        <th>Midshift</th>
                        <th>Closing</th>
                        <th>OverAll</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

@include('pages.compliance.modals.filter')

@endsection

@section('js_plugins')
    {{-- <script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script> --}}
@endsection

@section('js')
    <script src="{{asset('assets/js/custom/compliance.js')}}"></script>
@endsection
