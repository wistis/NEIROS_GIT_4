@foreach($input_calls as $cal)
    <tr>
        <td>{{date('H:i:s d-m-Y',strtotime($cal->calldate))}}</td>
        <td>{{$cal->aon}}</td>

        <td>{{($cal->duration-$cal->billsec)}}</td>
        <td>{{$cal->billsec}} </td>
        <td>{{$cal->disposition}}</td>
        <td><audio controls>
                <source src="http://82.146.43.227/records/{{date('Y',strtotime($cal->calldate))}}/{{date('m',strtotime($cal->calldate))}}/{{date('d',strtotime($cal->calldate))}}/{{$cal->record_file}}.mp3" type="audio/mp3" >

                http://82.146.43.227/records/{{date('Y',strtotime($cal->calldate))}}/{{date('m',strtotime($cal->calldate))}}/{{date('d',strtotime($cal->calldate))}}/{{$cal->record_file}}.mp3
            </audio></td>





    </tr>

@endforeach
