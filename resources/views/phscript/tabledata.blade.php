@foreach($logs as $log)
    <tr>
        <td>{{date('H:i:s d-m-Y',strtotime($log->created_at))}}</td>
        <td>Оператор</td>
        <td>{{$log->timer}} сек</td>
        @foreach($project_fields as $project_field)

            <td>
                @if($otvfld[$log->id][$project_field->id])
                    {{$otvfld[$log->id][$project_field->id]}}
                @endif

            </td>
        @endforeach
        <td><i class="fa fa-info btn btn-info" onclick="open_info({{$log->id}})"></i> </td></tr>
@endforeach