<!-- HTML-код модального окна -->
<div id="add_ajax_task_modal_form" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Добавление задачи</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">

                    <input type="hidden" id="t_project_id" value="{{$project->id}}">




                            <div class="form-group">
                                <label class="col-lg-3 control-label">Тип:</label>
                                <div class="col-lg-9">
                                    <select data-placeholder="Выберите этап" class="form-control" name="t_todo_99" id="t_todo_99">

                                        @foreach($stages as $todo)

                                            <option value="{{$todo->id}}" @if($todo->id==1) selected @endif >{{$todo->name}}</option>

                                        @endforeach


                                    </select>
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="col-lg-3 control-label">Дата:</label>
                                <div class="col-lg-9">
                                    <input type="date" class="form-control" name="t_data_99" id="t_data_99"   required>
                                </div>
                            </div>




                            <div class="form-group">
                                <label class="col-lg-3 control-label">Ответственный:</label>
                                <div class="col-lg-9">
                                    <select data-placeholder="Выберите ответственного" class="form-control" name="t_user_99" id="t_user_99">

                                        @foreach($managers as $manager)

                                            <option value="{{$manager->id}}" @if($manager->id==$user->id) selected @endif >{{$manager->name}}</option>

                                        @endforeach


                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Статус:</label>
                                <div class="col-lg-9">
                                    <select  class="form-control" name="t_status_99" id="t_status_99">

                                        @foreach($statuss as $status)

                                            <option value="{{$status->id}}"   >{{$status->name}}</option>

                                        @endforeach


                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Описание задачи:</label>
                                <div class="col-lg-9">
<textarea name="t_comment_99" id="t_comment_99"  class="form-control">



</textarea>

                                </div>
                            </div>


            </div>
            <!-- Футер модального окна -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary add_ajax_task_modal_safe">Добавить задачу</button>
            </div>
        </div>
    </div>
</div>