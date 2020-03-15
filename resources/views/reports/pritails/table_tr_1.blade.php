<?php /*?><tr>
    <td>{!! $newlvl !!}  {!! $namegroup !!}<img src="/25.gif" class="m{{$hash}}" style="height: 14px;

float: right;

margin-top: 4px;display: none"></td>

    <td>{{$repgroup->posetitel}}</td>
    <td>{{$repgroup->visit}}</td>
    <td>{{ $repgroup->sdelka }}</td>
    <td>{{$con_st}}%</td>
    <td>{{$repgroup->lead}}</td>
    <td>{{$con_lt}}%</td>
    <td>{{ $repgroup->summ}}</td>
    <td></td>
    <td> </td>
    <td> </td>


</tr><tr  id="m{{$hash}}"></tr><?php */?>

@if($namegroup != '')
<? $array = array('bing', 'direct-yandex', 'duckduckgo', 'go.mail.ru', 'google', 'google-ads', 'rambler', 'referral', 'yahoo', 'yandex', 'tut.by', 'ask', 'baidu','zapmeta');
$str = mb_strtolower($namegroup);
 $key = array_search($str, $array);
 if($key >-1){
	 $src = $str;
	 }
	 else{
		   $src = 'searh';
		 if($str == 'mail.ru'){
			  $src = 'go.mail.ru';
			 }
		
		 }
?>
<tr>
    <td  style="min-width: {{$mass_width[0]+1}}px; width: {{$mass_width[0]+1}}px; max-width: {{$mass_width[0]+1}}px;" class="left-sitebar-table border-table-data"><div class="more-data more-data-child" ><img src="/images/icon/{{$src}}.ico"><?php /*?>{!! $newlvl !!}<?php */?>  {!! $namegroup !!}</div>
    <img src="/25.gif" class="m{{$hash}}" style="height: 14px;float: right;margin-top: 4px;display: none"></td>

    <td class="border-table-data" style="min-width: {{$mass_width[1]+2}}px; width: {{$mass_width[1]+2}}px; max-width: {{$mass_width[1]+2}}px;" ><div>{{$repgroup->posetitel}}</div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[2]+2}}px; width: {{$mass_width[2]+2}}px; max-width: {{$mass_width[2]+2}}px;" ><div>{{$repgroup->sdelka}}</div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[3]+2}}px; width: {{$mass_width[3]+2}}px; max-width: {{$mass_width[3]+2}}px;" >{{number_format($con_st, 2, '.', '')}}%<div></div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[4]+2}}px; width: {{$mass_width[4]+2}}px; max-width: {{$mass_width[4]+2}}px;" >0 р.<div></div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[5]+2}}px; width: {{$mass_width[5]+2}}px; max-width: {{$mass_width[5]+2}}px;" ><div>{{$repgroup->lead}}</div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[6]+2}}px; width: {{$mass_width[6]+2}}px; max-width: {{$mass_width[6]+2}}px;" ><div>{{number_format($con_lt, 2, '.', '')}}%</div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[7]+2}}px; width: {{$mass_width[7]+2}}px; max-width: {{$mass_width[7]+2}}px;" ><div> @if($repgroup->lead != 0)
    {{number_format($repgroup->summ/$repgroup->lead, 2, '.', '')}} @else {{0}} @endif р.</div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[8]+2}}px; width: {{$mass_width[8]+2}}px; max-width: {{$mass_width[8]+2}}px;" ><div>{{ number_format($repgroup->summ, 2, '.', '') }} р.</div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[9]+2}}px; width: {{$mass_width[9]+2}}px; max-width: {{$mass_width[9]+2}}px;" ><div>0 р.</div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[10]+2}}px; width: {{$mass_width[10]+2}}px; max-width: {{$mass_width[10]+2}}px;" ><div>0%</div></td>
</tr><tr  id="m{{$hash}}"></tr>
@endif

<?php /*?>   <div>{{$repgroup->posetitel}}</div>
    <div>{{$repgroup->visit}}</div>
    <div>{{ $repgroup->sdelka }}</div>
    <div>{{$con_st}}%</div>
    <div>{{$repgroup->lead}}</div>
    <div>{{$con_lt}}%</div>
    <div>{{ $repgroup->summ}}</div>
    <div></div>
    <div> </div>
    <div> </div>


</div><div  id="m{{$hash}}"></div><?php */?>