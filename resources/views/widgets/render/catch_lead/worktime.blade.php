<?php /*?><div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-2">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-2"
           aria-expanded="false" aria-controls="collapse-2">
            <div class="number-accardion">2</div>
            <div class="h-1">Рабочее время</div>
            <div class="descr-text">основные настройки </div>
        </a>
    </div>
    <div id="collapse-2" class="panel-collapse collapse" role="tabpane2" aria-labelledby="heading-2">

    <div class="col-md-12">
        <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>

            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

        </div>


        <!-- Task manager table -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> </h6>

            </div>
<?
            $weekday[1]='Понедельник';
            $weekday[2]='Вторник';
            $weekday[3]='Среда';
            $weekday[4]='Четверг';
            $weekday[5]='Пятница';
            $weekday[6]='Суббота';
            $weekday[7]='Воскресенье';

            ?>
           <form name="formawork" name="formawork">
               <input type="hidden" name="form_action" value="formawork_2">
               <input type="hidden" name="widget" value="{{$widget->id}}">
               <input type="hidden" name="my_company_id" value="{{$widget->my_company_id}}">

               <table class="table tasks-list table-lg">
                <tbody   id="table_costs">

                <tr  >
                    <td>День</td>
                  <td>Рабочий день</td>

                  <td>Начало дня</td>
                  <td>Конец дня</td>


                </tr>
                @foreach($fields as $cost)

                    <tr id="cost{{$cost->id}}">

                        <td ><input type="hidden" name="id{{$cost->day}}" value="{{$cost->id}}" > {{$weekday[$cost->day]}}</td>
                        <td >
                            <input type="hidden" name="is_work{{$cost->day}}" value="0">
                            <input type="checkbox" value="1" name="is_work{{$cost->day}}" @if($cost->is_work==1) checked @endif> </td>
                        <td >
                            <select name="hour{{$cost->day}}">
                                @for($i=0;$i<=24;$i++)
 <option value="{{$i}}" @if($i==$cost->hour) selected @endif> {{$i}}</option>
                                 @endfor

                            </select>

                             </td>
                        <td > <select name="hour_end{{$cost->day}}">
                                @for($i=0;$i<=24;$i++)
                                    <option value="{{$i}}" @if($i==$cost->hour_end) selected @endif> {{$i}}</option>
                                @endfor

                            </select></td>




                    </tr>
                @endforeach</tbody>
               </table><button type="button" class="w_safebutton">Сохранить</button></form>
        </div>
        <!-- /task manager table -->



    </div>
    {{--Дополнительные поля--}}

</div>
</div>

<?php */?>