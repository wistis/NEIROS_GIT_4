<div class="modal-dialog" >
    <div class="modal-content"  style="height: 100vh">
        <!-- Заголовок модального окна -->
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >×</button>
        </div>
        <!-- Основное содержимое модального окна -->
        <div class="modal-body">
            <div class="name-block-fixed">
                <div class="col-xs-12" ><div class="h1-modal pos-left">Информация пользователя</div></div>
            </div>

            <div class="user-neiros-all-blocks col-xs-12">
<form id="form_user_save" name="my_form" enctype="multipart/form-data">
                <div class="user-block col-xs-12">
                    <div class="user-title"><img src="/global_assets/images/icon/user/id-card.svg"> Основная информация</div>

                    <div class="col-xs-3 img-avatar">

<!--                            @if((isset($user))&&($user->image!=''))
                            <span class="user-avatar">  <img src="/user_upload/user_logo/{{$user->image}}"></span>

                            @else
                            <span class="user-avatar">  <img src="/global_assets/images/icon/user/user.svg"></span>
                            @endif
<input type="file" name="image">-->

                                    
                             <img class="i-img-hover" data-alt-src="https://cloud.neiros.ru/global_assets/images/icon/user/i-user-hover.png"
                                    src="https://cloud.neiros.ru/global_assets/images/icon/user/i-user.png" />
                                    
                                    
                                    
                                    <div class="i-user-prev-block">
                                    
                                     <img class="i-close" data-alt-src="https://cloud.neiros.ru/global_assets/images/icon/user/i-close-hover.png"
                                    src="https://cloud.neiros.ru/global_assets/images/icon/user/i-close.png" />
                                    
                                 
                                   
                                    <img class="i-icon-prew" src="https://cloud.neiros.ru/global_assets/images/icon/user/i-user-prev.png" alt="">
                                    <div class="i-icon-text">
                                    Можно загрузить картинку в
                                    формате png, jpg и gif. Размеры не
                                    меньше 200 × 200 точек, объём
                                    файла не больше 7 МБ.
                                    </div>
                                    
                                    <button type="button" id="i-ava-save" class="btn btn-primary s-ava-save  i-ava-btn">Сохранить
                                    </button>
                                    
                                        <div class="i-user-prev">
                                        
                                        
                                        
                                            <div class="input i-input">
                                                <input name="input" id="file" type="file">
                                            </div>
                                        </div>
                                    </div>

					

                    </div>
                    <div class="col-xs-9 user-description">
                        <div class="form-group col-xs-12" style="padding-left:0px; padding-right:0px;">
                            <label for="city">Имя</label>
                            <input type="text"  data-input-cont-id="21109" data-old-val=""  class="form-control" id="fio" data-input-name="projects_fio" placeholder="Фио" value="{{optional($user)->name}}" name="name"><i class="fa fa-pencil" aria-hidden="true"></i><i class="fa fa-floppy-o" aria-hidden="true"></i>
                        </div>


                        <div class="form-group col-xs-12" style="padding-left:0px; padding-right:0px;">
                            <label for="city">E-mail</label>
                            <input type="text"  data-input-cont-id="21109" data-old-val=""  class="form-control" id="email" data-input-name="projects_email" placeholder="E-mail" value="{{optional($user)->email}}" name="email"><i class="fa fa-pencil" aria-hidden="true"></i><i class="fa fa-floppy-o" aria-hidden="true"></i>
                        </div>
                        <div class="form-group col-xs-12" style="padding-left:0px; padding-right:0px;">
                            <label for="city">Пароль</label>
                            <input type="password"  data-input-cont-id="21109" data-old-val=""  class="form-control" id="email" data-input-name="projects_email" placeholder="Пароль" value="{{optional($user)->password}}" name="password" autocomplete="off" ><i class="fa fa-pencil" aria-hidden="true"></i><i class="fa fa-floppy-o" aria-hidden="true"></i>
                        </div>

                        <div class="form-group col-xs-12" style="padding-left:0px; padding-right:0px;">
                            <label for="city">Телефон</label>
                            <input type="text"  data-input-cont-id="21109"  data-input-name="projects_phone" data-old-val="{{optional($user)->phone}}"  class="form-control" id="city" placeholder="Телефон" value="{{optional($user)->phone}}" name="phone"><i class="fa fa-pencil" aria-hidden="true"></i><i class="fa fa-floppy-o" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

                <div class="user-block col-xs-12 user-block-security">
                    <div class="user-title"><img src="/global_assets/images/icon/user/shield.svg"> Права доступа</div>

                    <div class="form-group col-sm-5 col-xs-12 select-conainer-icon-multi select-conainer-icon-roll" style="padding-left:10px; padding-right:0px;">
                        <label for="roll" style="width:20%;">Роль</label>
                        <select data-placeholder="+ Добавить Роль" multiple="multiple" class="select-icons select-roll-user form-group" style="width:80%" id="roll" name="role[]" autocomplete="off">

                          <?php /*?>  <option value="0" @if(in_array(0,$usergroups_role)) selected @endif>Администратор</option>
                            <option value="1" @if(in_array(1,$usergroups_role)) selected @endif>Менеджер</option>
                            <option value="2"@if(in_array(2,$usergroups_role)) selected @endif>Оператор</option><?php */?>
                            <option value="0" >Администратор</option>
                            <option value="1" selected >Менеджер</option>
                            <option value="2">Оператор</option>
                        </select>
                    </div>
                    @if(isset($user->id))
