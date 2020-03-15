
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Конструктор</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body row">
                <div class="col-md-12 mb-20">
                    <input type="text" name="name" id="namedd" placeholder="Название" class="form-control">
                </div>
                <div class="col-md-12 mb-20">Тип отчета
                    <select name="type">
                        <option value="line">График</option>
                        <option value="funnel">Воронка</option>


                    </select>
                </div>


                <div class="col-md-6 table-bordered"><b>Группировки</b>
                    @foreach ($reports_gropings as $item)
                        <div><input type="checkbox" value="{{$item->id}}" name="grouping[]">{{$item->name}}
                        </div>


                    @endforeach

                </div>
                <div class="col-md-6 table-bordered"><b>Показатели</b>

                    @foreach ($reports_resourse as $item)
                        <div><input type="checkbox" value="{{$item->code}}" name="resourses[]">{{$item->name}}
                        </div>


                    @endforeach


                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="create_reports();return false">Создать
                </button>
            </div>
