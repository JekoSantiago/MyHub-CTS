@php
    use Illuminate\Support\Facades\Session;
    use App\Helper\MyHelper;
@endphp
<form id="irForm">
    @csrf
    <input type="hidden" name="ctsID" id="ctsID" value="{{ $info[0]->CLK_ID }}">
    <input type="hidden" name="locationID" id="locationID" value="{{ $info[0]->Location_ID }}">

    <div class="row mb-3">
        <div class="col-3">
            <h5>Location:</h5>
        </div>
        <div class="col-9">
            <input type="text" class="form-control" value="{{ $info[0]->Location }}" disabled>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">
            <h5>Sales Date:</h5>
        </div>
        <div class="col-9">
            <input type="text" class="form-control" value="{{ $info[0]->SalesDate }}" disabled>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">
            <h5>Name:</h5>
        </div>
        <div class="col-9">
            <input type="text" class="form-control" value="{{ $info[0]->Employee2 }}" disabled>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">
            <h5>Shift:</h5>
        </div>
        <div class="col-9">
            <input type="text" class="form-control" value="{{ $info[0]->Shift }}" disabled>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">
            <h5>POS / CDR:</h5>
        </div>
        <div class="col-9">
            <input type="text" class="form-control" value="{{ $info[0]->CDR ?? 'N/A' }}" disabled>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">
            <h5>Cash on Hand:</h5>
        </div>
        <div class="col-9">
            <input type="text" class="form-control" value="{{ $info[0]->COH ?? 'N/A' }}" disabled>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">
            <h5>Discrepancy:</h5>
        </div>
        <div class="col-9">
            <input type="text" class="form-control"
                value="{{ number_format($info[0]->COH - $info[0]->CDR, 2, '.', '') }}" disabled>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">
            <h5>AC:</h5>
        </div>
        <div class="col-9">
            <input type="text" class="form-control" value="{{ $info[0]->AC ?? 'N/A' }}" disabled>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">
            <h5>AM:</h5>
        </div>
        <div class="col-9">
            <input type="text" class="form-control" value="{{ $info[0]->AM ?? 'N/A' }}" disabled>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-3">
            <h5>Status: <span class="text-danger">*</span></h5>
        </div>
        <div class="col-9">
            <select name="ir_status" id="ir_status" class="form-control select2">
                <option></option>
                @foreach ($status as $s)
                    <option value="{{ $s->Status_ID }}" @if ($s->Status_ID == $info[0]->Status_ID) selected @endif>
                        {{ $s->Status }}</option>
                @endforeach
            </select>
            <label class="invalid-feedback" id="ir_status_error">Status is required.</label>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">
            <h5>Remarks:</h5>
        </div>
        <div class="col-9">
            <textarea name="ir_remarks" id="ir_remarks" cols="30" rows="5" class="form-control"
                @if ($deptID != 20) disabled @endif>{{ $info[0]->Remarks }}</textarea>
        </div>
    </div>
    @if ($info[0]->Attachment != null)
        <div class="form-group row mb-3">
            <h5 class="col-3">Attached File</h5>
            <div class="col-9">
                @if ($fileType == 'pdf' || $fileType == 'doc' || $fileType == 'docx')
                    <a target="_blank"
                        href="{{ route('atc.dl', ['location' => $info[0]->Location_ID, 'cts' => $info[0]->CLK_ID, 'file' => $info[0]->Attachment]) }}">{{ $info[0]->Attachment }}</a>
                @else
                    <img class="img-fluid mb-2" src="{{ $image }}" alt="Loading..">
                    <div>{{ basename($info[0]->Attachment) }}</div>
                @endif
            </div>
        </div>
    @endif
    {{-- @if ($info[0]->Attachment == null)
        <div class="form-group row mb-3">
            <label class="col-sm-3 col-form-label">Upload File</label>
            <div class="col-sm-9">
                <input type="file" name="irAttachment" id="irAttachment" class="form-control-file mb-2" accept="image/gif, image/jpeg, .pdf" single>
                <button id="addFile" type="button" class="btn btn-secondary">Upload Incident Report</button>
                <span id="irAttachment-error" class="custom-error d-none" for="irAttachment">Attach file is required.</span>
            </div>
        </div>
    @endif --}}
    <div class="form-group row">
        <div class="col-sm-12 text-center">
            {{-- @if ($info[0]->Status_ID == null) --}}
                <button type="button" id="btnIRSave" class="btn btn-success">SAVE</button>
            {{-- @endif --}}
            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
        </div>
    </div>
</form>
