<!-- Secondary sidebar -->
<div class="sidebar sidebar-secondary sidebar-detached" style="width: 400px;background: white;height: 100%;min-height: 1000px;color:#333;" >
    <div class="sidebar-content">
         
        <!-- Sidebar search -->
        <div class="sidebar-category">
            <div class="category-title">
                <h4 onclick="safetable()">Редактирование выбранного шага</h4>
                <a href="#"  onclick="safetable()" class="btn btn-success">Сохранить</a>
            </div>
<input type="hidden" id="element_id">
<input type="hidden" id="project_id" value="{{$ii}}">
            <div class="category-content">
                <form action="#">
                    <div class="has-feedback has-feedback-left">

                        <input type="checkbox" class="form-control" style="width: 20px" id="is_goal" > Является целью

                    </div>
                    <div class="has-feedback has-feedback-left">
                        <b>Заголовок</b>
                        <input type="search" class="form-control"  placeholder="Для краткости" id="element_title" onkeyup="set_title()">

                    </div>
                    <div class="has-feedback has-feedback-left">
                        <b>Текст</b>
                        <textarea  class="form-control"  id="element_text"  onkeyup="set_text()"></textarea>

                    </div>
                    <b>Ответы</b>
                    <div class="links">




                    </div>



                </form>
            </div>
        </div>

    </div>
</div>
<!-- /secondary sidebar -->