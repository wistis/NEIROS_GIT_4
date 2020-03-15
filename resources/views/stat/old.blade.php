<tbody>{{--$k=["organic","referral", "typein", "utm"];--}}
<tr><td style="font-weight: bold">Organic</td></tr>
@foreach($organic as $client) <tr  >
    <td>+</td>
    <td>{{$client->src}}</td>
    <td>{{$x=$stat->get_all_call('organic',$client->src)}}</td>
    <td>{{$y=$stat->get_all_call_uniq('organic',$client->src)}}</td>
    <td>{{$x-$y}}</td>
</tr>
@endforeach


<tr><td style="font-weight: bold">referral</td></tr>
@foreach($referral as $client) <tr  >
    <td>+</td>
    <td>{{$client->src}}</td>
    <td>{{$x=$stat->get_all_call('referral',$client->src)}}</td>
    <td>{{$y=$stat->get_all_call_uniq('referral',$client->src)}}</td>
    <td>{{$x-$y}}</td>


</tr>
@endforeach
<tr><td style="font-weight: bold">typein</td></tr>
@foreach($typein as $client) <tr  >
    <td>+</td>
    <td>{{$client->src}}</td>

    <td>{{$x=$stat->get_all_call('typein',$client->src)}}</td>
    <td>{{$y=$stat->get_all_call_uniq('typein',$client->src)}}</td>
    <td>{{$x-$y}}</td>

</tr>
@endforeach
<tr><td style="font-weight: bold">utm</td></tr>
@foreach($utm as $client) <tr  >
    <td>+</td>
    <td>{{$client->src}}</td>
    <td>{{$x=$stat->get_all_call('utm',$client->src)}}</td>
    <td>{{$y=$stat->get_all_call_uniq('utm',$client->src)}}</td>
    <td>{{$x-$y}}</td>


</tr>
@endforeach
</tbody>