<?php

namespace App\Admin\Controllers;
use App\Models\Tarifs;
use App\Models\WidgetName;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TrifsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Тарифы';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Tarifs());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Название '))->editable();

        $grid->column('month', __('Стоимость '))->editable();

        $grid->column('for_all', __('Тариф для всех'))->switch([0=>'Нет',1=>'Да']) ;
        $grid->column('satatus', __('Статус проекта'))->switch([0=>'Нет',1=>'Да']) ;

        $grid->column('projects', __('Проекты мин '))->editable();
        $grid->column('project_max', __('Проекты max  '))->editable();
        $grid->column('traffic', __('Траффик мин '))->editable();
        $grid->column('traffic_max', __('Траффик max  '))->editable();
        $grid->column('sort', __('Сотрировка  '))->editable();


/* `tarifs`(`id`, `name`, `month`, `year`, `moduls`, `phone`, `minuta`, `created_at`, `updated_at`, `deleted_at`, `for_all`, `satatus`)*/

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Tarifs::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Tarifs);

        $form->tab('Основное',function ($form){
            $form->display('id', __('ID'));
            $form->text('name', __('Название '));

            $form->text('short_name', __('Название '))->default('Для тех кто еще думает и хочет попробовать')->value('Для тех кто еще думает и хочет попробовать');
            $form->textarea('text', __('Описание HTML '))->default(' <ul>В пакет входит:
                <li>Аналитика</li>
                <li>Ловец лидов</li>
                <li>Аналитика</li>
                <li>Ловец лидов</li>
                <li>Аналитика</li>
                <li>Ловец лидов</li>
                <li>Аналитика</li>
                <li>Ловец лидов</li>
            </ul>')->value(' <ul>В пакет входит:
                <li>Аналитика</li>
                <li>Ловец лидов</li>
                <li>Аналитика</li>
                <li>Ловец лидов</li>
                <li>Аналитика</li>
                <li>Ловец лидов</li>
                <li>Аналитика</li>
                <li>Ловец лидов</li>
            </ul>');;
$form->text('sort','Сортировка');


        });
        $form->tab('Лимиты',function ($form){
            $form->number('month', __('Базовая цена'))->help('Цена в месяц');
            $form->number('phone', __('Стоимость аренды номера в месяц')) ;
            $form->text('minuta', __('Стоимость минуты разговора')) ;
            $form->number('traffic', __('Траффик')) ;
            $form->number('traffic_max', __('Траффик max')) ;
            $form->number('projects', __('Кол-во проектов')) ;
            $form->number('project_max', __('Кол-во проектов max')) ;
            $form->switch('for_all', __('Тариф для всех'))->options([0=>'Нет',1=>'Да']) ;
            $form->switch('satatus', __('Статус проекта'))->options([0=>'Нет',1=>'Да']) ;


        });
        $form->tab('Скидки',function ($form){
            $form->number('montsh3', __('Скидка 3месяца,%'))->help('К примеру: 12');
            $form->number('month6', __('Скидка 6 месяцев,%'))->help('К примеру: 15');
            $form->number('year', __('Скидка 1год ,%'))->help('К примеру: 15');
            $form->number('year2', __('Скидка 2года ,%'))->help('К примеру: 25');

        });

        $form->tab('Модули',function ($form){
            $form->checkbox('widgets','Модули')->options(WidgetName::pluck('name','id'));
        });





        return $form;
    }
}
