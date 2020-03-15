<div class="info__intro">
    @if($tema->image!='')    <img src="{{$tema->image}}"
                                  class="avatar js-button-info-open" alt="" style="width: 64px">@else
        <img src="/templatechat/images/pfotografy-none.jpg" class="avatar js-button-info-open"
             alt=""> @endif

    <div class="info__intro__customer">
        <div class="info__intro__name">{{$tema->name}}  @if($metrika_last)({{$metrika_last->neiros_visit}}) @endif</div>
        @if($metrika_last)   <div class="info__intro__date text-number text-muted">{{'в сети '.date('d.m.Y H.i',strtotime($metrika_last->created_at))}}
        </div>@endif
    </div>
</div>
@if($client)
    <div class="info__phone">
        <div>
            <i class="icon-info-circled"></i>
        </div>
        <div>
            <a href="tel:70999898999" class="text-number reset-link">+7 099 989 89 99</a>
            <span class="d-block text-muted info__phone__mobile">Мобильный телефон</span>
        </div>
    </div>
@endif
<div class="info__holder">
    @if($client)
        <div class="info__holder__title text-muted">Основная информация</div>
      @foreach($clinfo as $item)
            <div class="info__row">
            <div>{{$clients_contacts_tip[$item['keytip']]}}</div>
            <div class="text-number">{{$item->val}}</div>
        </div>
@endforeach


    @endif
    @if($metrika_first)
        <div class="info__holder__title text-muted">Аналитика</div>
        @if($metrika_first->trim!='')
            <div class="info__row">
                <div>ключевой запрос</div>
                <div>'{{$metrika_first->trim}}'</div>
            </div>
        @endif

        @if($metrika_first->typ=='utm')

            @if($metrika_first->src!='')
                <div class="info__row">
                    <div>UTM_source</div>

                <div>{{$metrika_first->src}}</div>
           </div>
                @endif
                @if($metrika_first->mdm!='')
                    <div class="info__row">
                        <div>UTM_medium</div>

                        <div>{{$metrika_first->mdm}}</div>
                    </div>
                @endif
                @if($metrika_first->cmp!='')
                    <div class="info__row">
                        <div>UTM_companing</div>

                        <div>{{$metrika_first->cmp}}</div>
                    </div>
                @endif
                @if($metrika_first->cnt!='')
                    <div class="info__row">
                        <div>UTM_content</div>

                        <div>{{$metrika_first->cnt}}</div>
                    </div>
                @endif

@endif
<div class="info__row">
    <div>просм.страницы ({{$metrika_count_page}})</div>
    <a href="#" class="text-link allpage" onclick="allpage()">весь список</a>
</div>
<div class="info__row">
    <div>пришел из</div>
    <div>{{$metrika_first->typ}} - {{$metrika_first->src}}</div>
</div>

            <div class="info__row">
                <div>Обращение из</div>
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

                                    </div> @endif

            </div>
                                {{--<a href="mailto:test@test.com" class="text-link">test@test.com</a>--}}

@if($metrika_last)
    <div class="info__last-visit text-number">
        <span class="text-muted">Был на сайте: </span> {{date('H:i d.m.Y',strtotime($metrika_last->created_at))}}
    </div>
    @endif
    @endif
    </div>

    <div class="info__footer">

        <div class="additional-info js-additional-info">

        </div>
        <div class="text-center">
            <button class="btn btn--big js-additional-form">Добавить информацию</button>
        </div>

    </div>