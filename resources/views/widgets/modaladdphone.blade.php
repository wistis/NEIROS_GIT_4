<style>
    .modal-dialog{}

</style>
<div id="myModalBox" class="modal fade">
     
        <div class="modal-dialog" style="    position: absolute;
        right: -10px;
        top: -10px;">
            <div class="modal-content">
            <form   id="caltrackinbyphone"  name="caltrackinbyphone" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Купить номера</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="form-group">
                <label class="col-lg-3 control-label">Код города:</label>
                <div class="col-lg-9">
                    <div class="checkbox checkbox-switchery">
                        <label>
                      <select  name="region" id="region"  class="form-control">
                          @foreach($widget_calltrack_regions as $region)
                         <option value="{{$region->code}}">{{$region->region}}</option>

                    @endforeach
                      </select>
                        </label>
                    </div>
                </div>
                <div class="col-lg-9">
                    <label class="col-lg-3 control-label">Количество:</label>
                    <div class="checkbox checkbox-switchery">
                        <label>
                            <input type="number" name="amount" id="amount" value="1" class="form-control">
                            <input type="hidden" class="form-control" name="id"
                                   value="{{$widget_call_track->id}}">
                        </label>

                    </div>
                </div>
            </div>





            <!-- Футер модального окна -->
            <div class="modal-footer">
                
                <button type="button" class="btn btn-primary  " onclick="add_phone()" >Купить</button>
            </div>
            </form>
        </div>
        </div>

    </div>

