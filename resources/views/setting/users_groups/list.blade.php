@extends('app')
@section('title')
    Этапы сделок

@endsection
@section('content')
    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
        <!-- Task manager table -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title">Группы пользователей</h6>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <a href="/setting/usersgroup/create" class="btn btn-success">Добавить</a>
                    </ul>
                </div>
            </div>

            <table class="table tasks-list table-lg">
                <thead>
                <tr>

                    <th>Название</th>

                    <th><i class="glyphicon glyphicon-pencil"></i></th>
                    <th><i class="glyphicon  glyphicon-trash" style="color: red"></i></th>



                </tr>
                </thead>
                <tbody>
               @foreach($stages as $client) <tr  id="del{{$client->id}}">

                    <td>{{$client->name}}</td>


                   <td>
                       <a href="/setting/usersgroup/{{$client->id}}/edit" ><i class="glyphicon glyphicon-pencil"></i></a></td>

                   <td>

                       <a href="#" data-id="{{$client->id}}" data-url="/setting/usersgroup/{{$client->id}}"  class="deletefrom" ><i class="glyphicon  glyphicon-trash" style="color: red"></i>

                       </a>
                   </td>



                </tr>
@endforeach

























                </tbody>
            </table>
        </div>
        <!-- /task manager table -->

        <!-- /footer -->









@endsection
