<div class="user-item js-user-item js-button-users-close" data-tema="{{$tema->id}}"
     onclick="clickchattema(this)" id="temablockid{{$tema->id}}">
    <div class="user-item__wrap">
        {{--id="statusmark{{$tema->id}}"  @if($tema->status==0) style="display: none" @endif--}}
        <div class="user-item__img" id="statusmark{{$tema->id}}"
             @if($tema->status>0) data-messages="1" @endif>
            @if($tema->image!='')    <img src="{{$tema->image}}"
                                          class="avatar js-button-info-open" alt="" style="width: 64px">@else
                <img src="/templatechat/images/pfotografy-none.jpg" class="avatar js-button-info-open"
                     alt=""> @endif
        </div>
        <div>
            <div class="user-item__name">
                @if($tema->name=='') Клиент @else    {{$tema->name}}@endif №{{$tema->hid_id}}
            </div>

            @if($tema->tip==4)
                <div class="user-item__social facebook-color">
                    <i class="icon-vkontakte"></i>
                    vkontakte
                </div> @endif </span>
                @if($tema->tip==5)
                    <div class="user-item__social viber-color">
                        <i class="icon-phone"></i>
                        viber
                    </div> @endif </span>
                    @if($tema->tip==6)
                        <div class="user-item__social odnoklassniki-color">
                            <i class="icon-odnoklassniki"></i>
                            odnoklassniki
                        </div> @endif </span>
                        @if($tema->tip==7)
                            <div class="user-item__social facebook-color">
                                <i class="icon-facebook"></i>
                                facebook
                            </div> @endif </span>
                            @if($tema->tip==8)
                                <div class="user-item__social telegram-color">
                                    <i class="icon-paper-plane"></i>
                                    телеграмм
                                </div> @endif </span>
                                @if($tema->tip==12)
                                    <div class="user-item__social chat-color">
                                        <i class="icon-comment-empty"></i>
                                        чат
                                    </div> @endif </span>

        </div>
    </div>
    <div class="user-item__date">
        {{date('d.m.Y',strtotime($tema->updated_at))}}
    </div>
</div>