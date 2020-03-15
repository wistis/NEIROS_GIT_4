<div class="row tab-pane " id="basic-tab7">
    <h3>Offline промокоды</h3>
    <div class="form-group">
        <label class="col-lg-3 control-label">Статус промокодов:</label>
        <div class="col-lg-9">
            {!! $status_checkbox_metrika !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>

            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

        </div>


        <!-- Task manager table -->
        <div class="panel panel-white">
            <div class="panel-heading">

                <h6 class="panel-title"> </h6>
                <div class="heading-elements row" style="width: 100%">


                    <div class="col-md-3"><input type="text" class="form-control" id="canal" placeholder="Канал">




                    </div>
                    <div class="col-md-3"><button type="button" class="btn btn-info" onclick="addcanal()" >Добавить</button>
                    </div>
                </div>
            </div>

            <table class="table tasks-list table-lg">
                <tbody   id="table_costs">
                @foreach($widget_data as $cost)

                    <tr id="cost{{$cost->id}}">
                        <td >{{$cost->canal}}</td>
                        <td >{{$cost->promocod}}</td>
                        <td >{{date('d-m-Y'),strtotime($cost->created_at)}}</td>


                        <td ><i class="fa fa-trash" onclick="deletecanalcpomocod({{$cost->id}})"></i> </td>
                    </tr>
                @endforeach</tbody>
            </table>
        </div>
        <!-- /task manager table -->



    </div>
    {{--Дополнительные поля--}}

</div>
