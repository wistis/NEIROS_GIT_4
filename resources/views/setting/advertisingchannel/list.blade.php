         <form class="form-horizontal" action="" method="post">
             <input name="_token" type="hidden" value="{{ csrf_token() }}" />
             <input type="hidden" class="form-control" name="form_action"
                    value="add_adversinchannael">
  
                                 <div class="form-group col-sm-6">
                                     <label class="col-lg-11 control-label">Название:</label>
                                     <div class="col-lg-11">
                                         <input style=" width:100%;" type="text" class="form-control" name="name" id="name"   required>
                                     </div>
                                 </div>

                     <div class="col-sm-6">

                                     <button  style="
    margin-top: 25px;
" type="button" class="btn btn-primary add_adversinchannael ">Добавить</button>
                         </div> 

         
         </form>


 <table class="table tasks-list table-lg">
                <thead>
                <tr>

                    <th>Название</th>
                    <th>Метка</th>
                    <th><i class="glyphicon  glyphicon-trash" style="color: red;position: relative;"></i></th>
                </tr>
                </thead>
                <tbody id="add_adversinchannael_td">
               @foreach($stages as $client)
                   <tr   id="del{{$client->id}}">
                    
                    <td>{{$client->name}}</td>
                    <td>neiros={{$client->code}}</td>
                       <td><a href="#" data-id="{{$client->id}}"  data-id="{{$client->id}}"  class="delet_chenel mkmkk" ><i class="glyphicon  glyphicon-trash" style="color: red;position: relative;"></i></a>
                       </td>

                </tr>
@endforeach

                </tbody>
            </table>









