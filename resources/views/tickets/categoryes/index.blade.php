@extends('app')
@section('title')
 Тех поддержка

@endsection
@section('content')
    <div class="content" style="margin-top: 50px !important;">
@include('tickets.menu')



        <div class="panel panel-default">

            <div class="panel-heading">
                <h2>Темы обращений
                    <a href="{{route('wtickets.admin_panel.subject.create')}}" class="btn btn-primary pull-right">Создать тему</a>
                </h2>
            </div>

            <div class="panel-body">
                <div id="message"></div>
<table class="table table-bordered">
    <thead>
    <tr>

        <td>Тема</td>
        <td>Ответственные</td>
        <td><i class="fa fa-edit"></i></td>
        <td><i class="fa fa-trash"></i> </td>


    </tr>
    </thead>
    <tbody>
    @foreach($categoryes as $item)
        <tr>
            <td>{{$item->name}}</td>
            <td>@foreach($item->agents as $agent)
            {{$agent->name}}<br>

            @endforeach</td>
            <td><a href="{{route('wtickets.admin_panel.subject.edit',$item->id)}}"><i class="fa fa-edit"></i> </a></td>
            <td><a href="{{route('wtickets.admin_panel.subject.subject_delete',$item->id)}}"><i class="fa fa-trash"></i> </a> </td>


        </tr>



    @endforeach
    </tbody>





</table>




        <!-- Footer -->
        <div class="footer text-muted">

        </div>
        <!-- /footer -->

    </div>


@endsection
