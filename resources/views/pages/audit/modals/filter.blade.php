<div id="modal_filter_audit" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                                <label for="filter_dateFrom">Sales Date From</label>
                                <input type="date" id="filter_dateFrom" name="filter_dateFrom" class="form-control flatpickr" value="{{ date('Y-m-d') }}">
                                <label class="invalid-feedback" id="filter_dateFrom_error">Date from is required.</label>
                            </div>
                            <div class="col">
                                <label for="filter_dateTo">Sales Date To</label>
                                <input type="date" id="filter_dateTo" name="filter_dateTo" class="form-control flatpickr" value="{{ date('Y-m-d') }}">
                                <label class="invalid-feedback" id="filter_dateTo_error">Date to is required.</label>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col">
                                <label for="filter_dc">DC</label>
                                <select id="filter_dc" name="filter_dc" class="form-control select2">
                                    <option></option>
                                    @foreach($dc as $s)
                                    <option value="{{ $s->BM_ID }}">{{ $s->DCCode . ' - ' . $s->DC }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="filter_am">AM</label>
                                <select id="filter_am" name="filter_am" class="form-control select2">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="filter_ac">AC</label>
                                <select id="filter_ac" name="filter_ac" class="form-control select2">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-9">
                                <label for="filter_store">Store</label>
                                <select id="filter_store" name="filter_store" class="form-control select2">
                                    <option></option>
                                    @foreach($stores as $s)
                                    <option value="{{ $s->Location_ID }}">{{ $s->LocationCode . ' - ' . $s->Location }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="filter_status">Status</label>
                                <select id="filter_status" name="filter_status" class="form-control select2">
                                    <option></option>
                                    @foreach($status as $s)
                                    <option value="{{ $s->Status_ID }}">{{ $s->Status }}</option>
                                    @endforeach
                                    <option value="-1">Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div>
                            <button type="button" class="btn btn-light waves-effect waves-light" data-dismiss="modal">Close</button>
                            <button type="button" id="btn_filter_audit" class="btn btn-primary waves-effect waves-light">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
