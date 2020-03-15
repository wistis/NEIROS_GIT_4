<div class="row tab-pane active mb-20" id="basic-tab11">


<iframe src="http://chat.neiros.ru/" width="100%" height="600px" frameborder="0">


</iframe>

<!-- Fieldset legend -->
{{--<div class="row">
    <input type="hidden" value="0" id="tektema">
    <input type="hidden" value="" id="temahash">
    <input type="hidden" value="" id="temahashmd5">


    <div class="col-lg-3">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h6 class="panel-title">Список контактов</h6>
                <div class="heading-elements">

                </div>
            </div>

            <ul class="media-list media-list-linked pb-5 temaclass">
                @foreach($temas as $tema)

                    <li class="media chattema" data-tema="{{$tema->id}}" onclick="clickchattema(this)">
                        <a href="#" class="media-link">
                            <div class="media-left"><img src="{{$tema->image}}" class="img-circle img-md" alt=""></div>
                            <div class="media-body">
                                <span class="media-heading text-semibold">{{$tema->name}} #{{$tema->id}}</span>
                                <span class="media-annotation">
                                                 @if($tema->tip==4) VK @endif </span>
                                @if($tema->tip==5) Viber @endif </span>
                                @if($tema->tip==6) OK @endif </span>
                                @if($tema->tip==7) FaceBook @endif </span>
                                @if($tema->tip==8) Telegram @endif </span>
                                @if($tema->tip==12) Чат @endif </span>
                            </div>
                            <div class="media-right media-middle">
                                <span class="status-mark bg-success" id="statusmark{{$tema->id}}"
                                      @if($tema->status==0) style="display: none" @endif></span>
                            </div>
                        </a>
                    </li>

                @endforeach


            </ul>
        </div>

    </div>
    --}}{{----}}{{--
    <div class="col-md-9">

        @include('chat.chatbox')
    </div>


</div>--}}
</div>