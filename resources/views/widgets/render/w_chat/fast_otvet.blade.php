@if($for_view)
<div class="panel panel-default new-panel-default">

    <div class="panel-heading" role="tab" id="heading-7">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-7"
           aria-expanded="false" aria-controls="collapse-7">
            <div class="number-accardion"><img src="/global_assets/images/icon/talk2.svg"></div>
            <div class="h-1">Быстрые ответы чата</div>
            <div class="descr-text">настройка формы обратной связи</div>
        </a>
    </div>
@endif
       @if($for_view)
    <div id="collapse-7" class="panel-collapse collapse" role="tabpane1" aria-labelledby="heading__7" aria-expanded="false" style="height: 0px;">

 <div class="panel-body" style="padding-top:0px">
  <div class="cont-btn-content col-xs-12" style="padding-top: 0px;">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                    <div class="col-xs-12"><input type="text" class="form-control" id="name" placeholder="Быстрый ответ">
                    </div>
                    <div class="col-xs-12"><button type="button" class="btn btn-info" onclick="addfast()" >Сохранить</button>
                    </div>
         
<div class="col-xs-12" style="margin-top:30px;">
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


</div>
</div>
</div>
</div>
@endif
