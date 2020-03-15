<script src="/global_assets/js/plugins/notifications/pnotify.min.js"></script>
<script>


        // Ваш скрипт



    function mynotif(title,text,status){
        new PNotify({
            title: title,
            text: text,
            icon: 'fa-success' ,type: 'info',styling:'fontawesome'
        });
    }


</script>

@if($errors->first() != '')
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">{{ trans('ticketit::lang.flash-x') }}</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(Session::has('warning'))
    <script>
        mynotif('Успешно', '   {{ session('warning') }}', 'info')
    </script>

@endif
@if(Session::has('status'))
    <script>
        mynotif('Успешно', '   {{ session('status') }}', 'info')
    </script>

@endif
