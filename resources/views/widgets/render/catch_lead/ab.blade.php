<?php /*?><div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-3">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-3"
           aria-expanded="false" aria-controls="collapse-3">
            <div class="number-accardion">3</div>
            <div class="h-1">AB тесты</div>
            <div class="descr-text">основные настройки </div>
        </a>
    </div>
    <div id="collapse-3" class="panel-collapse collapse" role="tabpane3" aria-labelledby="heading-3">

    @include('/widgets/render/catch_lead/add_test_modal')
    <div class="col-md-12">
        <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>

            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

        </div>


        <!-- Task manager table -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> </h6>

            </div>
 <button class="btn btn-success" onclick="add_test()"><i class="fa fa-plus"></i>Добавить тест </button>
                <input type="hidden" name="form_action" value="lcatch_ab">
                <input type="hidden" name="widget" value="{{$widget->id}}">
                <input type="hidden" name="my_company_id" value="{{$widget->my_company_id}}">

                <table class="table tasks-list table-lg">
                    <thead>
                    <tr  >
                        <td>#AB</td>
                        <td>Текст окна</td>

                        <td>+ Кнопка</td>
                        <td>-Кнопка</td>
                        <td>+ Кнопка цвет</td>
                        <td>-Кнопка цвет</td>
                        <td>Показов</td>
                        <td>Заявок</td>
                        <td>Статус</td>
                        <td> </td>
                        <td> </td>

                    </tr>
                    </thead>
                    <tbody   class="table_costs">

                    @foreach($fields as $cost)

                        @include('widgets.render.catch_lead.data_tr')
                    @endforeach</tbody>
                </table>
        </div>
        <!-- /task manager table -->



    </div>
    {{--Дополнительные поля--}}

</div>
<script></script>
<?php */?>