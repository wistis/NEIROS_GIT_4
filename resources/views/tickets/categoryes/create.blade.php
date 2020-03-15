@extends('app')
@section('title')
 Тех поддержка

@endsection
@section('content')
    <div class="content" style="margin-top: 50px !important;">
@include('tickets.menu')



        <div class="panel panel-default">

            <div class="panel-heading">
                <h2>Темы обращений
                    <a href="{{route('wtickets.admin_panel.subject')}}" class="btn btn-primary pull-right">Все темы</a>
                </h2>
            </div>

            <div class="panel-body">
           <form method="post" action="">

               <div class="form-group">
                   <label class="col-lg-3 control-label">Название:</label>
                   <div class="col-lg-9">
                       <input type="text" class="form-control" name="name" id="name"   required>
                   </div>
               </div>
               <div class="form-group">
                   <label class="col-lg-3 control-label">Ответственные:</label>
                   <div class="col-lg-9">
                       <select name="agents[]" multiple class="form-control">
                           <option></option>
                           @foreach($users as $user)
                               <option  value="{{$user->id}}">{{$user->name}}</option>

                           @endforeach

                       </select>
                   </div>
               </div>
               <div class="form-group">

                   <div class="col-lg-9">
                       <button type="submit">Сохраниеть</button>
                   </div>
               </div>
           </form>









        <!-- Footer -->
        <div class="footer text-muted">

        </div>
        <!-- /footer -->

    </div>


@endsection
