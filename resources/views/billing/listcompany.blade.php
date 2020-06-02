

        <div class="panel-heading">
            <h6 class="panel-title"Платежные профили</h6>
            <div class="heading-elements">
                <a href="/setting/paycompanys/create" class="btn btn-success">Добавить</a>


            </div>
        </div>

        <table class="table tasks-list table-lg">
            <thead>
            <tr>

                <th>Наименование</th>
                <th>ИНН </th>

                <th>Счет</th>
                <th><i class="glyphicon  glyphicon-trash" style="color: red"></i></th>
                <th><i class="glyphicon  glyphicon-trash" style="color: red"></i></th>


            </tr>
            </thead>
            <tbody>
            @foreach($companys as $company)
                <tr   id="del{{$company->id}}">
                <td>{{$company->short_name}}</td>
                <td>{{$company->inn}}</td>
                    <td><a href="/setting/checkcompanys/create?company_id={{$company->id}}">Выставить счет</a></td>




                <td><a href="/setting/paycompanys/{{$company->id}}/edit"     ><i class="glyphicon  glyphicon-pencil" style="color: red"></i></a>
                </td>
                <td><a href="#" data-id="{{$company->id}}" data-url="/setting/paycompanys/del/{{$company->id}}"  class="deletefrom" ><i class="glyphicon  glyphicon-trash" style="color: red"></i></a>
                </td>





            </tr>
            @endforeach

























            </tbody>
        </table>
