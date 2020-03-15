<script>
    ids_callback=[];
    ids_calltrack=[];

</script>
    <script>
    
	
	var_select = '{{$project_vid}}'; 
	if(var_select === '0'){
		$('.change-visable-lids .icon-bars-alt').addClass('text-primary');
		$('.change-visable-lids .icon-bars-alt').closest('li').addClass('disabled')
		}
	else{
		$('.change-visable-lids .icon-paragraph-justify3').addClass('text-primary');
		$('.change-visable-lids .icon-paragraph-justify3').closest('li').addClass('disabled')
		}	
    </script>






<div class="row row-sortable">

<div class="table-responsive">
<div class="col-xs-12">
    <table class="table datatable-basic">
        <thead>
        <tr>
            <th>#</th>
            <th>ФИО</th>
            <th>Запись / E-mail</th>
            <th>Этап</th>
            <th>Название</th>
            <th>Дата</th>
            <th>Info</th>

           {{-- <th>Источник</th>
            <th>Url</th>

            <th>Ключ</th>
            <th>Регион</th>--}}




        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <?
            $info='';//$ProjectController->get_metrika($project);

            ?><tr   id="del{{$project->id}}">
                <td>{{$project->client_project_id}}  </td>
                <td> @if($project->fio=="") {{$project->phone}} @else {{$project->fio}} @endif


                </td>
                <td{{-- data-idr="rec{{$project->uniqueid}}"  data-idr2="rec2{{$project->call_back_random_id}}"--}}>

                    <div  data-idr="rec{{$project->uniqueid}}"></div>
                    <div   data-idr2="rec2{{$project->call_back_random_id}}"></div>
                    @if(!is_null($project->call_back_random_id))
                        <script>ids_callback.push('{{$project->call_back_random_id}}');</script>
                    @else


                    @if(isset($widgets[$project->widget_id]))

                   @if($widgets[$project->widget_id]==2)
                        <script>ids_calltrack.push('{{$project->uniqueid}}')</script>
                        {{-- {!! $ProjectController->get_audio($project->uniqueid) !!}--}} @endif
                    @if($widgets[$project->widget_id]==9)    {!! $ProjectController->get_email($project->id) !!} @endif
                       @if($widgets[$project->widget_id]==12)
                           <script>ids_callback.push('{{$project->uniqueid}}')</script>
                           {{-- {!! $ProjectController->get_audio_callback($project->uniqueid) !!}--}} @endif
                       @if($widgets[$project->widget_id]==1)
                           <script>ids_calltrack.push('{{$project->uniqueid}}')</script>
                           <script>ids_callback.push('{{$project->uniqueid}}')</script>
                           {{-- {!! $ProjectController->get_audio_callback($project->uniqueid) !!}--}} @endif
                       @endif
                       @endif


                </td>
                <td> @if($project->stage_id==0) Неразобранное @else {{$ProjectController->get_stage($project->stage_id)}}   @endif</td>
                <td> <a href="/projects/edit/{{$project->id}}">
                        @if($project->name=="") Без названия @else {{$project->name}} @endif


                    </a></td>
                <td>{{date('H:i d.m.Y',strtotime($project->created_at))}}</td>
                <td><button class="btn btn-info" onclick="openclinfo({{$project->id}})" ><i class="fa fa-info"></i> </button> </td>


                @if(!is_null($info))
                  {{--  <td>{{$info->typ}} {{$info->src}}</td>
                    <td>{{explode('?',$info->ep)[0] }}</td>

                    <td>{{str_replace("+"," ",explode('?',$info->trim)[0])}}
                        @if(($info->src=='yandex.ru' )||($info->src=='referral yandex.ru'))
                    {!! $ProjectController->get_metrikakey($info->hash) !!}
                        @endif
                    </td>
                    <td>{{$ProjectController->get_region($info->hash)}} </td>--}}

                @else
                    <td></td>
                    <td></td>
                    <td> </td>
                @endif





            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</div>
<script>
console.log("+++");
console.log(ids_calltrack);
console.log("+++");

    function openclinfo(id){

        $('#ClientInfoModal').modal('show');
        $.ajax({
            type: "POST",
            url: '/ajax/get_client_info',
            data: "id="+id,
            success: function (html1) {
/*$('#ClientInfoModal .activnost').html('<div class="diliver diliver--gray"><span>Четверг</span></div><audio controls=""><source src="http://82.146.43.227/records/2019/05/27/2019-05-27_18:42_79530986997_78122009357_1558971720.397.mp3" type="audio/mp3"></audio>')	*/			
$('.infclinfo').html(html1);


            }
        })

    }

    console.log(ids_callback);
    console.log(ids_calltrack);

    datatosend={
        ids_callback:ids_callback,
        ids_calltrack:ids_calltrack
    }

    $.ajax({
        type: "POST",
        url: '/ajax/get_audio',
        data: datatosend,
        success: function (html1) {
            res=JSON.parse(html1);
            ids_callback.forEach(function(item, i, arr) {

                //$('#rec'+item).html( res['callback'][item] ) ;
                $('[data-idr2="rec2'+item+'"]').html( res['callback'][item] ) ;
            });
            ids_calltrack.forEach(function(item, i, arr) {

                $('[data-idr="rec'+item+'"]').html( res['calltrack'][item] ) ;

            });


        }
    })



</script>

 
</div>