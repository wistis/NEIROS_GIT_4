<aside class="settings js-settings">
    @if($from==0)    <header class="settings__header">
        <span>{{$my_site->name}}</span>
        <button class="btn btn--close btn--rounded js-button--close-setting">
            <i class="icon-cancel"></i>
        </button>
    </header>@else

        <button class="btn btn--close btn--rounded js-button--close-setting">
            <i class="icon-cancel"></i>
        </button>
    @endif
    <div class="settings__body">
        <div class="settings__body__inner">
           <form id="setting_chat"><label class="checkbox">
                <span>Включить звуковые оповещения</span>


                <input type="hidden" name="chat_audio" value="0">
                <input type="checkbox" name="chat_audio" @if( Auth::user()->chat_audio==1)checked="true"@endif class="sr-only chat_audio" value="1">
                <i></i>
            </label>
            <label class="checkbox">
                <span>Включить Push уведомления</span>
                <input type="hidden" class="sr-only  " name="users_push" value="0">
                <input type="checkbox" class="sr-only users_push" name="users_push"  @if( Auth::user()->users_push==1)checked="true"@endif value="1">
                <i></i>
            </label>

               <label class=" " style="margin-top: 30px;display: block">
                   <span>Выберите чат</span>


                    <select name="my_chat_site" class="my_chat_site" style="float: right">
                    <option value="0" @if(Auth::user()->selected_chat==0) selected @endif >Все сайты</option>
                        @foreach($sites as $site)
                            <option value="{{$site->id}}"  @if(Auth::user()->selected_chat==$site->id) selected @endif
                            @if($site->get_widget_on(12))
                            data-status="{{$site->get_widget_on(12)->status}}
                            @endif">{{$site->name}}

                            </option>
                        @endforeach
                    </select>

                   <i></i>
               </label>

<a href="/logout">Выход</a>

           </form>
        </div>
    </div>
    <footer class="settings__footer">
    @if($from==0)    Neiros @endif
    </footer>
    <style>
        .settings__body .select2{float: right;
            min-width: 171px;
            margin-top: -6px;}

    </style>
</aside>