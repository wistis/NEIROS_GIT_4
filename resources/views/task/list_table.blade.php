@extends('app')
@section('title')
    Задачи

@endsection
@section('content')


    @inject('TaskController','\App\Http\Controllers\TaskController')
    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
    <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>

            <li class="active">Задачи </li>
        </ul>
        <input name="_token" type="hidden" value="{{ csrf_token() }}" />

    </div>
    <!-- Basic sorting -->

    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">    {{$title}}</h6>
            <div class="heading-elements">

                <a href="/tasks/add" class="btn btn-success">Добавить</a>
                <a    class="btn btn-info" href="#myModalBox" data-toggle="modal">Настройки</a>

            </div>
        </div>
    </div>



    <div class="row row-sortable_task">

        <table class="table tasks-list table-lg">
            <thead>
            <tr>
                <th>#</th>
                <th> </th>
                <th> </th>
                <th>Дата</th>
                 


            </tr>
            </thead>
            <tbody>
        @foreach($projects as $project)
         <tr>   <td> {{$project->id}} </td>
            <td>     @if(isset($project->getproject->name)){{$project->getproject->name }}@endif</td>
            <td> <a href="/tasks/edit/{{$project->id}}">
                    @if($project->comment=='') Без описания @else {{$project->comment}} @endif
                </a></td>
            <td>{{date('d.m.Y',strtotime($project->date))}}</td>
         </tr>




@endforeach

            </tbody>
        </table>







    </div>
    <!-- /basic sorting -->




    @include('task.modalsetting')





@endsection
