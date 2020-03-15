<div class="row">
                                <div class="col-md-6">
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Статус виджета:</label>
                                            <div class="col-lg-9">
                                                <div class="checkbox checkbox-switchery">
                                                    <label>
                                                       {{-- <input type="checkbox" class="switchery"  id="status" name="status" @if($widget->status==1) checked="checked" @endif  data-id="{{$widget->id}}">--}}

                                                    </label>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">token:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="token" id="token"  value="{{$widget_vk->token}}"  required>
<a href="/set_token/{{$widget_vk->id}}">Получить токен
</a>
                                            </div>

                                        </div>













                                    </fieldset>
                                </div>
                                {{--Дополнительные поля--}}
                               {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Счетчики метрики:</label>
                                        <div class="col-lg-9">
                                             @foreach($counters as $counter)

                                                <div><input type="radio"    name="radiocounter" @if($widget_vk->counter==$counter->counter) checked="checked" @endif value="{{$counter->counter}}"  > {{$counter->site}} ({{$counter->counter}})</div>
@endforeach

                                        </div>

                                    </div>



                                </div>--}}
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
                    var radiocounter = $('input[name="radiocounter"]:checked').val();
                    datatosend = {
                        widget_id: widget_id,
                        widget_promokod_id: widget_promokod_id,
                        status:status,

                        counter:radiocounter,



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
