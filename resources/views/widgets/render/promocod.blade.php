<form class="form-horizontal" action="#" method="post">
    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
    <input name="widget_id" type="hidden"  id="widget_id" value="{{$widget->id}}" />
            <div class="panel panel-flat">


                <div class="panel-body">

                    <div class="tabbable">

                        <div class="tab-content">

                            <div class="row tab-pane active"   id="basic-tab1">
                                <h2 class="panel-title">Основное</h2>
                                <div class="col-md-6">
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Статус виджета:</label>
                                            <div class="col-lg-9">
                                                <div class="checkbox checkbox-switchery">
                                                    <label>
                                                        <input type="checkbox" class="switchery"  id="status" name="status" @if($widget->status==1) checked="checked" @endif  data-id="{{$widget->id}}">

                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Цвет текста:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control jscolor" name="color" id="color"  value="{{$thiswidget->color}}"  required>

                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Цвет фона:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control jscolor" name="background" id="background"  value="{{$thiswidget->background}}"  required>

                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Расположение по горизонтали:</label>
                                            <div class="col-md-9">
                                                <select id="position_x" name="position_x" class="form-control">
                                                    <option value="left" @if($thiswidget->position_x=='left') selected @endif >Слева</option>
                                                    <option value="right" @if($thiswidget->position_x=='right') selected @endif >Справа</option>

                                                </select>


                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Расположение по вертикали:</label>
                                            <div class="col-md-9">
                                                <select id="position_y" name="position_y" class="form-control">
                                                    <option value="top" @if($thiswidget->position_y=='top') selected @endif >Вверху</option>
                                                    <option value="bottom" @if($thiswidget->position_y=='bottom') selected @endif >Внизу</option>

                                                </select>


                                            </div>

                                        </div>










                                    </fieldset>
                                </div>
                                {{--Дополнительные поля--}}

                            </div>





                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary edit_widget">Сохранить<i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
        </form>







