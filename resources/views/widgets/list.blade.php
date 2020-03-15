@extends('app')
@section('title')
    {{$title}}

@endsection
@section('newjs')
    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switch.min.js"></script>
   

@endsection
@section('content')

    <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>

            <li class="active"> {{$title}} </li>
        </ul>
        <input name="_token" type="hidden" value="{{ csrf_token() }}" />


    </div>

        <!-- Task manager table -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> {{$title}}</h6>
                
            </div>

            <table class="table tasks-list table-lg">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Тип</th>
                    <th>Сайт</th>
                    <th>Статус</th>

                    <th><i class="icon-cog3"></i></th>




                </tr>
                </thead>
                <tbody>
               @foreach($stages as $client) <tr   id="del{{$client->id}}">
                    <td>{{$client->id}}</td>
                    <td>{{$client->name}}</td>
                    <td>
                    @if($client->tip==0) Промокод @endif
                    @if($client->tip==1) Колбэк @endif
                    @if($client->tip==2) Колтрекинг @endif


                    </td>
                    <td>{{$client->site}}</td>
                   <td>

                           <div class="checkbox checkbox-switchery">
                               <label>
                         <input type="checkbox" class="switchery"  @if($client->status==1) checked="checked" @endif onclick="statuswidget(this)" data-id="{{$client->id}}">

                               </label>
                           </div>


                   </td>

                   <td>
                       <a href="/widget/{{$client->id}}/edit" ><i class="icon-cog3"></i></a></td>





                </tr>
@endforeach

























                </tbody>
            </table>
        </div>
        <!-- /task manager table -->

        <!-- /footer -->









@endsection
@section('skriptdop')
  <script>  function statuswidget(id) {
          element=$(id).data('id');
          datatosend = {
              _token: $('[name=_token]').val(),
              element: element,



          }

          $.ajax({
              type: "POST",
              url: '/widget/status',
              data: datatosend,
              success: function (html1) {


                      $.jGrowl('Изменения успешно сохранены', {
                          header: 'Успешно!',
                          theme: 'bg-success'
                      });

              }
          })


          return false;


      }



  </script>

@endsection
