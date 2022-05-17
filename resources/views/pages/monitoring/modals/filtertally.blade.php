@php
use App\Helper\MyHelper;
use Illuminate\Support\Facades\Session;
@endphp
<div id="modal_filter_tally" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Filter Form</h4>
            </div>
            <div class="modal-body">
                <form id="form_filter_cts">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="filter_emp">Employee</label>
                                <select id="filter_emp" name="filter_emp" class="form-control" @if($isOps) disabled @endif>
                                    <option value = 0> ALL </option>
                                    @foreach($employee as $emp)
                                    <option value="{{ $emp->Employee_ID }}" @if($isOps && $emp->Employee_ID == MyHelper::decrypt(Session::get('Employee_ID'))) selected @endif>{{ $emp->FullName }}</option>
                                    @endforeach
                                </select>
                                <label class="invalid-feedback" id="filter_emp_error">Store is required.</label>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col">
                                <label for="filter_shift">Shift</label>
                                <select id="filter_shift" name="filter_shift" class="form-control">
                                    @if(Myhelper::decrypt(Session::get('Department_ID')) != 17)
                                    <option value="0"> ALL </option>
                                    @endif
                                    @foreach($shift as $s)
                                    <option value="{{ $s->Shift_ID }}">{{ $s->Shift}}</option>
                                    @endforeach
                                </select>
                                <label class="invalid-feedback" id="filter_shift_error">shift is required.</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div>
                            <button type="button" class="btn btn-light waves-effect waves-light" data-dismiss="modal">Close</button>
                            <button type="button" id="btn_filter_tally" class="btn btn-primary waves-effect waves-light">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
