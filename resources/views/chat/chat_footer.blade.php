{{--<div class="chat__footer__notification">
    <i class="writting-state writting-state--active">
        <i class="icon-pencil"></i>
        Печатает...</i>
</div>--}}

<div class="quick-answers js-quick-answers">
    <button type="button"
            class="btn dropdown__button quick-answers__button js-quick-answers-button">
        Быстрые ответы
    </button>
    <div class="quick-answers__wrapper">
        <div class="quick-answers__holder">
            @foreach($fasts as $fast)<button class="btn quick-answers__item">{{$fast->name}}</button>@endforeach

         <a href="https://cloud.neiros.ru/widget/tip/12" target="_blank" class="btn text-link">+ Добавить</a>
        </div>
    </div>
</div>

<form action="" class="form-send"  id="forma-chat">
    <div class="form-send__wrap">
        <button class="btn form-send__smile" type="button"><i class="icon-smile"></i></button>
        <textarea  class="form-send__input form-field enter-message" name="enter-message"
               placeholder="Введите сообщение"
                   autocomplete="off"></textarea>

        <label class="btn form-send__attach">
            <i class="icon-attach"></i>
            <input type="file" class="sr-only">
        </label>
    </div>
    <button class="form-send__submit" type="button" onclick="sendmess();return false;"><i class="icon-forward"></i></button>
</form>