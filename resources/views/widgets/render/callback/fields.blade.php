<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-4">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-4"
           aria-expanded="false" aria-controls="collapse-4">
            <div class="number-accardion">4</div>
            <div class="h-1">Поля форм</div>
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
                <div class="heading-elements row" style="width: 100%">




            </div>
            </div>

            <table class="table tasks-list table-lg">
                <tbody   id="table_costs">
                @foreach($fields as $cost)

                    <tr id="cost{{$cost->id}}">
                        <td >{{$cost->field}}</td>
                        <td >{{$cost->xval}}</td>
                        <td ><select class="selectfield" data-id="{{$cost->id}}">
                                <option value="0" >Невыбрано</option>
                                <option value="fio" @if($cost->tip=="fio") selected @endif>ФИО</option>
                                <option value="phone" @if($cost->tip=="phone") selected @endif>Телефон</option>
                                <option value="email" @if($cost->tip=="email") selected @endif>E-mail</option>
                                <option value="comment" @if($cost->tip=="comment") selected @endif>Сообщение</option>


                            </select></td>


                        </td>
                    </tr>
                @endforeach</tbody>
            </table>
        </div>
        <!-- /task manager table -->



    </div>
    {{--Дополнительные поля--}}

</div>
