@extends('app')
@section('title')
    Тех поддержка

@endsection
@section('content')
    <div class="content" style="margin-top: 50px !important;">
        @include('tickets.menu')


        <div class="panel panel-default">
            <div class="panel-body">
                <div class="content">
                    <h2 class="header">
                        {{$ticket->subject}}
                        <span class="pull-right" >
      @if(is_null($ticket->completed_at)) <a href="{{route('wtickets.set.completed',$ticket->id)}}"  class="btn btn-success">Пометить выполненным</a>
                        @else
                                <a href="{{route('wtickets.set.reopen',$ticket->id)}}"  class="btn btn-success">Открыть заново</a>
          @endif
       <a href="{{route('wtickets.delete',$ticket->id)}}"  class="btn btn-danger deleteit"
                                                                                               form="delete-ticket-{{$ticket->id}}"
                                                                                               node="{{$ticket->subject}}">Удалить</a>


                                    </span>
                    </h2>
                    <div class="panel well well-sm">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <p><strong>Владелец</strong>: {{$ticket->user->name}}</p>
                                    <p>
                                        <strong>Статус</strong>:
                                        <span style="color: #000000">{{$ticket->status->name}}</span>

                                    </p>

                                </div>
                                <div class="col-md-6">
                                    <p><strong>Ответственный</strong>: {{$ticket->agent->name}}</p>
                                    <p>
                                        <strong>Категория</strong>:
                                        <span style="color: #000000">
                                 {{$ticket->category->name}}
                                </span>
                                    </p>
                                    <p><strong>Дата создания</strong>: {{$ticket->created_at}}</p>
                                  @if( $ticket->updated!='')  <p><strong>Последнее изменение</strong>:  {{$ticket->updated}}</p>@endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <p>{{$ticket->content}}-<br></p>
                    </div>
                </div>
                <form method="POST" action="https://cloud.neiros.ru/tickets/10" accept-charset="UTF-8"
                      id="delete-ticket-10"><input name="_method" type="hidden" value="DELETE"><input name="_token"
                                                                                                      type="hidden"
                                                                                                      value="0YgzSGFFYeVcWnUnjLnlO9FbvhlCaekmXbsU9wok">
                </form>
            </div>
        </div>
        <br>
        <h2>Комментарии</h2>
        @foreach($ticket->comments as $comment)<div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    {{$comment->user->name}}
                    <span class="pull-right"> {{$comment->created_at}} </span>
                </h3>
            </div>
            <div class="panel-body">
                <div class="content">
                    <p></p>
                    <p> {{$comment->content}}<br></p>
                    <p></p>
                </div>
            </div>
        </div>@endforeach

        <div class="panel panel-default">
            <div class="panel-body">
                <form method="POST" action="{{route('wtickets.add_comment')}}" accept-charset="UTF-8"
                      class="form-horizontal"><input name="_token" type="hidden"
                                                     value="0YgzSGFFYeVcWnUnjLnlO9FbvhlCaekmXbsU9wok">


                    <input name="ticket_id" type="hidden" value="{{$ticket->id}}">

                    <fieldset>
                        <legend>Ответить</legend>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <textarea class="form-control summernote-editor" rows="3" name="content" cols="50"
                                         required ></textarea>
                            </div>
                        </div>

                        <div class="text-right col-md-12">
                            <input class="btn btn-primary" type="submit" value="Отправить">
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>
@endsection
