@extends('app')
@section('title')
    Дополнительные поля

@endsection
@section('content')

    <!-- Task manager table -->
    <div class=" panel panel-white row" style="position: relative;margin-top: 80px">
<ul style="display: inline-block">



    @if(!is_null($neiros_p0))
        <li style="display: inline-block"><a href="{{route('allnewreports',[ ])}}">{{$neiros_p0}}</a></li> >>

    @endif
    @if(!is_null($neiros_p1))
        <li style="display: inline-block"><a href="{{route('allnewreports',['neiros_p0'=>urlencode($neiros_p0), ])}}">{{$neiros_p1}}</a></li>>>
    @endif


        @if(!is_null($neiros_p2))
        <li style="display: inline-block"><a href="{{route('allnewreports',['neiros_p0'=>urlencode($neiros_p0),'neiros_p1'=>urlencode($neiros_p1) ])}}">{{$neiros_p2}}</a></li>>>
    @endif

            @if(!is_null($neiros_p3))
        <li style="display: inline-block"><a href="{{route('allnewreports',['neiros_p0'=>urlencode($neiros_p0),'neiros_p1'=>urlencode($neiros_p1) ,'neiros_p2'=>urlencode($neiros_p2), ])}}">{{$neiros_p3}}</a></li>

    @endif


</ul>




        <div class="row   col-md-12" style="position: relative;min-height: 150px;">

            <div class="mytable">
                <table class="table table-bordered">
                    <tr>
                        <td> </td>
                        <td>Сделок</td>
                        <td>Лидов</td>
                        <td>Сумма</td>
                        <td>Посетителей</td>
                        <td>Чат</td>
                        @php $z=[];@endphp
                        @foreach($data_neiros as $key=>$val)
                            @if($key!='')


                                @foreach($val['projects'] as $key_0=>$val_0)
                             @isset($data_widget[$key_0])
                          @if(!in_array(optional($data_widget[$key_0]->get_name)->name,$z))
                                        @php $z[]=optional($data_widget[$key_0]->get_name)->name;@endphp
                            <td>{{optional($data_widget[$key_0]->get_name)->name}}</td>



                                        @endif
                                        @endif

                            @endforeach


                        @endif

                      @endforeach

                    </tr>
                    @foreach($data_neiros as $key=>$val)
                   @if($key!='')     <tr>
 @if(is_null($neiros_p0))
                                <td><a href="{{route('allnewreports',['neiros_p0'=>urlencode($key), ])}}">{{$key}}</a></td>
  @elseif(is_null($neiros_p1))
                              <td><a href="{{route('allnewreports',['neiros_p0'=>urlencode($neiros_p0),'neiros_p1'=>urlencode($key),])}}">{{$key}}</a></td>
                                @elseif(is_null($neiros_p2))
                                <td><a href="{{route('allnewreports',['neiros_p0'=>urlencode($neiros_p0),'neiros_p1'=>urlencode($neiros_p1),'neiros_p2'=>urlencode($key),])}}">{{$key}}</a></td>
                            @elseif(is_null($neiros_p3))
                                <td><a href="{{route('allnewreports',['neiros_p0'=>urlencode($neiros_p0),'neiros_p1'=>urlencode($neiros_p1),'neiros_p2'=>urlencode($neiros_p2),'neiros_p3'=>urlencode($key),])}}">{{$key}}</a></td>
                            @elseif(is_null($neiros_p4))
                                <td> {{$key}} </td>
@endif

                            <td>{{$val['data']->sdelka}}</td>
                            <td>{{$val['data']->lead}}</td>
                            <td>{{$val['data']->summ}}</td>
                            <td>{{$val['data']->posetitel}}</td>

                            <td>{{$val['chat']}}</td>
     @foreach($val['projects'] as $key_0=>$val_0)
         @isset($data_widget[$key_0])
             <td>{{$val_0}}</td>@endif
     @endforeach


                        </tr>
@endif
                    @endforeach

                </table>
            </div>


        </div>
    </div>
    <!-- /task manager table -->










@endsection
