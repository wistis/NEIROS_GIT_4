@if($for_view)<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-7">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-7"
           aria-expanded="false" aria-controls="collapse-7">
            <div class="number-accardion">7</div>
            <div class="h-1">Быстрые ответы чата</div>
            <div class="descr-text">настройка формы обратной связи</div>
        </a>
    </div>
@endif

    <div id="collapse-7" class="panel-collapse collapse" role="tabpane7" aria-labelledby="heading-7">
    <div class="col-md-12">
        <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>

            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

        </div>


        <!-- Task manager table -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> </h6>
                <div class="heading-elements row" style="width: 100%">


                    <div class="col-md-3"><input type="text" class="form-control" id="name" placeholder="Быстрый ответ">




                    </div>
                    <div class="col-md-3"><button type="button" class="btn btn-info" onclick="addfast()" >Сохранить</button>
                    </div>
                </div>
            </div>

            <table class="table tasks-list table-lg">
                <tbody   id="table_costs">
                @foreach($costs as $cost)

                    <tr id="cost{{$cost->id}}">
                        <td >{{$cost->name}}</td>


                        <td ><i class="fa fa-trash" onclick="deletefast({{$cost->id}})"></i> </td>
                    </tr>
                @endforeach</tbody>
            </table>
        </div>
        <!-- /task manager table -->



    </div>
    {{--Дополнительные поля--}}
        @if($for_view)
</div>
</div>@endif
