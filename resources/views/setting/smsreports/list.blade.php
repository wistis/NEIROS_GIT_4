@extends('app')
@section('title')
    Дополнительные поля

@endsection
@section('content')

        <!-- Task manager table -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h2 class="panel-title">Настройки смс отчетов</h2>
                <div class="heading-elements">
                    <a href="/setting/smsreports/create" class="btn btn-success">Добавить</a>

                </div>
            </div>

            <table class="table tasks-list table-lg">
                <thead>
                <tr>

                    <th>Сайт</th>
                    <th>Ближайшая дата</th>

                    <th><i class="glyphicon glyphicon-pencil"></i></th>
                    <th><i class="glyphicon  glyphicon-trash" style="color: red"></i></th>



                </tr>
                </thead>
                <tbody>
               @foreach($stages as $client) <tr   id="del{{$client->id}}">
                    
                    <td>{{$client->site->name}}</td>
                    <td>{{date('H:i d.m.Y',strtotime($client->send_date))}}</td>

                       <td>
                           <a href="/setting/smsreports/{{$client->id}}/edit" ><i class="glyphicon glyphicon-pencil"></i></a></td>

                       <td><a href="#" data-id="{{$client->id}}" data-url="/setting/smsreports/{{$client->id}}"  class="deletefrom" ><i class="glyphicon  glyphicon-trash" style="color: red"></i></a>
                       </td>














                </tr>
@endforeach

























                </tbody>
            </table>
        </div>
        <!-- /task manager table -->

        <!-- /footer -->









@endsection
