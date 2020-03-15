@foreach($logs as $log)
    @if(isset($amount_prohod[$log->sc_id]))<tr>

        <td>{!! $log->text !!}%</td>
        <td>{{round(100/$amout_logs*$amount_prohod[$log->sc_id])}}</td>
        <td>{{$amount_prohod[$log->sc_id]}}</td>
    </tr>@endif
@endforeach