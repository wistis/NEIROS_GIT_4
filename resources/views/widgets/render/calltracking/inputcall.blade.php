<div  class="row tab-pane " id="basic-tab4">
<div class="col-xs-12">
    <input type="hidden" id="wid_id" value="{{$widget->id}}">
    <div class="table-responsive"><table class="table">
            <thead>  <tr>
            <th>Дата</th>
            <th>НаНомер</th>
            <th>Номер</th>
            <th>Ожидание</th>
            <th>Длительность разговора</th>
            <th>Статус</th>
            <th>Запись</th>
       
        </tr></thead>
            <tbody id="winputcall">

            </tbody>
        </table></div></div>
     <div class="row" id="pagin"> </div>
</div>@include('modal.openmodal')