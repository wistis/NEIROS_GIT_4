 <div class="row"> <div class="col-md-6">
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Статус виджета:</label>
                                            <div class="col-lg-9">
                                                <div class="checkbox checkbox-switchery">
                                                    <label>
                    {{--                                    <input type="checkbox" class="switchery"  id="status" name="status" @if($widget->status==1) checked="checked" @endif  data-id="{{$widget->id}}">--}}

                                                    </label>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">token:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="token" id="token"  value="{{$widget_vk->token}}"  required>
                                                <a href="/set_token_direct/{{$widget_vk->id}}">Получить токен
                                                </a>
                                            </div>

                                        </div>













                                    </fieldset>
                                </div>
                                {{--Дополнительные поля--}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Рекламные компании:</label>
                                        <div class="col-lg-9">
                                            @foreach($counters as $counter)

                                                <div><input type="checkbox"    name="radiocounter" @if($counter->status==1) checked="checked" @endif value="{{$counter->id}}"  > {{$counter->company}} ({{$counter->name}})</div>
                                            @endforeach

                                        </div>

                                    </div>



                                </div>

</div>

        @section('skriptdop')
            <script>
                $('.edit_widget').click(function () {
                    widget_id = $('#widget_id').val();
                    widget_promokod_id = $('#widget_promokod_id').val();
                    if($('#status').prop('checked')) {
                        status=1;
                    } else {
                        status=0;
                    }

                    var a=$('input[name="radiocounter"]:checked'); //выбираем все отмеченные checkbox
                    var out=[]; //выходной массив

                    for (var x=0; x<a.length;x++){ //перебераем все объекты
                        out.push(a[x].value); //добавляем значения в выходной массив
                    }

                    datatosend = {
                        widget_id: widget_id,
                        widget_promokod_id: widget_promokod_id,
                        status:status,

                        counter:out,



                        _token: $('[name=_token]').val(),



                    }



                    $.ajax({
                        type: "POST",
                        url: '/widget/safe',
                        data: datatosend,
                        success: function (html1) {
                            if(html1==1){
                                $.jGrowl('Изменения успешно сохранены', {
                                    header: 'Успешно!',
                                    theme: 'bg-success'
                                });

                            }else{
                                $.jGrowl('Чтото пошло не так', {
                                    header: 'Ошибка!',
                                    theme: 'bg-danger'
                                });
                            }


                        }
                    })


                    return false;
                });



            </script>
@endsection
