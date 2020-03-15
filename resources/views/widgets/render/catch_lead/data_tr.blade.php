<tr id="costm{{$cost->id}}">

    <td>#{{$cost->id}}</td>
    <td>{{$cost->position_1_text}}</td>

    <td>{{$cost->position_1_yes_text}}</td>
    <td>{{$cost->position_1_not_text}}</td>
    <td style="background: {{$cost->position_1_yes_bcolor}}">{{$cost->position_1_yes_bcolor}}</td>
    <td style="background: {{$cost->position_1_not_bcolor}}">{{$cost->position_1_not_bcolor}}</td>
    <td>{{$cost->shows}}</td>
    <td>{{$cost->leads}}</td>
    <td>{{$cost->status}}</td>
    <td><button class="btn btn-info  clead_edit_ab" data-id="{{$cost->id}}"><i class="fa fa-edit"></i> </button></td>
    <td><button class="btn btn-danger clead_delete_ab" data-id="{{$cost->id}}"><i class="fa fa-trash"></i> </button> </td>



</tr>