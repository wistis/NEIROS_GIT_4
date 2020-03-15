<form class="additional-info__form" style="display: block">
   @if($client_id==0) <div class=" ">
       Клиент <select name="client_id" class="form-control">
            <option value="0">Создать нового клиента</option>
            @foreach($clients as $item)
                <option value="{{$item->id}}">@if($item->fio=='') Клиент #{{$item->id}} @else{{$item->fio}}@endif  </option>

            @endforeach
        </select>
    </div>
@else
    <input type="hidden" name="client_id" value="{{$client_id}}">
    @endif

    <div class="dropdown js-dropdown">
        Тип информации  <select name="adinfo" class="form-control">

          @foreach($clients_contacts_tip as $item)
          <option value="{{$item->keytip}}">{{$item->name}}</option>

          @endforeach
      </select>
    </div>

    <input type="text" class="additional-info__form__textarea" name="value">
    <input type="hidden"  name="tema_id" value="{{$tema->id}}">
    <div class="text-center">
        <button class="btn btn--blue js-additional-form-button" type="button">Сохранить
        </button>
    </div>
</form>