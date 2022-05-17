<!-- Global Javascript -->
<script src="{{asset('assets/js/vendor.min.js')}}"></script>
<script src="{{asset('assets/js/app.min.js')}}"></script>
<script type="text/javascript">
    var WebURL = {!! json_encode(url('/')) !!}
</script>


<!-- Plugins Javascript -->
<script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/libs/idle-timer/idletimer.js')}}"></script>
<script src="{{asset('assets/libs/jquery-session/jquery-session.js')}}"></script>
<script src="{{asset('assets/libs/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
@yield('js_plugins')

<!-- Custom Javascript -->
<script src="{{asset('assets/js/custom/main.js')}}"></script>
{{-- <script src="{{asset('assets/js/custom/session_timeout.js')}}"></script> --}}
@yield('js')
