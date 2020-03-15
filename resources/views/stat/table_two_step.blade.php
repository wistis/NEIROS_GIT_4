<tr><?php
    $colspan=6;
    ?>
    @if($all->typ=='utm')
    <td style="cursor: pointer" class="xgk2" onclick="select_type2('{{$all->src}}')" id="{{$all->src}}">+</td>
@else
        <td style="cursor: pointer"></td>
    @endif
    <td>{{$all->src}} {{$all->typ}}</td>
    <td>{{$x}}</td>
    @if(in_array(1,$fruit))
    <td>{{$amount_1}}</td> <?php
        $colspan++;
        ?>
   @endif
    @if(in_array(2,$fruit))
    <td>{{$amount_2}}</td><?php
        $colspan++;
        ?>
    @endif



    <td>{{$y}}</td>
    <td>{{$z}}</td>
    <td><a href="https://cloud.neiros.ru/projects/{{$project_ids}}" target="_blank">[ПОСМОТРЕТЬ]</a></td>

</tr>
@if($all->typ=='utm')<tr>
    <td colspan="{{$colspan}}">
        <table class="table table-bordered {{$all->src}}_sub2 xxxl2" >

        </table>


    </td>


</tr>
@endif
