


        <!-- Task manager table -->
        <div class="panel panel-white">
           

            <table class="table tasks-list table-lg">
                <thead>
                <tr>
                    <th>#</th>

                    <th>ФИО</th>
                    <th>Телефон</th>
                    <th>E-mail</th>
                    <th>Компания</th>
                    <th>Баланс</th>
                    <th><i class="glyphicon glyphicon-pencil"></i></th>
                    <th><i class="glyphicon  glyphicon-trash" style="color: red"></i></th>


                </tr>
                </thead>
                <tbody>
               @foreach($clients as $client)  <tr   id="del{{$client->id}}">
                    <td>{{$client->id}}</td>

                    <td>{{$client->fio}}</td>
                    <td>@if(isset($client->getClient->where('keytip','PHONE')->first()->val)) {{$client->getClient->where('keytip','PHONE')->first()->val}} @endif
                        @if($user->super_admin==1)<button class="btn btn-info sendcall" onclick="send_call('{{$client->phone}}')"><i class="fa fa-phone"></i> </button>@endif
                         </td>
                    <td>@if(isset($client->getClient->where('keytip','EMAIL')->first()->val)) {{$client->getClient->where('keytip','EMAIL')->first()->val}} @endif</td>
                    <td> </td>

                   <td>
                       <a href="/contacts/edit/{{$client->id}}" ><i class="glyphicon glyphicon-pencil"></i></a></td>

                   <td><a href="#" data-id="{{$client->id}}" data-url="/contacts/del/{{$client->id}}"  class="deletefrom" ><i class="glyphicon  glyphicon-trash" style="color: red"></i></a>
                   </td>






               </tr>
@endforeach

























                </tbody>
            </table>
        </div>
        <!-- /task manager table -->
<script>

    function send_call(phone) {

      $('.sendcall').attr('disabled',true);
        $.ajax({
            type: "POST",
            url: '/ajax/send_call',
            data: '&phone='+phone,
            success: function (html1) {
                mynotif("OK","Мы осуществляем звонок","success");
                $('.sendcall').attr('disabled',false);
            }
        })
    }
</script>
        <!-- /footer -->







