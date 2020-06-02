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
    <tr data-id="{{$cal->id}}" data-all="@json($cal)">
        <td>
            @if($cal->type==0) <i class="fa fa-phone"></i>@else <i class="fa fa-phone-volume"></i>@endif
            {{date('H:i:s d-m-Y',strtotime($cal->calldate))}}</td>
        <td>{{$cal->did}}</td>
        <td>{{$cal->src}}</td>
        <td>{{($cal->ogidanie)}}</td>
        <td>{{$cal->timing}} </td>
        <td>{{$cal->status}}

        </td>
        <td>
            @if($cal->uploaded==7)

            <audio controls>
                <source src=" https://drive.google.com/uc?authuser=0&id={{$cal->token}}&export=download" type="audio/mp3" >
                https://drive.google.com/uc?authuser=0&id={{$cal->token}}&export=download
            </audio>
        @endif
        </td>
<?php /*?>        <td>




            @if($cal->totext==0) <a href="https://cloud.neiros.ru/upaudio/{{$cal->id}}" target="_blank">Расшифровать</a> @else


                <a href="#" onclick="get_dialog({{$cal->id}});return false;"  >Посмотреть</a>


            @endif
        </td><?php */?>




    </tr>

@endforeach
