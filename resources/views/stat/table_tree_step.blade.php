<tr>

        <td style="cursor: pointer"></td>
<?php
$ggh=explode(',',$all->keyword)[0];
$ggh2=explode('?',$ggh)[0]
?>

    <td>{{str_replace("+"," ",$ggh2)}}  </td>
    <td>{{$x}}</td>
    @if(in_array(1,$fruit))
        <td>{{$amount_1}}</td>
    @endif
    @if(in_array(2,$fruit))
        <td>{{$amount_2}}</td>
    @endif



    <td>{{$y}}</td>
    <td>{{$z}}</td>
    <td><a href="https://cloud.neiros.ru/projects/{{$project_ids}}" target="_blank">[ПОСМОТРЕТЬ]</a></td>

</tr>
