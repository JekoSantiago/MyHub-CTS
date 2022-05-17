<div id="modal_filter_cts" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <label for="filter_dateFrom">Date From</label>
                                <input type="date" id="filter_dateFrom" name="filter_dateFrom" class="form-control flatpickr" value="{{ date('Y-m-d') }}">
                                <label class="invalid-feedback" id="filter_dateFrom_error">Date from is required.</label>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col">
                                <label for="filter_dateTo">Date To</label>
                                <input type="date" id="filter_dateTo" name="filter_dateTo" class="form-control flatpickr" value="{{ date('Y-m-d') }}">
                                <label class="invalid-feedback" id="filter_dateTo_error">Date to is required.</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div>
                            <button type="button" class="btn btn-light waves-effect waves-light" data-dismiss="modal">Close</button>
                            <button type="button" id="btn_filter_cts" class="btn btn-primary waves-effect waves-light">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
