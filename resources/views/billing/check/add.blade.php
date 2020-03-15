@extends('app')
@section('title')
    Добавить платежный профиль

@endsection
@section('content')
    <style>
        .coltrack{
            display: none;
        }

    </style>
    <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>


        </ul>


    </div>



    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="/setting/checkcompanys" method="POST" id="myform">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Выставить счет</h5>
                    <input name="id" type="hidden"  id="id" value="0" />
                </div>

                <div class="panel-body">

                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#basic-tab1" data-toggle="tab">Основное</a></li>


                        </ul>
                        <div class="tab-content">



                            <div class="row tab-pane active"   id="basic-tab1">
                                <div class="col-md-12">
                                    <fieldset>


                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Компания:</label>
                                            <div class="col-lg-6">
                                                <select name="company_id" class="form-control" required>
                                                    <option value="">Выберите компанию</option>
                                                    @foreach($company as $com)
                                                        <option value="{{$com->id}}" @if($com->id==$comps) selected @endif >{{$com->short_name}} ({{$com->inn}})</option>

                                                    @endforeach
                                                </select>


                                            </div>
                                            <div class="col-lg-3"><a href="/setting/paycompanys/create" class="btn btn-success">Добавить</a> </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Сумма:</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" name="summ" required>
                                            </div>
                                        </div>



                                    </fieldset>
                                </div>
                                {{--Дополнительные поля--}}

                            </div>






                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Создать<i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
        </form>

        <script>
          function  provbik(){
              bic=$('#bik').val();
              $.get( "https://bik-info.ru/api.html?type=json&bik="+bic, function( data ) {
                  res=data;


                  $( ".frombic" ).html(`
                  Кор.с: `+res['ks']+`<br>
                  Название: `+res['name']+` `  );

              });

          }
        </script>
@endsection
