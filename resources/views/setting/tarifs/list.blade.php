@extends('app')
@section('title')
  Тарифы

@endsection
@section('content')
    <div class="row">
        <div class="page-title col-md-6" style="padding: 10px">
            <h1> <span class="text-semibold">Тарифы </span></h1>

        </div><div class="col-md-6"></div>
        <div class="col-md-2"  style="padding: 10px">   <a href="/setting/tarifs/create" class="btn btn-success">Добавить</a>
           </div>


    </div>

        <!-- Task manager table -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h2 class="panel-title">{{$title}} </h2>
                <div class="heading-elements">


                </div>
            </div>

            <table class="table tasks-list table-lg">
                <thead>
                <tr>

                    <th>Название</th>
                    <th>Цена в месяц</th>
                    <th>Цена за год</th>
                    <th>Цена номера</th>
                    <th>Цена минуты</th>


                    <th><i class="glyphicon glyphicon-pencil"></i></th>
                    <th><i class="glyphicon  glyphicon-trash" style="color: red"></i></th>



                </tr>
                </thead>
                <tbody>
               @foreach($stages as $client) <tr   id="del{{$client->id}}">

                    <td>{{$client->name}}</td>
                    <td>{{$client->month}}</td>
                    <td>{{$client->year}}</td>
                    <td>{{$client->phone}}</td>
                    <td>{{$client->minuta}}</td>


                       <td>
                           <a href="/setting/tarifs/{{$client->id}}/edit" ><i class="glyphicon glyphicon-pencil"></i></a></td>

                       <td><a href="#" data-id="{{$client->id}}" data-url="/setting/tarifs/{{$client->id}}"  class="deletefrom" ><i class="glyphicon  glyphicon-trash" style="color: red"></i></a>
                       </td>











                </tr>
@endforeach

























                </tbody>
            </table>
        </div>
        <!-- /task manager table -->

        <!-- /footer -->









@endsection
