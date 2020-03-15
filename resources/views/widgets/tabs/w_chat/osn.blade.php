
<li class="active"><a href="#basic-tab0" data-toggle="tab">Основное</a></li>
<li><a href="#basic-tab1" data-mytab="active_chat" data-toggle="tab"
       @if($widget_vk->active_chat==0) style="display:none;" @endif >Чат</a></li>
<li><a href="#basic-tab7" data-mytab="active_chat" data-toggle="tab"
       @if($widget_vk->active_chat==0) style="display:none;" @endif >Быстрые ответы</a>
</li>

<li><a href="#basic-tab2" data-mytab="active_callback" data-toggle="tab"
       @if($widget_vk->active_callback==0) style="display:none;" @endif >Обратный звонок</a>
</li>
<li><a href="#basic-tab3" data-mytab="active_formback" data-toggle="tab"
       @if($widget_vk->active_callback==0) style="display:none;" @endif >Написать нам</a>
</li>
<li><a href="#basic-tab4" data-mytab="active_map" data-toggle="tab"
       @if($widget_vk->active_map==0) style="display:none;" @endif >Карты</a>
</li>
<li><a href="#basic-tab5" data-mytab="active_social" data-toggle="tab"
       @if($widget_vk->active_social==0) style="display:none;" @endif >Соц сети</a>
</li>
