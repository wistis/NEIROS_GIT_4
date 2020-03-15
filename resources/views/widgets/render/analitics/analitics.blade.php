<div class="row tab-pane " id="basic-tab1">

    <div class="col-md-12">
        <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>

            <input name="_token" type="hidden" value="{{ csrf_token() }}" />
            <input name="zss"  id="zss" type="hidden" value="" />
        </div>
        <div class="js-analytics" style="width: 100%;height: 450px"> </div>
        <div class="row" style="margin: 15px">

            <div class="checkbox-inline checkbox-switchery checkbox-right switchery-xs col-md-2">
                <label>
                    <input type="checkbox" class="switchery" checked  id="checkbox1" onclick="start_load_data()">Колбэк

                </label>
            </div>
            {{----}}
            <div class="checkbox-inline checkbox-switchery checkbox-right switchery-xs col-md-2">
                <label>
                    <input type="checkbox" class="switchery" checked   id="checkbox2"  onclick="start_load_data()">Колтрекинг

                </label>
            </div>


            <div class="checkbox-inline checkbox-switchery checkbox-right switchery-xs col-md-2">
                <label>
                    <input type="radio" class="switchery"   name="checkbox3"  id="checkbox3"  onclick="start_load_data()" value="0">По дням<br>
                    <input type="radio" class="switchery"    name="checkbox3"  id="checkbox4"  onclick="start_load_data()"  value="1">По неделям<br>
                    <input type="radio" class="switchery"    name="checkbox3"  id="checkbox5"  onclick="start_load_data()"  value="2">По месяцам<br>

                </label>
            </div>
        </div>
        <!-- Task manager table -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> </h6>
                <div class="heading-elements">
                    <button type="button" class="btn btn-link daterange-ranges heading-btn text-semibold">
                        <i class="icon-calendar3 position-left"></i> <span>{{$stat_start_date}}-{{$stat_end_date}}</span> <b class="caret"></b>
                    </button>

                </div>
            </div>
            @inject('stat','\App\Http\Controllers\CallStaticController')
            <table class="table tasks-list table-lg"  id="my_table">
                <tr><td style="font-weight: bold">Загрузка данных ... .</td></tr>
            </table>
        </div>
        <!-- /task manager table -->



    </div>
    {{--Дополнительные поля--}}

</div>
