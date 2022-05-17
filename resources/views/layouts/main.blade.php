<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ ($title ?? '') . ' | ' . env('APP_NAME') }}</title>
    <link rel="icon" href="{!! asset('assets/images/icon.png') !!}"/>
    @include('layouts.components.header_css')
</head>

<body data-layout='{"sidebar": {"size": "condensed"}}' @yield('body-extra')>
    <div id="wrapper">
        <input type="hidden" name="_token" id="globalToken" value="{{csrf_token()}}" />


        @include('layouts.components.topbar')
        @include('layouts.components.left_sidebar')

        <div class="content-page">
            <div class="content">
                @yield('content')
            </div>
            @include('layouts.components.footer')

        </div>
    </div>

    @include('layouts.components.footer_script')

</body>

</html>
