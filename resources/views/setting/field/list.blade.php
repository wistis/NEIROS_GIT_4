@extends('app')
@section('title')
    Дополнительные поля

@endsection
@section('content')
    <div class="row">
        <div class="page-title col-md-6" style="padding: 10px">
            <h1><a href="/projects"><i class="icon-arrow-left52 position-left"></i></a><span class="text-semibold">Доп поля сделок  </span></h1>

        </div><div class="col-md-6"></div>
        <div class="col-md-2"  style="padding: 10px"> @if($tipfields==0) <a href="/setting/projectfield/create" class="btn btn-success">Добавить</a>@elseif($tipfields==1)
                <a href="/setting/clientfield/create" class="btn btn-success">Добавить</a>
            @elseif($tipfields==2)
                <a href="/setting/companyfield/create" class="btn btn-success">Добавить</a>
            @endif</div>


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
                    <th>Тип поля</th>
                    <th>Значения</th>
                    <th><i class="glyphicon glyphicon-pencil"></i></th>
                    <th><i class="glyphicon  glyphicon-trash" style="color: red"></i></th>



                </tr>
                </thead>
                <tbody>
               @foreach($stages as $client) <tr   id="del{{$client->id}}">
                    
                    <td>{{$client->name}}</td>
                    <td>{{$client->gettip->name}}</td>
                    <td>@foreach($client->getvalue as $getvalue)
                    {{$getvalue->name}},

                    @endforeach
                    </td>
@if($tipfields==0)
                       <td>
                           <a href="/setting/projectfield/{{$client->id}}/edit" ><i class="glyphicon glyphicon-pencil"></i></a></td>

                       <td><a href="#" data-id="{{$client->id}}" data-url="/setting/projectfield/{{$client->id}}"  class="deletefrom" ><i class="glyphicon  glyphicon-trash" style="color: red"></i></a>
                       </td>




                   @elseif($tipfields==1)


                       <td>
                           <a href="/setting/clientfield/{{$client->id}}/edit" ><i class="glyphicon glyphicon-pencil"></i></a></td>

                       <td><a href="#" data-id="{{$client->id}}" data-url="/setting/clientfield/{{$client->id}}"  class="deletefrom" ><i class="glyphicon  glyphicon-trash" style="color: red"></i></a>
                       </td>
                   @elseif($tipfields==2)


                       <td>
                           <a href="/setting/companyfield/{{$client->id}}/edit" ><i class="glyphicon glyphicon-pencil"></i></a></td>

                       <td><a href="#" data-id="{{$client->id}}" data-url="/setting/companyfield/{{$client->id}}"  class="deletefrom" ><i class="glyphicon  glyphicon-trash" style="color: red"></i></a>
                       </td>
                   @endif






                </tr>
@endforeach

























                </tbody>
            </table>
        </div>
        <!-- /task manager table -->

        <!-- /footer -->









@endsection
