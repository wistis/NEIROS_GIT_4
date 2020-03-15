
        <div class="panel-heading">
            <h6 class="panel-title">Счета на оплату</h6>
            <div class="heading-elements">
                <a href="/setting/checkcompanys/create" class="btn btn-success">Создать</a>


            </div>
        </div>

        <table class="table tasks-list table-lg">
            <thead>
            <tr>

                <th>#</th>
                <th>Компания</th>
                <th>Сумма </th>

                <th>Дата</th>
                <th>Статус</th>
                <th>Действия</th>
               @if($admin==1) <th>Оплатить</th>@endif



            </tr>
            </thead>
            <tbody>
            @foreach($companys as $company)
                <tr>
                    <td>{{$company->id}}</td>
                <td>@if(isset($firms[$company->company_id])) {{$firms[$company->company_id]->short_name}} @endif</td>
                <td>{{$company->summ}}</td>
                <td>{{date('H:i d-m-Y',strtotime($company->created_at))}}</td>
                <td>
                    @if($company->status==0)  Новый @endif
                    @if($company->status==1)  Оплачен @endif
                    @if($company->status==2)  Отменен @endif

                </td>
                    <td><a href="/setting/checkcompanys/getschet/{{$company->id}}">Печать</a></td>

                    @if($admin==1) <td>@if($company->status==0) <button class="btn btn-success" onclick="payschet({{$company->id}})">Оплатить</button>  @endif</td>@endif





            </tr>
            @endforeach

























            </tbody>
        </table>

    <!-- /task manager table -->

    <!-- /footer -->


<script>
    function payschet(id) {

        $.ajax({
            type: "POST",
            url: '/ajax/payschet',
            data: "id="+id,
            success: function (html1) {
$res=JSON.parse(html1);
if($res['status']==1){
    m='Успешно';
}else {
    m='Ошибка';


}
                $.jGrowl($res['message'], {
                    header: m,
                    theme: 'bg-'+$res['color']
                });

            }
        })




    }

</script>





