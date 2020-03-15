@extends('app')
@section('title')
    Контакты

@endsection
@section('content')

        <!-- Task manager table -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title">Сайты</h6>
                <div class="heading-elements">
                    <a href="/setting/sites/create" class="btn btn-success">Добавить</a>
                    <a href="/setting/sites/reloadwidget" class="btn btn-success">Обновить</a>
                  
                </div>
            </div>

            <table class="table tasks-list table-lg">
                <thead>
                <tr>

                    <th>Сайт</th>
                    <th>Код </th>

                    {{--<th><i class="glyphicon glyphicon-pencil"></i></th>--}}
                    <th><i class="glyphicon  glyphicon-trash" style="color: red"></i></th>


                </tr>
                </thead>
                <tbody>
               @foreach($stages as $client) <tr   id="del{{$client->id}}">
                    <td><a href="{{$client->protokol}}://{{$client->name}}" target="_blank">{{$client->name}}</a></td>
                    <td> <textarea class="form-control" style="height: 250px">{!! htmlspecialchars('
    <!--Neiros-->
     <script>
    var scr = {"scripts":[{"src" : "'.$_ENV['APP_URL'].'/api/widget_site/get/'.$client->hash.'",
     "async" : false}
	]};
	!function(t,n,r){
	"use strict";
	var c=function(t){
	if("[object Array]"!==Object.prototype.toString.call(t))return!1;
	for(var r=0;r<t.length;r++){
	var c=n.createElement("script"),e=t[r];
	c.src=e.src,c.async=e.async,n.body.appendChild(c)}return!0};
	t.addEventListener?t.addEventListener("load",function(){
	c(r.scripts);},!1):t.attachEvent?t.attachEvent("onload",function(){
	c(r.scripts)}):t.onload=function(){
	c(r.scripts)}}(window,document,scr);</script>
	<!--Neiros -->
	') !!}</textarea></td>




                {{--   <td><a href="#" data-id="{{$client->id}}" data-url="/sites/del/{{$client->id}}"  class="deletefrom" ><i class="glyphicon  glyphicon-pencil" style="color: red"></i></a>
                   </td>--}}
                   <td><a href="#" data-id="{{$client->id}}" data-url="/setting/sites/del/{{$client->id}}"  class="deletefromsite" ><i class="glyphicon  glyphicon-trash" style="color: red"></i></a>
                   </td>





               </tr>
@endforeach

























                </tbody>
            </table>
        </div>
        <!-- /task manager table -->

        <!-- /footer -->









@endsection
