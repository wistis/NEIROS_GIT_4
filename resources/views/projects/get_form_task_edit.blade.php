<div class="panel panel-flat" id="t_display_{{$number}}">
    <input type="hidden" id="t_active_{{$number}}" value="1">
    <input type="hidden" id="t_id_{{$number}}" value="{{$id}}">
    <div class="panel-heading">
        <h6 class="panel-title">Задача {{$id}}</h6>
        <div class="heading-elements">
            <ul class="icons-list">

                <li><a  onclick="close_task({{$number}})" >X</a></li>
            </ul>
        </div>
    </div>

    <div class="panel-body"> <fieldset>
            <div class="form-group">
                <label class="col-lg-3 control-label">Тип:</label>
                <div class="col-lg-9">
                    <select data-placeholder="Выберите этап" class="form-control" name="t_todo_{{$number}}" id="t_todo_{{$number}}">

                        @foreach($todos as $todo1)

                            <option value="{{$todo1->id}}" @if($todo1->id==$todo) selected @endif >{{$todo1->name}}</option>

                        @endforeach


                    </select>
                </div>
            </div>



            <div class="form-group">
                <label class="col-lg-3 control-label">Дата:</label>
                <div class="col-lg-9">
    <input type="text" class="form-control" name="t_data_{{$number}}" id="t_data_{{$number}}"   value="{{$date}}">
                </div>
            </div>




            <div class="form-group">
                <label class="col-lg-3 control-label">Ответственный:</label>
                <div class="col-lg-9">
                    <select data-placeholder="Выберите ответственного" class="form-control" name="t_user_{{$number}}" id="t_user_{{$number}}">

                        @foreach($managers as $manager)

                            <option value="{{$manager->id}}" @if($manager->id==$user_id) selected @endif >{{$manager->name}}</option>

                        @endforeach


                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">Статус:</label>
                <div class="col-lg-9">
                    <select  class="form-control" name="t_status_{{$number}}" id="t_status_{{$number}}">

                        @foreach($statuss as $status1)

                            <option value="{{$status1->id}}"  @if($status1->id==$status) selected @endif    >{{$status1->name}}</option>

                        @endforeach


                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">Описание задачи:</label>
                <div class="col-lg-9">
<textarea name="t_comment_{{$number}}" id="t_comment_{{$number}}"  class="form-control">

{{$comment}}

</textarea>

                </div>
            </div>
        </fieldset>
    </div>
</div>