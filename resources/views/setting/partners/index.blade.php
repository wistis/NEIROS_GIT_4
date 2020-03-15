@extends('app')
@section('title')
    Дополнительные поля

@endsection
@section('content')
    <div class="row">
        <div class="page-title col-md-6" style="padding: 10px">
            <h1>Партнерская программа</h1>

        </div>
        <div class="col-md-6"></div>


    </div>

    <!-- Task manager table -->
    <div class="panel panel-white" style="padding: 15px">


        <div class="row">
            <div class="col-md-3">Ваша партнерская ссылка</div>
            <div class="col-md-9"><input type="text" value="https://neiros.ru/?ref={{auth()->user()->id}}"
                                         class="form-control"></div>
            <div class="row">
                <div class="col-md-6">
                    <h4>Клиентская программа</h4>
                    <div class="col-md-12">Привлекайте клиентов, и получайте начисление за каждую оплату</div>
                    <table class="table table-bordered">
                        <tr>
                            <td>Количество регистраций</td>
                            <td>{{count($partners )}}</td>


                        </tr>
                        <tr>
                            <td>Количество активных клиентов</td>
                            <td>{{count($partners->where('is_active',1))}}</td>


                        </tr>
                        <tr>
                            <td>Процент начислени</td>
                            <td>
                                @if(count($partners->where('is_active',1))<3)
                                    20%
                                @elseif((count($partners->where('is_active',1))>=3)&&(count($partners->where('is_active',1))<5))

                                    30%
                                @elseif(count($partners->where('is_active',1))>=5)
                                    35%
                                @else
                                    0%

                                @endif
                            </td>


                        </tr>
                        <tr>
                            <td>Начисления</td>
                            <td>{{$summ}}</td>


                        </tr>
                    </table>

                </div>
            </div>
        </div>


        <!-- /task manager table -->

        <!-- /footer -->









@endsection
