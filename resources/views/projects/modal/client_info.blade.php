<div id="ClientInfoModal" class="modal fade ClientInfoModal lids-neiros">
    <div class="modal-dialog" >
        <div class="modal-content"  style="height: 100vh">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >×</button>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">
            <div class="name-block-fixed">
           <div class="col-sm-5 col-xs-12" ><div class="h1-modal pos-left">Информация пользователя</div></div>
           <div class="col-sm-7 col-xs-12" ><div class="h1-modal pos-right">Активность</div></div>
            </div>
            
            
                <div class="col-sm-5 col-xs-12" >
                    <?php /*?><div class="h1-modal">Информация пользователя</div><?php */?>
                    <div class="user-block col-xs-12">
                        <div class="col-xs-4 img-avatar">

                            @if($vidget_social)
                                <img src="{{$vidget_social->photo_200}}" width="100%">
                            @else
                            <img src="/templatechat/images/pfotografy-none.jpg" width="100%">@endif</div>
                        <div class="col-xs-8 user-description">
                            <div class="h1">@if($project->fio=='')Клиент №{{$project->neiros_visit}}@else{{$project->fio}}@endif  @if($ban==1)<span class="baneed" data-id="{{$project->neiros_visit}}" style="color: red;cursor: pointer;">Забанен</span>


                                @else  <span class="baneed" data-id="{{$project->neiros_visit}}" style="color: green;cursor: pointer;">Забанить?</span> @endif</div>
                            <div class="h2"><span>в сети:</span>
                                @if($metrika_last) <span>{{date('d.m.Y',strtotime($metrika_last->created_at))}} </span> <span>{{date('H:y',strtotime($metrika_last->created_at))}}</span>
                              @else
                                    <span>{{date('d.m.Y',strtotime($project->created_at))}} </span> <span>{{date('H:y',strtotime($project->created_at))}}</span>
                                @endif

                               </div>
                        </div>
                    </div>
                    <div class="col-xs-12" style="padding-left:0px; padding-right:0px;">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#info" aria-controls="home" role="tab" data-toggle="tab">Основная информация</a></li>
                            <li role="presentation"><a href="#analitics" aria-controls="profile" role="tab" data-toggle="tab">Аналитика</a></li>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="info">
                                <div class="">
                                    {{--  <div class="form-group">
                                      <label for="date">Дата рождения</label>
                                        <input type="text" class="form-control" id="date" placeholder="Дата рождения" value="23.11.1986">
                                    </div>
                                    <div class="form-group">
                                        <label for="age">Возраст</label>
                                        <input type="text" class="form-control" id="age" placeholder="Возраст" value="30 лет">
                                    </div>
                                    <div class="form-group">
                                        <label for="pol">Пол</label>

                                        <select class="form-control" id="pol" >
                                            <option selected>Мужской</option>
                                            <option>Женский</option>
                                        </select>
                                    </div> --}}
                                  
                                    <div class="form-group col-xs-12" style="padding-left:0px; padding-right:0px;">
                                        <label for="city">ФИО</label>
                                        <input type="text" readonly data-input-cont-id="{{$project->id}}" data-old-val="{{$project->fio}}"  class="form-control" id="fio" data-input-name="projects_fio" placeholder="Фио" value="{{$project->fio}}"><i class="fa fa-pencil" aria-hidden="true"></i><i class="fa fa-floppy-o" aria-hidden="true"></i>
                                    </div>


                                    <div class="form-group col-xs-12" style="padding-left:0px; padding-right:0px;">
                                        <label for="city">Телефон</label>
                                        <input type="text" readonly data-input-cont-id="{{$project->id}}"  data-input-name="projects_phone" data-old-val="{{$project->phone}}"  class="form-control" id="city" placeholder="Телефон" value="{{$project->phone}}"><i class="fa fa-pencil" aria-hidden="true"></i><i class="fa fa-floppy-o" aria-hidden="true"></i>
                                    </div>


                                    <div class="form-group col-xs-12" style="padding-left:0px; padding-right:0px;">
                                        <label for="city">E-mail</label>
                                        <input type="text" readonly data-input-cont-id="{{$project->id}}" data-old-val="{{$project->email}}"  class="form-control" id="email" data-input-name="projects_email" placeholder="E-mail" value="{{$project->email}}"><i class="fa fa-pencil" aria-hidden="true"></i><i class="fa fa-floppy-o" aria-hidden="true"></i>
                                    </div>
                                    
                                </div>

                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="analitics">{!! $table !!}</div>

                        </div>


                    </div>
                </div>

                <div class="col-sm-7 col-xs-12 right-block-mod" >
                    <?php /*?><div class="h1-modal">Активность</div><?php */?>
				
                    <div class="activnost">
                    <div class="block-activnost">
                        @foreach($dat as $keym=>$vals)

                            @if(isset($info[$vals]))
                                @if($vals==date('Y-m-d'))
                                    <div class="diliver diliver--gray"><span>Сегодня</span></div>
                                @elseif($vals==date('Y-m-d',strtotime('-1 day',strtotime(date('Y-m-d')))))
                                    <div class="diliver diliver--gray"><span>Вчера</span></div>
                                @else
                                    <div class="diliver diliver--gray"><span>{{date('d.m.Y',strtotime($vals))}}</span></div>
                                @endif
                                @foreach($info[$vals] as $key=>$val)




                          {{--status--}}       <div class="activnost-block
@if($val['type']==2)zvonok
@elseif($val['type']==1)sdelka
@elseif($val['type']==0)status
@else sdelka
                                    @endif
                                          ">
                                      <div class="time-event">
                                          {{$val['name']}}
                                          <span>в  {{$val['time']}}</span>
                                      </div>

                                            @if(isset($val['content'])) {!! $val['content'] !!} @endif
                                            @if(isset($val['content2'])) {!! $val['content2'] !!} @endif
                                  </div>


                            @endforeach
@endif
                        @endforeach


                    </div>
                    
                 </div>   

                </div>
            </div>


        <?php /*?><div class="modal-body infclinfo" >

            </div><?php */?>
        <!-- Футер модального окна -->

        </div>
    </div>
</div>

