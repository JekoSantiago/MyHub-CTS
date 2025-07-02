<div id="modal_remarks" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">TREASURY REMARKS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body" id="">
                <div class="row mb-2">
                    <div class="col">
                        <textarea name="tRemarks" id="tRemarks" cols="30" rows="5" class="form-control" style="font-style: italic;" readonly>
                        </textarea>
                    </div>
                </div>
                <form id="form_new_tRemarks">
                    <input type="hidden" id="locID" name="locID">
                    <input type="hidden" id="salesDate" name="salesDate">
                    <div class="row mb-2">
                        <div class="col">
                            <h4>New Remarks:</h4>
                            <textarea name="new_tRemarks" id="new_tRemarks" cols="30" rows="5" class="form-control">
                            </textarea>
                            <label class="invalid-feedback" id="new_tRemarks_error">Remarks is required.</label>

                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" id="btn_new_rem" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
