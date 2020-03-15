<!-- Main navbar -->
<style>
    .navbar a{
        color: black;
    }

</style>
<div class="navbar     navbar-static navbar-fixed-top" style="background: white;">
    <div class="navbar-header">
        <a class="navbar-brand" href="/"><img src="/Neiros.png" alt="" style="height: 30px;

margin-top: -7px;margin-left: 13px;"></a>

        <ul class="nav navbar-nav pull-right visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
            <li><a class="sidebar-mobile-secondary-toggle"><i class="icon-more"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
    
    
    
    
    
        <ul class="nav navbar-nav">



      <?php /*?>      {{----}}
            <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
            {{--<li><a class="sidebar-control sidebar-secondary-hide hidden-xs"><i class="icon-transmission"></i></a></li>--}}<?php */?>




                    
                    
                 <li class="dropdown dropdown-user" id="select-id-project">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <span></span>
                    <i class="caret"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-left">
                 	      {{--@if(count($globalsetting->get_sites())>1)--}}


                        @foreach($globalsetting->get_sites() as $allsites)
                            <li><a href="#" data-value="{{$allsites->id}}"
                                    @if(Auth::user()->site==$allsites->id) class="selected-project" @endif>{{$allsites->name}}</a></li>
                        @endforeach

                    {{--@endif--}}
                    <li class="divider"></li>
                    <li><a href="/setting/sites" data-value="SITES"><i class="fa fa-cubes" aria-hidden="true" style="width: 13px;"></i> Проекты</a></li>
                    <li><a href="#" data-value="CREATE"><i class="fa fa-plus-square" aria-hidden="true" style="width: 13px;"></i> Добавить</a></li>
                </ul>
            </li>    
            <? 
$REQUEST_URI_projects = strripos($_SERVER['REQUEST_URI'], 'projects?page=');
			if ($_SERVER['REQUEST_URI'] == '/projects' || $REQUEST_URI_projects != false){ ?>
            	<li>
					<a class="sidebar-control change-visable-lids" data-popup="tooltip" title="Воронка" data-placement="bottom" data-container="body" data-original-title="Воронка" data-value="0">
					<i class="icon-bars-alt " ></i>
					</a>
				</li>
                
            <li>
					<a class="sidebar-control change-visable-lids" data-popup="tooltip" title="Таблица" data-placement="bottom" data-container="body" data-original-title="Таблица" data-value="1">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>
            
            <? } ?>
            
                
        </ul>
        
        
      
        


        <ul class="nav navbar-nav navbar-right">
         <? if ($_SERVER['REQUEST_URI'] == '/projects' || $REQUEST_URI_projects != false){ ?>
        <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-gear position-left"></i>
                                        Настройки
                                        <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="/setting/stages"><i class="icon-user-lock"></i> Этапы сделок</a></li>
                                        <li><a href="/setting/projectfield"><i class="icon-statistics"></i>Доп поля сделок</a></li>

                                    </ul>
      </li>
        
            <li class="">
                <a class="btn btn-info add-lid" onClick="AddLiddProgect()">Добавить</a>
<?php /*?>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="/projects/add"><i class="icon-user-plus"></i> Сделку</a></li>
                    <li><a href="/contacts/create"><i class="icon-user-plus"></i> Клиента</a></li>

                </ul><?php */?>
            </li>
            
            <? } ?>


            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-bubbles4"></i>
                    <span class="visible-xs-inline-block position-right">Сообщения</span>
                  @if(count($globalsetting->get_system_messages())>0)  <span class="badge bg-warning-400">{{count($globalsetting->get_system_messages())}}</span>@endif
                </a>

                <div class="dropdown-menu dropdown-content width-350">
                    <div class="dropdown-content-heading">
                        Сообщения

                    </div>

                <ul class="media-list dropdown-content-body">
                    @forelse($globalsetting->get_system_messages() as $item)   <li class="media">
                            <div class="media-left">
                                <img src="/default/assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
                                <span class="badge bg-danger-400 media-badge">1</span>
                             </div>

                            <div class="media-body">
                                @if(is_null($item->tickets))<a href="/setting/messages/{{$item->mess_id}}/edit" class="media-heading">
                                    @else
                                        <a href="{{route('wtickets.view',$item->tickets)}}?am={{$item->id}}" class="media-heading">

                                        @endif


                                    <span class="text-semibold">{{$item->tema}}</span>
                                    <span class="media-annotation pull-right">{{date('H:i d-m-Y',strtotime($item->created_at))}}</span>
                                </a>

                                <span class="text-muted">{{ str_limit(strip_tags($item->message), $limit = 100, $end = '...')}}</span>
                            </div>
                        </li>
@empty

Сообщений нет
                   @endforelse






                    </ul>

                    <div class="dropdown-content-footer">
                        <a href="https://cloud.neiros.ru/setting/messages" data-popup="tooltip" title="Все сообщени">Все сообщения</a>
                    </div>
                </div>
            </li>

             <li><a href="/setting/partners">Партнерская программа</a> </li>
            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">

                    <span>Поддержка</span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="http://help.neiros.ru/" target="_blank"><i class="icon-user-plus"></i> Документация</a></li>
                    <li><a href="/tickets"><i class="icon-coins"></i> Поддержка</a></li>
                    <li><a href="#"><i class="icon-coins"></i> Контакты</a></li>

                </ul>
            </li>
            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">

                    <span>{{Auth::user()->name}}</span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    @if(Auth::user()->role==0) <p class="navbar-text">Баланс:{{$globalsetting->get_ballans()}} руб</p>@endif
                    <li><a href="#"><i class="icon-user-plus"></i>Мой профиль</a></li>

                    @if(Auth::user()->role==0)
                    <li><a href="/setting/paycompanys"><i class="icon-coins"></i> Платежные профили</a></li>
                    <li><a href="/setting/checkcompanys">
                            @if($globalsetting->get_pay_check())
                                <span class="badge bg-teal-400 pull-right">{{$globalsetting->get_pay_check()}}</span>
                            @endif
                            <i class="icon-comment-discussion"></i> Счета</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="icon-cog5"></i> Настройки</a></li>
                    @endif
                @if (\Cookie::get('admin'))
                        <li>@php

            $prov = DB::table('users')->where('id', \Cookie::get('admin'))->first();
            if ($prov) {

               echo '<a href="#"><i class="icon-cog5"></i>S-'.\Auth::user()->my_company_id.' M-'.\Auth::user()->site.'</a></li>';
            }


             @endphp
                    </li>@endif
                    <li><a href="/logout"><i class="icon-switch2"></i> Выход</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->
<script>
 if($("#select-id-project .dropdown-menu-left a").hasClass("selected-project") ){
	 $('#select-id-project .dropdown-toggle span').text($('#select-id-project .dropdown-menu-left a.selected-project').text());
	 }
	 else{
		  $('#select-id-project .dropdown-toggle span').text('Проекты');
		 }	
</script>