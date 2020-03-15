@extends('phscript.app')
@section('title')
    Сделки - редактирование
@endsection
@section('content')
    <link rel="stylesheet" href="/vendor/jsplumb/style.css">
    <style>
        .condition-positive {
            border-top-width: 3px !important;
            padding-top: 2px;
            border-top-color: #00BA5B !important;
        }

        .condition-negative {
            border-top-width: 3px !important;
            padding-top: 2px;
            border-top-color: red !important;
        }

        .link .panel {
            border-top-width: 4px;
        }

        .link_positive {
            border-top-color: #00BA5B !important;
        }

        .link_normal {
            border-top-color: #ddd !important;
        }

        .link_negative {
            border-top-color: red !important;
        }

        .w .add_step {

            position: absolute;
            left: 15px;
            bottom: 5px;
            width: 16px;
            height: 16px;
            background: #00BA5B url('/glyphicons-halflings.png') no-repeat -407px -95px;
            cursor: pointer;
            border-radius: 4px;
        }

        .red {
            color: red;
        }

        .bgred {
            background: red;

            border-radius: 10px;

            color: white;

            font-size: 12px;

            padding: 3px;
        }

        .green {
            color: green;
        }

        .blue {
            color: blue;
        }

        .pointer {
            cursor: pointer;
        }

        .truedel {
            display: none;
        }

        .aLabel {
            font-size: 16px;

            font-family: Arial;

            position: absolute;

            border: 1px solid black;

            border-radius: 6px;

            background: white;

            opacity: 0.8;

            cursor: move;

            z-index: 81;
        }

        .is_goal {
            background: #FFC;
        }
    </style>


    <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a
                class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li><a href="/projects"><i class="icon-home2 position-left"></i>Сделки</a></li>

            <li class="active">Редактироване</li>
        </ul>
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

    </div>

    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="#">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Редактирование сделки</h5>
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                            <li><a data-action="reload"></a></li>
                            <li><a data-action="close"></a></li>
                        </ul>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="tabbable">

                        <div class="tab-content row">
                            <div class="col-md-2"><a href="#" class="btn btn-success" onclick="crates_script_modal();return false"> Создать скрипт</a></div>
  @foreach($phscripts as $phscript)
                                <div class="col-md-2"><a href="/stat/phscript/{{$phscript->id}}">{{$phscript->name}}</a></div>

@endforeach

                        </div>


                    </div>


                </div>
            </div>
    </div>
    </form>
    <div id="openmodal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Добавление скрипта</h4>
                </div>
                <!-- Основное содержимое модального окна -->
                <div class="modal-body" >
<input type="text" id="name_project" class="form-control" placeholder="Название скрипта" required>



                </div>
                <!-- Футер модального окна -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="crates_script()" >Создать</button>

                </div>
            </div>
        </div>
    </div>


@endsection
@section('skriptdop')

 <script>
     function crates_script(){
         $('#openmodal').modal('hide');
         $.ajax({
             type: "POST",
             url: '/stat/phscript_safe_create',
             data: "name="+$('#name_project').val(),
             success: function (html1) {

window.location.href='/stat/phscript/'+html1
             }
         })

     }
function crates_script_modal() {
    $('#openmodal').modal('show');
}




    </script>

@endsection