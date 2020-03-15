@extends('app')
@section('title')
    Контакты

@endsection
@section('content')


    <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>


    </div>

    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="#" method="post" id="formclientedit">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />
            <input name="projectId" type="hidden"  id="contactId" value="{{$id or 0}}" />

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Редактирование контакта</h5>

                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>
                            <div class="form-group">
                                    <label class="col-lg-3 control-label">ФИО:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="fio" id="fio" value="{{$fio or ''}}"  required>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Компания:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="company" id="company" value="{{$company or ''}}"  required>
                                    </div>
                                </div>

                               {{-- <div class="row">{!!  $client_field !!}</div>--}}
<div class="row clients_contact">
@foreach($clients_contacts as $item)
 <div class="form-group">
                                        <label class="col-lg-3 control-label">{{$clients_contacts_tip[$item->keytip]}}:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="edit_val[]" id="company" value="{{$item->val}}" >
                                            <input type="hidden"  name="edit_id[]" value="{{$item->id}}" >
                                        </div>
                                    </div>

@endforeach






</div>   <button class="btn btn-info addfieldcc" type="button"><i class="fa fa-plus"></i> </button>                         </fieldset>
                        </div>
{{--Дополнительные поля--}}
                        <div class="col-md-6">
                            <fieldset>


                            </fieldset>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="button" class="btn btn-primary edit_contact">Создать<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>
    <div class="hiddenexample">

        <div class="form-group">
            <label class="col-lg-3 control-label">
                <select class="form-control" name="add_keytip[]">
                   @foreach(  $clients_contacts_tip as $key=>$val)
                    <option value="{{$key}}">{{$val}}</option>

                   @endforeach
                </select>

               :</label>
            <div class="col-lg-9">
                <input type="text" class="form-control" name="add_val[]"  value="" >

            </div>
        </div>



    </div>

        <script>
$('body').on('click','.addfieldcc', function ()  {
    $('.clients_contact').append($('.hiddenexample').html());
});

$('.edit_contact').click(function () {



        $.ajax({
            type: "POST",
            url: '/ajax/client_edit_safe',
            data: $('#formclientedit').serialize(),
            success: function (html1) {


                mynotif( 'Успешно!','Изменения успешно сохранены','success')

            }
        })





    return false;
});



        </script>
@endsection
