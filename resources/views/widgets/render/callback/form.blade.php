<div class="row tab-pane  " id="basic-tab2">

    <div class="col-md-12">
        <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>

            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

        </div>


        <!-- Task manager table -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> </h6>
                <div class="heading-elements row" style="width: 100%">
                    <div class="col-md-3">



                    </div>
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-3"><input type="text" class="form-control" id="canal_summ" placeholder="Расход (Сумма)">


                        <input type="hidden" class="form-control" id="cost_start_date"  >
                        <input type="hidden" class="form-control" id="cost_end_date" >


                    </div>
                    <div class="col-md-3"><button type="button" class="btn btn-info" onclick="addcoastcanal()" >Сохранить</button>
                    </div>
                </div>
            </div>

            <table class="table tasks-list table-lg">
                <tbody   id="table_costs">
                @foreach($forms as $cost)

                    <tr id="cost{{$cost->id}}">
                        <td >{{$cost->button}}</td>
                        <td >{{$cost->input}}</td>


                        <td ><i class="fa fa-trash" onclick="deletecanal({{$cost->id}})"></i> </td>
                    </tr>
                @endforeach</tbody>
            </table>
        </div>
        <!-- /task manager table -->



    </div>
    {{--Дополнительные поля--}}

</div>
