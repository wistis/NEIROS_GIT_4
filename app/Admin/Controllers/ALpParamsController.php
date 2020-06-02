<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Servies\ALpParam;
class ALpParamsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'UTM';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ALpParam());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('utm', __('utm'));


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
        $show = new Show(ALpParam::findOrFail($id));

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
        $form = new Form(new ALpParam());

        $form->display('id', __('ID'));
        $form->text('utm', __('utm'));
        $form->text('url', __('Адрес файла'));
        $form->text('mess', __('Сообщение'));
        $form->text('url_name', __('Название файла'));
        $form->text('massa', __('Размер файла'));
        $form->text('vk_group_id', __('Группа вконтакте'));
        $form->text('viber', __('Ссылка вайбер'))->help('');
        $form->text('fb', __('Ссылка фейсбук'))->help('');
        $form->text('telegramm', __('Ссылка телега'))->help('');
        $form->text('template', __('Шаблон'))->help('В папке lppage ');
        $form->textarea('text', __('Текст, html')) ;
/*`id`, `utm`, `url`, `mess`, `url_name`, `massa`, `created_at`, `updated_at`, `vk_group_id`, `viber`, `fb`, `telegramm`, `text`, `template*/
        return $form;
    }
}
