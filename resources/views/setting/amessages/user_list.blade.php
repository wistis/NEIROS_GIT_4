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
        

    </div>

    <!-- Task manager table -->
    <div class="panel panel-white">


        <table class="table tasks-list table-lg">
            <thead>
            <tr>

                <th>Тема</th>
                <th>Статус</th>
                <th>Дата</th>
                <th></th>





            </tr>
            </thead>
            <tbody id="row2">
            @foreach($mess as $client) <tr  id="del_{{$client->id}}" class="cat_{{$client->id}}"  data-id="{{$client->id}}" >

                <td>{{$client->tema}}</td>
                <td>@if($client->status==0) <span class="label label-primary">Новое</span> @endif</td>
                <td>{{date('H:i d.m.Y',strtotime($client->created_at))}}</td>
                <td><a href="/setting/messages/{{$client->mess_id}}/edit"> Подробнее</a></td>





            </tr>
            @endforeach

























            </tbody>
        </table>
    </div>
    <!-- /task manager table -->

    <!-- /footer -->









@endsection
