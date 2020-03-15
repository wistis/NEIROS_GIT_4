<?php /*?><tr>
    <td>  {{$newlvl}} {{$namegroup}}<img src="/25.gif" class="m{{$hash}}" style="height: 14px;

float: right;

margin-top: 4px;display: none"></td>

    <td> {{ $directINFO->Clicks}}</td>
    <td>{{$directINFO->Clicks}}</td>
    <td>{{$repgroup->sdelka}}</td>
    <td>{{$con_sd}}%</td>
    <td>{{$repgroup->lead}}</td>
    <td>{{$con_ld}}%</td>
    <td>{{$repgroup->summ}}</td>
    <td>{{$summ_rashod}} </td>

    <td>{{$requrey}}</td>
    <td>{{$roi}}</td>


</tr><tr  id="m{{$hash}}"></tr><?php */?>

@if($namegroup != '')

<tr>
    <td  style="min-width: {{$mass_width[0]+1}}px; width: {{$mass_width[0]+1}}px; max-width: {{$mass_width[0]+1}}px;" class="left-sitebar-table border-table-data"><?php /*?><div class="more-data more-data-child" ><img src="/images/icon/{{$src}}.ico">{!! $newlvl !!}  {!! $namegroup !!}</div><?php */?>
    
   <?php /*?> <div class="more-data more-data-child"><i style="display: none;" class="fa fa-minus" aria-hidden="true"></i> <i class="fa fa-plus" data-lvl="2" data-type="AdwordsApi" aria-hidden="true" style="display: block;"></i>{!! $namegroup !!}<i style="display: none;" class="fa fa-spinner fa-spin  fa-fw"></i></div><?php */?>
   
   {!! $newlvl !!}
    </td>

    <td  class="border-table-data" style="min-width: {{$mass_width[1]+2}}px; width: {{$mass_width[1]+2}}px; max-width: {{$mass_width[1]+2}}px;" ><div> {{ $directINFO->Clicks}}</div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[2]+2}}px; width: {{$mass_width[2]+2}}px; max-width: {{$mass_width[2]+2}}px;" ><div>{{$repgroup->sdelka}}</div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[3]+2}}px; width: {{$mass_width[3]+2}}px; max-width: {{$mass_width[3]+2}}px;" >{{number_format($con_sd, 2, '.', '')}}%<div></div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[4]+2}}px; width: {{$mass_width[4]+2}}px; max-width: {{$mass_width[4]+2}}px;" >{{number_format($requrey, 2, '.', '')}} р.<div></div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[5]+2}}px; width: {{$mass_width[5]+2}}px; max-width: {{$mass_width[5]+2}}px;" ><div>{{$repgroup->lead}}</div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[6]+2}}px; width: {{$mass_width[6]+2}}px; max-width: {{$mass_width[6]+2}}px;" ><div>{{number_format($con_ld, 2, '.', '')}}%</div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[7]+2}}px; width: {{$mass_width[7]+2}}px; max-width: {{$mass_width[7]+2}}px;" ><div> @if($repgroup->lead != 0)
    {{number_format($repgroup->summ/$repgroup->lead, 2, '.', '')}} @else {{0}} @endif р.</div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[8]+2}}px; width: {{$mass_width[8]+2}}px; max-width: {{$mass_width[8]+2}}px;" ><div>{{ number_format($repgroup->summ, 2, '.', '') }} р.</div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[9]+2}}px; width: {{$mass_width[9]+2}}px; max-width: {{$mass_width[9]+2}}px;" ><div>{{ number_format($summ_rashod, 2, '.', '') }} р.</div></td>
    <td class="border-table-data" style="min-width: {{$mass_width[10]+2}}px; width: {{$mass_width[10]+2}}px; max-width: {{$mass_width[10]+2}}px;" ><div>{{$roi}}</div></td>
</tr><tr  id="m{{$hash}}"></tr>
@endif