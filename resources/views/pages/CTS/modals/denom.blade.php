
<div id="modal_denom" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-center modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Denomination</h4>
            </div>
            <div class="modal-body">
                <h4 id="picktitle"></h4>
                <form id="form_denom">
                    <fieldset>
                        <div class="form-group">
                            <input type="hidden" value="" id="cts_ID" name="cts_ID">
                            <input type="hidden" value="" id="pickup_type" name="pickup_type">
                            <div class="row">
                                <div class="col-6">
                                    <table class="table table-centered w-100 nowrap">
                                       <thead>
                                           <tr>
                                               <th>Bills</th>
                                               <th style="width:40%">Qty<th>
                                            </tr>
                                       </thead>
                                        @foreach($denom as $d)
                                            @if($d->DenomType_ID == 2)
                                                <tr>
                                                    <td>{{ $d->Amount }}</td>
                                                    <td><input type="number" min="0" class="form-control"  id="{{ $d->DenomOption_ID }}" name="{{ $d->DenomOption_ID }}" oninput="validity.valid||(value='');"></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </div>
                                <div class="col-6">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Coins</th>
                                                <th style="width:50%">Qty<th>
                                            </tr>
                                        </thead>
                                         @foreach($denom as $d)
                                             @if($d->DenomType_ID == 1)
                                                 <tr>
                                                     <td>{{ $d->Amount }}</td>
                                                     <td><input type="number"  min="0" class="form-control"  id="{{ $d->DenomOption_ID }}" name ="{{ $d->DenomOption_ID }}" oninput="validity.valid||(value='');"></td>
                                                    </tr>
                                             @endif
                                         @endforeach
                                     </table>
                                </div>
                            </div>
                            <div class="row endopt">
                                <div class="col-6">
                                    <label for="denom_lcf">Loose Change Fund</label>
                                    <input type="number" id="denom_lcf" name="denom_lcf" class="form-control" value=""  min="0"  oninput="validity.valid||(value='')";>
                                    <label class="invalid-feedback" id="denom_lcf_error">Loose Change Fund is required.</label>
                                </div>
                                <div class="col-6">
                                    <label for="denom_lcc">Check Encashment</label>
                                    <input type="number" id="denom_lcc" name="denom_lcc" class="form-control" value="" min="0" oninput="validity.valid||(value='')";>
                                    <label class="invalid-feedback" id="denom_lcc_error">Check Encashment is required.</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="text-center">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" id="btn_save_denom" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
