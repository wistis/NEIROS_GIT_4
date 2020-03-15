@extends('app')
@section('title')
 Тех поддержка

@endsection
@section('content')
    <div class="content" style="margin-top: 50px !important;">
@include('tickets.menu')



        <div class="panel panel-default">

            <div class="panel-heading">
                <h2>Мои тикеты
                    <a href="{{route('wtickets.create')}}" class="btn btn-primary pull-right">Создать тикет</a>
                </h2>
            </div>

            <div class="panel-body">
                <div id="message"></div>
<table class="table table-bordered">
    <thead>
    <tr>
        <td>#</td>
        <td>Тема</td>
        <td>Статус</td>
        <td>Последнее изменнение</td>

        <td>Вледелец</td>
        <td>Категория</td>

    </tr>
    </thead>
    <tbody>
    @foreach($tickets as $item)
        <tr>
            <td>{{$item->number}}</td>
            <td><a href="{{route('wtickets.view',$item->id)}}">{{$item->subject}}</a> </td>
            <td>{{$item->status->name}}</td>

            <td>{{$item->updated_at}}</td>

            <td>{{$item->user->name}}</td>
            <td>{{$item->category->name}}</td>

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
