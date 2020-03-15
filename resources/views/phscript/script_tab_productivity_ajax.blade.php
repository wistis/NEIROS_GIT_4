@foreach($users as $log)
    <tr>

        <td>{{ $log->name }}</td>
        <td>@if(isset($alls_good[$log->id])) {{$alls_good[$log->id]}} @else 0 @endif</td>
        <td>@if(isset($alls[$log->id])) {{$alls[$log->id]}} @else 0 @endif</td>
        <td>
            @if((isset($alls_good[$log->id]))&&(isset($alls[$log->id])) )

                @if($alls[$log->id]>0)
                    {{round(100/$alls[$log->id]*$alls_good[$log->id])}}
                @else
                    0
                @endif


            @endif</td>

    </tr>
@endforeach