<input type="hidden" name="id" value="{{optional($user)->id}}">@else

                        <input type="hidden" name="id" value="0">
                        @endif
                    <div class="form-group col-sm-5 col-xs-12 select-conainer-icon-multi select-conainer-icon-group2" style="padding-left:0px; padding-right:0px;">
                        <label for="group" style="width:20%;">Группа</label>
                        <select data-placeholder="+ Добавить Роль" multiple="multiple" class="select-icons select-group2-user form-group" style="width:80%" id="group" name="users_group_id[]" autocomplete="off">
                            <option value="0">Без группы</option>
<?php /*?>                            @foreach($usergroups as $ug)
                                <option value="{{$ug->id}}" @if(in_array($ug->id,$usergroups_select) ) selected @endif>  {{$ug->name}}</option>

                            @endforeach<?php */?>
                        </select>
                    </div>

                </div>

                <div class="col-xs-12 " style="padding-left:0px; padding-right:0px; margin-top:30px;display: none">

                    <div class="user-title"><img src="/global_assets/images/icon/user/settings.svg"> Доступ к модулям</div>

                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#deals" aria-controls="home" role="tab" data-toggle="tab">Сделки</a></li>
                        <li role="presentation"><a href="#tasks" aria-controls="profile" role="tab" data-toggle="tab">Задачи</a></li>
                        <li role="presentation"><a href="#contacts" aria-controls="profile" role="tab" data-toggle="tab">Контакты</a></li>
                        <li role="presentation"><a href="#compani" aria-controls="profile" role="tab" data-toggle="tab">Компании</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="deals">
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Просмотр
                                    <input type="checkbox" checked="checked">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Создание
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Редактирование
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Удаление
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tasks">
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Просмотр
                                    <input type="checkbox" checked="checked">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Создание
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Редактирование
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Удаление
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="contacts">
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Просмотр
                                    <input type="checkbox" checked="checked">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Создание
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Редактирование
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Удаление
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="compani">
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Просмотр
                                    <input type="checkbox" checked="checked">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Создание
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Редактирование
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="container-user-checkbox">Удаление
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                    </div>


                </div>
                    <div class="form-group footer-button">
                        <div class="col-xs-12">
                            <button type="button" class="btn btn-primary  w_safebutton_new">Сохранить</button>

                            <button type="button" class="btn btn-default " data-dismiss="modal" aria-hidden="true">Закрыть</button>
                        </div>

                    </div>
</form>

            </div>


        </div>


    </div>


    <!-- Футер модального окна -->

</div>





<script>


var sourceSwap = function () {
        var $this = $(this);
        var newSource = $this.data('alt-src');
        $this.data('alt-src', $this.attr('src'));
        $this.attr('src', newSource);
    }



    $(function () {
        $('.i-img-hover').hover(sourceSwap, sourceSwap);
    });




    $(function () {
        $('.i-close').hover(sourceSwap, sourceSwap);
    });	



	 


$('.i-img-hover').click(function(){
  $('.i-user-prev-block').show();
});


$('.i-close').click(function(){
  $('.i-user-prev-block').hide();
});




$(function(){
	var container = $('.i-user-prev'), inputFile = $('#file'), img, btn, txt = 'Загрузить изображение', txtAfter = 'Изображение загружено';
			
	if(!container.find('#upload').length){
		container.find('.input').append('<input type="button" value="'+txt+'" id="upload">');
		btn = $('#upload');
		container.prepend('<img src="" class="hidden" alt="Uploaded file" id="uploadImg" width="100">');
		img = $('#uploadImg');
	}
			
	btn.on('click', function(){
		img.animate({opacity: 0}, 300);
		inputFile.click();
	});

	inputFile.on('change', function(e){
		container.find('label').html( inputFile.val() );
		
		var i = 0;
		for(i; i < e.originalEvent.srcElement.files.length; i++) {
			var file = e.originalEvent.srcElement.files[i], 
				reader = new FileReader();

			reader.onloadend = function(){
				img.attr('src', reader.result).animate({opacity: 1}, 700);
			}
			reader.readAsDataURL(file);
			img.removeClass('hidden');
		}
		
		btn.val( txtAfter );
	});
});
 




</script>



