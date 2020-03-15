@extends('app')
@section('title')
    Этапы сделок

@endsection
@section('content')
@inject('Info',"App\Http\Controllers\Admin_messagesController")
    <div class="row">
        <div class="page-title col-md-3" style="padding: 10px">
            <h1><span class="text-semibold">Сообщения администратора</span></h1>

        </div><div class="col-md-6"></div>
        <div class="col-md-2"  style="padding: 10px">   <a href="/setting/messages/create" class="btn btn-success">Добавить</a></div>


    </div>

        <!-- Task manager table -->
        <div class="panel panel-white">


            <table class="table tasks-list table-lg">
                <thead>
                <tr>

                    <th>Тема</th>
                    <th>Сообщение</th>
                    <th>Дата</th>
                    <th>Статус прочтения</th>





                </tr>
                </thead>
                <tbody id="row2">
               @foreach($mess as $client) <tr  id="del_{{$client->id}}" class="cat_{{$client->id}}"  data-id="{{$client->id}}" >

                    <td>{{$client->tema}}</td>
                    <td>{{$client->message}}</td>
                    <td>{{date('H:i d.m.Y',strtotime($client->created_at))}}</td>
                    <td>{{$Info->get_status_admin($client->id)}}</td>





                </tr>
@endforeach

























                </tbody>
            </table>
        </div>
        <!-- /task manager table -->

        <!-- /footer -->









@endsection
