<div class="info__intro">
    @if($tema->image!='')    <img src="{{$tema->image}}"
                                  class="avatar js-button-info-open" alt="" style="width: 64px">@else
        <img src="/templatechat/images/pfotografy-none.jpg" class="avatar js-button-info-open"
             alt=""> @endif

    <div class="info__intro__customer">
        <div class="info__intro__name">{{$tema->name}}</div>
        <div class="info__intro__date text-number text-muted">{{'в сети '.date('d.m.Y H.i',strtotime($tema->updated_at))}}
        </div>
    </div>
</div>

<div class="info__holder">

    <div class="info__row">
        <div> </div>
        <div><i class="icon-cancel" onclick="getuserinfo()"></i>  </div>
    </div>
    @foreach($metrika_last as $item)

        <div class="info__row">
            <div>{{$item->fd}}</div>
            <div>{{$item->ep}}  </div>
        </div>
 @endforeach
        {{--<a href="mailto:test@test.com" class="text-link">test@test.com</a>--}}



</div>

