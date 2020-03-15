<div class="timeline-row">


    <div class="panel panel-flat timeline-content">
        <div class="panel-heading">
            <h6 class="panel-title">Чата с <span id="name_client"></span></h6>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-circle-down2"></i>
                        </a>

                       {{-- <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="#"><i class="icon-user-lock"></i> Hide user posts</a></li>
                            <li><a href="#"><i class="icon-user-block"></i> Block user</a></li>
                            <li><a href="#"><i class="icon-user-minus"></i> Unfollow user</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="icon-embed"></i> Embed post</a></li>
                            <li><a href="#"><i class="icon-blocked"></i> Report this post</a></li>
                        </ul>--}}
                    </li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <ul class="media-list chat-list content-group">
                {{--<li class="media date-step">
                    <span>Today</span>
                </li>--}}









            </ul>

            <textarea name="enter-message" class="form-control content-group enter-message" rows="3" cols="1" placeholder="Введите сообщение..." style="display: none"></textarea>

            <div class="row">
                <div class="col-xs-6">
                    {{--<ul class="icons-list icons-list-extended mt-10">
                        <li><a href="#" data-popup="tooltip" title="Send photo" data-container="body"><i class="icon-file-picture"></i></a></li>
                        <li><a href="#" data-popup="tooltip" title="Send video" data-container="body"><i class="icon-file-video"></i></a></li>
                        <li><a href="#" data-popup="tooltip" title="Send file" data-container="body"><i class="icon-file-plus"></i></a></li>
                    </ul>--}}
                </div>

                <div class="col-xs-6 text-right">
                    <button type="button" class="btn bg-teal-400 btn-labeled btn-labeled-right btn-sendmess" style="display: none" onclick="sendmess()"><b><i class="icon-circle-right2"  ></i></b> Отправить</button>
                </div>
            </div>
        </div>
    </div>
</div>