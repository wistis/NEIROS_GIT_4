@php
 $status_call['CANCEL']='Вызов отменен';
 $status_call['ANSWER']='Отвечено';
 $status_call['NO ANSWER']='Без ответа';
 $status_call['ANSWERED']='Отвечено';
 $status_call['NOANSWER']='Без ответа';
 $status_call['CONGESTION']='Канал перегружен';
 $status_call['CHANUNAVAIL']='Канал недоступен';
 $status_call['BUSY']='Занято';




@endphp
 
@foreach($input_calls as $cal)
    <tr>
        <td>
            @if($cal->type==0) <i class="fa fa-phone"></i>@else <i class="fa fa-phone-volume"></i>@endif
            {{date('H:i:s d-m-Y',strtotime($cal->calldate))}}</td>
        <td>{{$cal->did}}</td>
        <td>{{$cal->src}}</td>
        <td>{{($cal->ogidanie)}}</td>
        <td>{{$cal->timing}} </td>
        <td>{{$cal->status}}

        </td>
        <td><audio controls>
                <source src="http://82.146.43.227/records/{{$cal->record}}" type="audio/mp3" >

                http://82.146.43.227/records/{{$cal->record}}
            </audio></td>
        <td>




            @if($cal->totext==0) <a href="https://cloud.neiros.ru/upaudio/{{$cal->id}}" target="_blank">Расшифровать</a> @else


                <a href="#" onclick="get_dialog({{$cal->id}});return false;"  >Посмотреть</a>


            @endif
        </td>




    </tr>

@endforeach
