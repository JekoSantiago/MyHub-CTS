<div id="modal_dpas" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog image-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Attachment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body" id="imgdiv">
                <div class="text-center">
                    <div class="spinner spinner-border" id="loader"></div>
                    <img src="" class="img-fluid" alt="Responsive image" id="attachment" style="display: none">
                </div>
                <hr>
                <div class="row">
                    <h5>Remarks:</h5>
                    <textarea name="uRemarks" id="uRemarks" cols="10" rows="5" class="form-control" readonly></textarea>
                </div>
                <div class="row">
                    <h5>Upload Date: &emsp;</h5>
                    <h5 id="uploadDate"></h5>
                </div>
                <div class="row">
                    <h5>Uploaded By: &emsp;</h5>
                    <h5 id="uploadBy"></h5>
                </div>
            </div>
        </div>
    </div>
</div>
