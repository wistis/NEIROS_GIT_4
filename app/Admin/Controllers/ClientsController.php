<?php

namespace App\Admin\Controllers;
use App\Models\Tarifs;
use App\Models\WidgetName;
use App\User;
use App\UsersCompany;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ClientsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Клиенты';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UsersCompany());

$grid->column('id','CID');
$grid->column('name','Имя')->display(function ($use) {
    $text='';
  if($use==''){

    $admin = $this->getadmin();
    if ($admin) {

        $text = $admin->name;
    }

  }else{
      $text = $use;
  }
    return $text;

});
$grid->column('getadmin','Админ ')->display(function () {
    $text='';
    $admin = $this->getadmin();
    if ($admin) {

    $text = $admin->email . '<br>' . $admin->phone;
    if ($admin->sms_code > 0) {
        $text .= '<br>Код:' . $admin->sms_code;
    } else {
        $text .= '<br><i class="fa fa-check"></i>';
    }
}else{
        return '<span style="color: red">Без админа</span>';
    }
    return $text;

});

        $grid->column('qlq','Войти под пользователем')->display(function (){
          return '<a href="/setting/loginas/'.$this->id.'">Войти под пользователем</a>';

        });
        $grid->column('ballans','Баланс') ;
        $grid->column('tariff_id','Тариф')->display(function ($use){

            $tarif=Tarifs::find($use);
            if($tarif){
                return $tarif->name;
            }
            $tarif=Tarifs::onlyTrashed()->find($use);
            if($tarif){
                return 'Удаленный -'.$tarif->name;
            }


        }) ;
        $grid->column('is_active','Активный')->display(function ($use) {

                if ($use==1) {

                  return 'Да';
                }


        });
        $grid->column('test_period','Тестовый период')->display(function ($use) {

            if ($use==1) {
$new_date=date('d.m.Y',strtotime('+2 week',strtotime($this->created_at)));
                return 'до '.$new_date;
            }


        });
       /* <td></td>*/
        $grid->column('created_at','Регистрация')->display(function ($use) {

                return date('d.m.Y',strtotime($this->created_at));



        });

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
        $show = new Show(UsersCompany::findOrFail($id));

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


        $form = new Form(new UsersCompany());

        $form->tab('Основное',function ($form){
$form->text('name','Название');
$form->text('ballans','Баланс');
$form->select('tariff_id','Тариф')->options(Tarifs::pluck('name','id'));
            $form->switch('is_active','Активный акаунт')->options([
                0=>'Нет',
                1=>'Да',
            ]);
            $form->switch('test_period
','Включен тестовый период')->options([
                0=>'Нет',
                1=>'Да',
            ]);

            $form->display('ballans','Баланс');
        });








        return $form;
    }
}
