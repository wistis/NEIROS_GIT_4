<div class="form-group">
    <label class="col-lg-3 control-label">{{$fil->name}}:</label>
    <div class="col-lg-9">
        <label>
            <input type="checkbox" class="switchery" name="field-{{$fil->id}}" id="field-{{$fil->id}}" data-tip="{{$fil->field_id}}" @if($tec_param==1) checked @endif>

        </label>


    </div>
</div>