<?php

namespace App\Admin\Controllers;
use App\Models\WidgetName;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class WidgetNameController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Названия виджетов';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WidgetName);

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Название в сделках'))->editable();
        $grid->column('name_for_tarif', __('Название для тарифов'))->editable();


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
        $show = new Show(WidgetName::findOrFail($id));

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
        $form = new Form(new WidgetName);

        $form->display('id', __('ID'));
        $form->text('name', __('Название в сделках'));
        $form->text('name_for_tarif', __('Название для тарифов'));

        return $form;
    }
}
