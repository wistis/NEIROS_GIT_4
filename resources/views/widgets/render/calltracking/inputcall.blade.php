<div  class="row tab-pane " id="basic-tab4">

    <input type="hidden" id="wid_id" value="{{$widget->id}}">
    <div class="table-responsive"><table class="table table-bordered">
        <tr>
            <td>Дата</td>
            <td>НаНомер</td>
            <td>Номер</td>
            <td>Ожидание</td>
            <td>Длительность разговора</td>
            <td>Статус</td>
            <td>Запись</td>
            <td>Расшифровка</td>
        </tr>
            <tbody id="winputcall">

            </tbody>
        </table></div>
     <div class="row" id="pagin"> </div>
</div>@include('modal.openmodal')