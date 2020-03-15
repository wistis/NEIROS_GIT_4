<?php /*?><div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-4">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-4"
           aria-expanded="false" aria-controls="collapse-4">
            <div class="number-accardion">4</div>
            <div class="h-1">Аналитика</div>
            <div class="descr-text">основные настройки </div>
        </a>
    </div>
    <div id="collapse-4" class="panel-collapse collapse" role="tabpane4" aria-labelledby="heading-4">

    <div class="col-md-12">
        <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>

            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

        </div>


        <!-- Task manager table -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> </h6>

            </div>



            <table class="table tasks-list table-lg">
                <thead>
                <tr  >
                    {{--`id`, `site_id`, `my_company_id`, `ab_id`, `hash`, `created_at`, `updated_at`, `step_1`, `step_2`, `step_end`, `lead`, `project_id`--}}
                    <td>#AB</td>
                    <td>1 шаг</td>

                    <td>2 шаг</td>
                    <td>Кол-во шагов</td>
                    <td>Заявка</td>
                    <td>Сделка</td>
                    <td>UID</td>


                </tr>
                </thead>
                <tbody   class="table_costs">

                @foreach($fields as $cost)
                    <tr  >
                        {{--`id`, `site_id`, `my_company_id`, `ab_id`, `hash`, `created_at`, `updated_at`, `step_1`, `step_2`, `step_end`, `lead`, `project_id`--}}
                        <td>#{{$cost->id}}</td>
                        <td>
                            @if($cost->step_1==0) @endif
                            @if($cost->step_1==1) Да @endif
                            @if($cost->step_1==2) Нет @endif


                        </td>

                        <td>   @if($cost->step_2==0) @endif
                            @if($cost->step_2==1) Да @endif
                            @if($cost->step_2==2) Нет @endif
                        </td>
                        <td>{{$cost->step_end}}</td>
                        <td>@if($cost->lead==1)<i class="fa fa-check" style="color: green"></i> @endif</td>
                        <td>@if($cost->project_id>0) <a href="/projects/edit/7099" target="_blank"> 101{{Auth::user()->my_company_id}}{{$cost->project_id}}</a> @endif</td>
<td>{{$cost->neiros_visit}}</td>

                    </tr>

                @endforeach</tbody>
            </table>
        </div>
        <!-- /task manager table -->



    </div>
    {{--Дополнительные поля--}}

</div>
</div>

<?php */?>