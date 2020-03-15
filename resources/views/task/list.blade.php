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

       @foreach($statuses as $status)
        <div class="col-md-{{$stages_amount}}"  data-cat="{{$status->id}}"  >

            <div class="panel panel-white  skip-sort"  >
                <div class="panel-heading">
                    <h6 class="panel-title" style="font-size: 13px;font-weight: bold;color:red">
                        {{$status->name}}

                    </h6>

                </div>


            </div>
            <div class="panel panel-white "  ></div>
           @foreach($TaskController->get_fromval('status',$status->id,$id) as $project  )
            <div class="panel panel-white" data-id="{{$project->id}}" >
                <div class="panel-heading">
                    <h6 class="panel-title" style="font-size: 13px">

                        @if(isset($project->getproject->name)){{$project->getproject->name }}@endif
                    </h6>
                    <div class="heading-elements">
                        <ul class="icons-list">

                            <li><a data-action="move"></a></li>
                        </ul>
                    </div>
                </div>

                <div class="row" style="margin: 3px">
                    <div class="col-md-8"> <a href="/tasks/edit/{{$project->id}}">
                            @if($project->comment=='') Без описания @else {{$project->comment}} @endif
                            </a></div>
                    <div class="col-md-2">{{date('d.m.Y',strtotime($project->date))}}</div>
                </div>

            </div>
@endforeach

        </div>


        @endforeach

    </div>
    <!-- /basic sorting -->




@include('task.modalsetting')





@endsection
