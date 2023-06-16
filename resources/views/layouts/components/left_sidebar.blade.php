@php
use App\Helper\MyHelper;
$checkAccessParams['userAccess'] = Session::get('UserAccess');
@endphp
<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li class="menu-title">Navigation</li>
                @php $checkAccessParams['moduleID'] = env('MODULE_MONITORING');@endphp
                @if(MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ALL'),env('APP_ACTION_VIEW')]))
                <li>
                    <a href="{{route('monitoring')}}">
                        <i data-feather="monitor"></i>
                        <span> Monitoring </span>
                    </a>
                </li>
                @endif
                @php $checkAccessParams['moduleID'] = env('MODULE_DENOM');@endphp
                @if(MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ALL'),env('APP_ACTION_ADD')]))
                <li>
                    <a href="{{route('cts')}}">
                        <i>&#8369;</i>
                        <span> Encoding </span>
                    </a>
                </li>
                @endif
                @php $checkAccessParams['moduleID'] = env('MODULE_COMP');@endphp
                @if(MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ALL'),env('APP_ACTION_ADD')]))
                <li>
                    <a href="{{route('compliance')}}">
                        <i data-feather="user-check"></i>
                        <span> Compliance </span>
                    </a>
                </li>
                @endif
                @if(Myhelper::decrypt(Session::get('Department_ID')) == 20 || Myhelper::decrypt(Session::get('Role_ID')) == 1)
                <li>
                    <a href="{{route('audit')}}">
                        <i data-feather="file-text"></i>
                        <span> Cash Sales Deposit Audit Monitoring </span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
