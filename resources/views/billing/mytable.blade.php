@foreach($phones as $key=>$val)<tr>
    <td>{{$phones[$key]['phone']}}</td>
    <td>{{date('d-m-Y',strtotime($phones[$key]['created_at']))}}</td>
    <td>@if($phones[$key]['was_deleted']==1){{date('d-m-Y',strtotime($phones[$key]['updated_at']))}}@endif</td>
    <td>{{$day}}</td>
    <td>{{$tarif->phone}}</td>
    <td>{{$phones[$key]['summ_day']}}</td>


</tr>
    @endforeach