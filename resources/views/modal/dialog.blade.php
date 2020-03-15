@foreach($audios as $audio)
    <div class="row">
        <div class="col-md-3">
            <div class="col-md-12">@if($audio->operator==0) Оператор @else Клиент @endif</div>
            <div class="col-md-12">
                {{date('H:i:s' ,strtotime($audio->timers))}}

            </div>

        </div>
        <div class="col-md-8">{{$audio->text}}</div>


    </div>


@endforeach