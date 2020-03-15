@extends('app')
@section('title')
    Этапы сделок

@endsection
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <input name="_token" type="hidden" value="{{ csrf_token() }}" />

    <!-- Task manager table -->
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">Пользователи</h6>
            <div class="heading-elements">
                <ul class="icons-list">
                    <a href="/setting/adminclient/create" class="btn btn-success">Добавить</a>
                </ul>
            </div>
        </div>

        <table class="table tasks-list table-lg">
            <thead>
            <tr>

                <th>#</th>
                <th>Имя</th>
                <th>E-mail</th>
                
                <th>Компания</th>
                <th>Баланс</th>
                <th>Вход</th>
                <th> </th>
                <th>Платный</th>

                <th><i class="glyphicon  glyphicon-trash" style="color: red"></i></th>



            </tr>
            </thead>
            <tbody>
            @foreach($stages as $client) <tr  id="del{{$client->id}}">

                <td>{{$client->my_company_id}}</td>
                <td>{{$client->name}}</td>
                <td>{{$client->email}}
                <br>
                @if($client->phone!='')    {{$client->phone}}  <div>@if($client->sms_code>0) {{$client->sms_code}}
                        @else <i class="fa fa-check"></i> @endif
                        @endif
                    </div>
                </td>

                <td>{{$client->getcompany->name}}</td>
                <td id="balans" class="click_balans" data-id="{{$client->id}}" data-name_client="{{$client->name}}">{{$client->getcompany->ballans}}</td>
                <td><a href="/setting/loginas/{{$client->id}}">Войти под пользователем</a></td>
                <td><a href="/setting/adminclient/{{$client->id}}/edit"    >edit

                    </a></td>


                <td>@if($client->is_active==1)<a href="/setting/adminclient/set_active/{{$client->id}}" style="color: green"> ДА</a>  @else<a href="/setting/adminclient/set_active/{{$client->id}}" style="color: red"> нет</a>  @endif </td>
                   <td> @if($client->id!==1)<a href="#" data-id="{{$client->id}}" data-url="/setting/adminclient/{{$client->id}}"  class="deletefrom_user" ><i class="glyphicon  glyphicon-trash" style="color: red"></i>

                    </a>@endif
                </td>



            </tr>
            @endforeach

























            </tbody>
        </table>
    </div>
    <!-- /task manager table -->

    <!-- /footer -->

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
             <form method="post" action="/setting/billing/add_rashod">
                 <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Создать списание</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <input type="hidden" name="id" id="user_id" value="">
                Клиент    <span id="name_client"></span><br>
                Сумма <input type="text" name="summ"   value="0" class="form-control"><br>
                Комментарий <input type="text" name="comment"    class="form-control" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Создать</button>
                </div>
             </form>
            </div>
        </div>
    </div>




<script>


    $(document).on('click','.click_balans',function () {
        $('#user_id').val($(this).data('id'))
        $('#name_client').html($(this).data('name_client'))
$('#exampleModalCenter').modal('show');
    })

    $('.deletefrom_user').click(function () {










        id=$(this).data('id');
        urlka=$(this).data('url');


        datatosend = {
            _token: $('[name=_token]').val(),
            _method:	'delete'



        }
        mthis= $(this);

        Swal.fire({
            title: 'Вы уверены?',
            text: "Точно хотите удалить пользователя?!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Да, удалить!'
        }).then((result) => {
            if (result.value) {
                mthis .closest('tr').hide();
                $.ajax({
                    type: "POST",
                    url: urlka,
                    data: datatosend,
                    success: function (html1) {
                        Swal.fire(
                            'Удалено!',
                            'Пользователь удален.',
                            'success'
                        )

                    }
                })


            }
        })





        return false;
    });
</script>


@endsection
