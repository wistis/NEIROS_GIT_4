<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-3">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-3"
           aria-expanded="false" aria-controls="collapse-3">
            <div class="number-accardion">3</div>
            <div class="h-1">Записи разговоров</div>
            <div class="descr-text">основные настройки </div>
        </a>
    </div>


    <div id="collapse-3" class="panel-collapse collapse" role="tabpane3" aria-labelledby="heading-3">

    <input type="hidden" id="wid_id" value="{{$widget->id}}">
    <div class="table-responsive"><table class="table table-bordered">
            <tr>
                <td>Дата</td>
                <td>НаНомер</td>

                <td>Ожидание</td>
                <td>Длительность разговора</td>
                <td>Статус</td>
                <td>Запись</td>

            </tr>
            <tbody id="winputcall">

            </tbody>
        </table></div>
    <div class="row" id="pagin"> </div>
</div>
</div>