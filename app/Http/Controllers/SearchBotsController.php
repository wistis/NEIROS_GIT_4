<?php

namespace App\Http\Controllers;
use App\Models\SearchBot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class SearchBotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {

$datas=SearchBot::orderby('id','desc')->paginate(100);

      return view('admin.servies.searchbot.index',compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
           return view('admin.servies.searchbot.add' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


 if(strlen($request->name)<3){return redirect('/setting/bots');
 }

SearchBot::Create($request->all());
return redirect('/setting/bots');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $f=SearchBot::find($id);
       $f->delete();
       return redirect('/setting/bots');
    }
     public function delet($id)
        {
           $f=SearchBot::find($id);
           $f->delete();
           return redirect('/setting/bots');
        }
}
