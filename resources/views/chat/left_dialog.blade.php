

<div class="messages__row messages__row--from">
    <div class="message message_from" data-time="{{date('H:i',strtotime($mess->created_at))}}">
        {!! nl2br(e( $mess->mess))  !!}
    </div>
</div>


