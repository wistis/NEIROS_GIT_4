@extends('app')
@section('title')
    Этапы сделок

@endsection
@section('content')

    <div class="row">
        <div class="page-title col-md-3" style="padding: 10px">
            <h1><a href="/projects"><i class="icon-arrow-left52 position-left"></i></a><span class="text-semibold">Этапы сделок</span></h1>

        </div><div class="col-md-6"></div>
        <div class="col-md-2"  style="padding: 10px">   <a href="/setting/stages/create" class="btn btn-success">Добавить</a></div>


    </div>

        <!-- Task manager table -->
        <div class="panel panel-white">


            <table class="table tasks-list table-lg">
                <thead>
                <tr>

                    <th>Название</th>
                    <th><i class="glyphicon glyphicon-pencil"></i></th>
                    <th><i class="glyphicon  glyphicon-trash" style="color: red"></i></th>



                </tr>
                </thead>
                <tbody id="row2">
               @foreach($stages as $client) <tr  id="del_{{$client->id}}" class="cat_{{$client->id}}"  data-id="{{$client->id}}" >

                    <td>{{$client->name}}</td>

                   <td>
                       <a href="/setting/stages/{{$client->id}}/edit" ><i class="glyphicon glyphicon-pencil"></i></a></td>

                   <td><a href="#" data-id="{{$client->id}}" data-url="/setting/stages/{{$client->id}}"  class="deletefrom" ><i class="glyphicon  glyphicon-trash" style="color: red"></i></a>
                   </td>



                </tr>
@endforeach

























                </tbody>
            </table>
        </div>
        <!-- /task manager table -->

        <!-- /footer -->









@endsection
