
<div id="modal_new_cts" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-center modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">New CTS</h4>
                <div class="text-right">
                </div>
            </div>
            <div class="modal-body">
                <form id="form_new_cts">
                    <fieldset>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="cts_date">Date</label>
                                    <input type="date" id="cts_date" name="cts_date" class="form-control flatpickr" value="{{ date('Y-m-d') }}" readonly>
                                    <label class="invalid-feedback" id="cts_date_error">Date is required.</label>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col">
                                    <label for="cts_store">Store</label>
                                    <input type="hidden" id="cts_store" name="cts_store" class="form-control" value="{{ $loc->Location_ID }}">
                                    <input type="text" class="form-control flatpickr" value="{{ $loc->Location }}" disabled>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col">
                                    <label for="cts_shift">Shift</label>
                                    <select id="cts_shift" name="cts_shift" class="form-control">
                                        <option></option>
                                        @foreach($shift as $s)
                                        <option value="{{ $s->Shift_ID }}">{{ $s->Shift }}</option>
                                        @endforeach
                                    </select>
                                    <label class="invalid-feedback" id="cts_shift_error">Shift is required.</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="text-center">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" id="btn_add_cts" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
