@extends('app')
@section('title')
 Тех поддержка

@endsection
@section('content')
    <div class="content" style="margin-top: 50px !important;">
@include('tickets.menu')



        <div class="panel panel-default">

            <div class="panel-heading">
                <h2>Открытые тикеты

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
        <td>Агент</td>
        <td>Категория</td>

    </tr>
    </thead>
    <tbody>
    @foreach($tickets as $item)
        <tr>
            <td @if($item->agent_no_read==1) style="font-weight: bold" @endif>{{$item->number}}</td>
            <td @if($item->agent_no_read==1) style="font-weight: bold" @endif><a href="{{route('wtickets.view',$item->id)}}">{{$item->subject}}</a> </td>
            <td @if($item->agent_no_read==1) style="font-weight: bold" @endif>{{$item->status->name}}</td>

            <td @if($item->agent_no_read==1) style="font-weight: bold" @endif>{{$item->updated_at}}</td>

            <td @if($item->agent_no_read==1) style="font-weight: bold" @endif>{{$item->user->name}}</td>
            <td @if($item->agent_no_read==1) style="font-weight: bold" @endif>{{$item->agent->name}}</td>
            <td @if($item->agent_no_read==1) style="font-weight: bold" @endif>{{$item->category->name}}</td>

        </tr>



    @endforeach
    </tbody>





</table>




        <!-- Footer -->
        <div class="footer text-muted">
{!! $tickets->links() !!}
        </div>
        <!-- /footer -->

    </div>


@endsection
