<div class="panel panel-default">
    <div class="panel-body">
        <ul class="nav nav-pills">
            <li role="presentation" class="@if(request()->route()->getName()=='wtickets.list') active @endif">
                <a href="{{route('wtickets.list')}}">Открытые Тикеты
                    <span class="badge">{{count($tickets)}}
                                             </span>
                </a>
            </li>
             <li role="presentation" class="@if(request()->route()->getName()=='wtickets.complete') active @endif">
                <a href="{{route('wtickets.complete')}}">Завершенные Тикеты
                    <span class="badge" style="background: blue">
                        {{count($tickets_compled)}}                    </span>
                </a>
            </li>
@if(auth()->user()->super_admin==1)
                <li role="presentation" >
                    <a href="{{route('wtickets.admin_panel.subject')}}">Настройки тем и пользователей

                    </a>
                </li>

   @endif
            {{-- <li role="presentation" class="">
                 <a href="https://cloud.neiros.ru/tickets-admin">Рабочая область</a>
             </li>

             <li role="presentation" class="dropdown ">

                 <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                     Настройки <span class="caret"></span>
                 </a>
                 <ul class="dropdown-menu">
                     <li role="presentation" class="">
                         <a href="https://cloud.neiros.ru/tickets-admin/status">Статусы</a>
                     </li>
                     <li role="presentation" class="">
                         <a href="https://cloud.neiros.ru/tickets-admin/priority">Приоритеты</a>
                     </li>
                     <li role="presentation" class="">
                         <a href="https://cloud.neiros.ru/tickets-admin/agent">Агенты</a>
                     </li>
                     <li role="presentation" class="">
                         <a href="https://cloud.neiros.ru/tickets-admin/category">Категории</a>
                     </li>
                     <li role="presentation" class="">
                         <a href="https://cloud.neiros.ru/tickets-admin/configuration">Конфигурация</a>
                     </li>
                     <li role="presentation" class="">
                         <a href="https://cloud.neiros.ru/tickets-admin/administrator">Администратор</a>
                     </li>
                 </ul>
             </li>--}}

        </ul>
    </div>
</div>