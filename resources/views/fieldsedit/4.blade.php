<div class="form-group">
    <label class="col-lg-3 control-label">{{$fil->name}}:</label>
    <div class="col-lg-9">
        @foreach($fil->getvalue as  $manager)

            <div class="checkbox">
                <label>
                    <input type="checkbox"  name="field-{{$fil->id}}" class="field-{{$fil->id}}" value="{{$manager->name}}" data-tip="{{$fil->field_id}}"
                          <?php
                                try{
                          if(in_array($manager->name,  unserialize($tec_param))){ echo 'checked';  }
                            }catch (\Exception $e){
                                    
                                }
                            ?>

                    >
                    {{$manager->name}}
                </label>
            </div>



        @endforeach
    </div>
</div>