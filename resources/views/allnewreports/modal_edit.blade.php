
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Конструктор</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body row">
                <div class="col-md-12 mb-20">
                    <input type="text" name="name" id="namedd" placeholder="Название" class="form-control" value="{{$report->name}}">
                    <input type="hidden" name="report_id" id="report_id" placeholder="Название" class="form-control" value="{{$report->id}}">
                </div>
                <div class="col-md-12 mb-20">Тип отчета
                    <select name="type">
                        <option value="line" @if($report->type=='line') selected @endif>График</option>
                        <option value="funnel"  @if($report->type=='funnel') selected @endif>Воронка</option>


                    </select>
                </div>


                <div class="col-md-6 table-bordered"><b>Группировки</b>
                    @foreach ($reports_gropings as $item)
                        <div><input type="checkbox" value="{{$item->id}}" name="grouping[]" @if(is_array( $report->grouping))@if(in_array($item->id, $report->grouping) ) checked @endif @endif>{{$item->name}}
                        </div>


                    @endforeach

                </div>
                <div class="col-md-6 table-bordered"><b>Показатели</b>

                    @foreach ($reports_resourse as $item)
                        <div><input type="checkbox" value="{{$item->code}}" name="resourses[]"  @if(in_array($item->code, $report->resourse) ) checked @endif>{{$item->name}}
                        </div>


                    @endforeach


                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="update_reports();return false">Сохранить
                </button>
                <button type="button" class="btn btn-danger" onclick="delete_reports({{$report->id}});return false">Удалить
                </button>
            </div>
