@extends('app')
@section('title')
    Задачи - редактирование

@endsection
@section('content')

    <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li><a href="/tasks">Задачи</a>  </li>
            <li class="active">Редактирование </li>
        </ul>
        <input name="_token" type="hidden" value="{{ csrf_token() }}" />

    </div>


    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="#" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />
            <input name="projectId" type="hidden"  id="taskId" value="{{$task->id}}" />
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Редактирование задачи</h5>

                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Тип:</label>
                                    <div class="col-lg-9">
                                        <select data-placeholder="Выберите этап" class="form-control" name="todo" id="todo">

                                            @foreach($todos as $todo)

                                                <option value="{{$todo->id}}" @if($todo->id==$task->todo) selected @endif >{{$todo->name}}</option>

                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Сделка:</label>
                                    <div class="col-lg-9">
                                        <select data-placeholder="Выберите этап" class="form-control" name="project_id" id="project_id">

                                            @foreach($projects as $project)

                                                <option value="{{$project->id}}" @if($project->id==$task->project_id) selected @endif >{{$project->name}}</option>

                                            @endforeach


                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Дата:</label>
                                    <div class="col-lg-9"> 
                                        <input  type="date"  class="form-control" name="data" id="data" value="{{date('Y-m-d',strtotime($task->date))}}"  >
                                    </div>
                                </div>




                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Ответственный:</label>
                                    <div class="col-lg-9">
                                        <select data-placeholder="Выберите ответственного" class="form-control" name="user" id="user">

                                            @foreach($managers as $manager)

                                                <option value="{{$manager->id}}" @if($manager->id==$task->user_id) selected @endif >{{$manager->name}}</option>

                                            @endforeach


                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Статус:</label>
                                    <div class="col-lg-9">
                                        <select  class="form-control" name="status" id="status">

                                            @foreach($statuss as $status)

                                                <option value="{{$status->id}}" @if($status->id==$task->status) selected @endif  >{{$status->name}}</option>

                                            @endforeach


                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Описание задачи:</label>
                                    <div class="col-lg-9">
<textarea name="comment" id="comment"  class="form-control">
{{$task->comment}}


</textarea>

                                    </div>
                                </div>
                            </fieldset>
                        </div>


                    </div>

                    <div class="text-right">
                        <button type="button" class="btn btn-primary task_add">Сохранить<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>

@endsection
