<div class="form-group">
    <label class="col-lg-3 control-label">{{$fil->name}}:</label>
    <div class="col-lg-9">


        <select   class="form-control" name="field-{{$fil->id}}" id="field-{{$fil->id}}" data-tip="{{$fil->field_id}}" multiple="multiple">

            @foreach($fil->getvalue as  $manager)

                <option value="{{$manager->name}}"
                        @if(in_array($manager->name, $tec_param)) selected  @endif  >{{$manager->name}}</option>

            @endforeach


        </select>

    </div>
</div>