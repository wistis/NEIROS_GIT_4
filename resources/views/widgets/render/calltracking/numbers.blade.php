<div class="row tab-pane " id="basic-tab2">@include('widgets.modaladdphone')
 <style>.modal.fade:not(.in) .modal-dialog {
         -webkit-transform: translate3d(25%, 0, 0);
         transform: translate3d(25%, 0, 0);
     }</style>

    <div class="col-md-3"><a class="btn btn-info" href="#myModalBox" data-toggle="modal">Добавить
            номера</a></div>
    <div class="col-md-3"><a class="btn btn-info" href="#"
                             onclick="delete_from_routing();return false">Удалить из
            сценария</a></div>
    <div class="col-md-12">
        <fieldset>

            <table class="table table-bordered">
                <tr>
                    <td></td>
                    <td>Номер</td>
                    <td>Сценарий</td>
                    <td>Звонки</td>
                    <td>Подключен</td>
                    <td>Закреплен до</td>
                    <td></td>


                </tr>
                @foreach($phones as $phone)
                    <tr id="ids{{$phone->id}}">
                        <td><input type="checkbox" class="my_numberscheckbox"
                                   value="{{$phone->input}}"></td>
                        <td>{{$phone->input}} </td>
                        <td id="phoneroutname{{$phone->input}}">@if(isset($phone->routingm->name)) {{$phone->routingm->name}} @endif</td>
                        <td>{{$phone->amout_call}}</td>
                        <td>{{date('d-m-Y',strtotime($phone->created_at))}}</td>
                        <td>@if($phone->time>time()){{date('H:i:s d-m-Y', $phone->time)}}@endif
                        @if($phone->rezerv==1)<i class="fa fa-clock-o"></i>@endif
                        </td>
                        <td><a href="#"
                               onclick="delete_number({{$phone->input}},{{$phone->id}});return false;"><i
                                        class="glyphicon  glyphicon-trash"
                                        style="color: red"></i> </a></td>


                    </tr>
                @endforeach

            </table>
        </fieldset>
    </div>
    {{--Дополнительные поля--}}


</div>





