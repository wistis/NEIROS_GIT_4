<div class="messages__row messages__row--to">
    <div class="message message_to" data-time="{{date('H:i',strtotime($mess->created_at))}}">
        {!! nl2br(e( $mess->mess))  !!}
    </div>
</div>