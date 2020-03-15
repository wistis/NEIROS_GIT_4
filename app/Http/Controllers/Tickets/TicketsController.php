<?php

namespace App\Http\Controllers\Tickets;
use App\Admin_messages;
use App\Models\Tickets\Category;
use App\Models\Tickets\Comment;
use App\Models\Tickets\Ticket;
use App\Servies\SMTP;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketsController extends Controller
{
    public function subject_delete($id){
        Category::where('id',$id)->delete();
        \DB::table('ticketit_categories_users')->where('category_id',$id)->delete();
        return redirect()->route('wtickets.admin_panel.subject');
    }

    public function subject_edit($id){

        $subject=Category::find($id);
        if(request()->method()=='POST'){
            \DB::table('ticketit_categories_users')->where('category_id',$id)->delete();
            $categ=Category::find($id);
            $categ->name=request()->get('name');
            $categ->save();
            if(is_array(request()->get('agents'))){

                for($i=0;$i<count(request()->get('agents'));$i++){
                    $catag=\DB::table('ticketit_categories_users')->insert([
                        'category_id'=>$categ->id,
                        'user_id' =>  request()->get('agents')[$i]


                    ]);




                }


            }

            return redirect()->route('wtickets.admin_panel.subject');
        }

        $tickets=Ticket::active() ->orderby('id','desc')->orderby('agent_no_read','desc')->paginate(10);
        $tickets_compled=Ticket::complete() ->get();

        $users=User::where('super_admin',1)->get();
        return view('tickets.categoryes.edit',compact('tickets','tickets_compled','users','subject'));


    }

    public function subject
    (){
        $tickets=Ticket::active() ->orderby('id','desc')->orderby('agent_no_read','desc')->paginate(10);
        $tickets_compled=Ticket::complete() ->get();

        $categoryes=Category::get();

        return view('tickets.categoryes.index',compact('tickets','tickets_compled','categoryes'));
    }
    public function subject_create
    (){

        if(request()->method()=='POST'){

            $categ=New Category();
            $categ->name=request()->get('name');
          $categ->save();
          if(is_array(request()->get('agents'))){

              for($i=0;$i<count(request()->get('agents'));$i++){
                  $catag=\DB::table('ticketit_categories_users')->insert([
                      'category_id'=>$categ->id,
                      'user_id' =>  request()->get('agents')[$i]


                  ]);




              }


          }

return redirect()->route('wtickets.admin_panel.subject');
        }

        $tickets=Ticket::active() ->orderby('id','desc')->orderby('agent_no_read','desc')->paginate(10);
        $tickets_compled=Ticket::complete() ->get();

  $users=User::where('super_admin',1)->get();
        return view('tickets.categoryes.create',compact('tickets','tickets_compled','users'));
    }

    public function admin_panel($razdel=null){

        $tickets=Ticket::active() ->orderby('id','desc')->orderby('agent_no_read','desc')->paginate(10);
        $tickets_compled=Ticket::complete() ->get();


        if($razdel==null){



            $tickets=Ticket::active() ->orderby('id','desc')->orderby('agent_no_read','desc')->paginate(10);
            $tickets_compled=Ticket::complete() ->get();

            return view('tickets.admin',compact('tickets','tickets_compled'));






        }



    }

 public function  index(){

     $tickets=Ticket::active()->where('user_id',auth()->user()->id)->orderby('id','desc')->paginate(10);
     $tickets_compled=Ticket::complete()->where('user_id',auth()->user()->id)->get();
if(auth()->user()->super_admin==1){
    return redirect()->route('wtickets.admin_panel');
}
     return view('tickets.index',compact('tickets','tickets_compled'));


 }
 public function  index_complete(){
if(auth()->user()->super_admin==1){

    $tickets_compled=Ticket::active() ->orderby('id','desc')->paginate(10);
    $tickets=Ticket::complete()-> get();
}else{
    $tickets_compled=Ticket::active()->where('user_id',auth()->user()->id)->orderby('id','desc')->paginate(10);
    $tickets=Ticket::complete()->where('user_id',auth()->user()->id)->get();
}


     return view('tickets.index',compact('tickets','tickets_compled'));


 }
 public function create(){

     $tickets=Ticket::active()->where('user_id',auth()->user()->id)->paginate(10);
     $tickets_compled=Ticket::complete()->where('user_id',auth()->user()->id)->paginate(10);

     $categories=Category::get();





     return view('tickets.create',compact('tickets','tickets_compled','categories'));
 }

    public function view($id){

        $tickets=Ticket::active()->where('user_id',auth()->user()->id)->paginate(10);
        $tickets_compled=Ticket::complete()->where('user_id',auth()->user()->id)->paginate(10);




        $categories=Category::get();
$ticket=Ticket::where('user_id',auth()->user()->id)->find($id);
 if(auth()->user()->super_admin==1){
     $ticket=Ticket::find($id);
     $tickets=Ticket::active()->paginate(10);
     $tickets_compled=Ticket::complete()->paginate(10);


 }
        $ticket->user_no_read=0;
if($ticket->user_id==auth()->user()->id){
    $ticket->user_no_read=0;
}
        if($ticket->agent_id==auth()->user()->id){
            $ticket->agent_no_read=0;
        }
        $ticket->save();
if(!$ticket){
    return abort(404);
}
if(\request()->has('am')) {
  \DB::table('admin_messages_read')->where('id',\request()->get('am')) ->update(['status' => 1]);
}

        return view('tickets.view',compact('tickets','tickets_compled','categories','ticket'));
    }


 public function store(Request $request){

$agent_id=\DB::table('ticketit_categories_users')->where('category_id',$request->category_id)->first();

$ticket=new Ticket();
$ticket->subject=$request->subject;
$ticket->content=$request->get('content');
$ticket->priority_id=$request->priority_id;
$ticket->category_id=$request->category_id;
$ticket->status_id=1;
$ticket->agent_no_read=1;
$ticket->user_no_read=0;
$ticket->user_id=auth()->user()->id;
$ticket->agent_id=$agent_id->user_id;
$ticket->save();
$ticket->number=date('Ymdhis').$ticket->id;
  $ticket->save();

$data['text']=view('tickets.emails.start',compact('ticket'))->render();
$data['subject']='[Ticket#'.$ticket->number.'] '.$ticket->subject;
$data['mail']='support@neiros.ru';



     try {


         $mail = new SMTP();
         $mail->to($data['mail']);
         $mail->from('support@neiros.ru', 'Support Neiros');
         $mail->subject($data['subject']);
         $mail->body(view('email',$data)->render());
         $result = $mail->send();


     } catch (\Exception $e) {

     }


return redirect()->route('wtickets.list');


 }



 public function add_comment(Request $request){
     $comment=new Comment();
     $comment->content=$request->get('content');
     $comment->user_id=auth()->user()->id;
     $comment->ticket_id=$request->ticket_id;

     $comment->save();
$ticket=Ticket::find($request->ticket_id);
if(($ticket->status_id==0)&&(auth()->user()->id!=$ticket->user_id)){

    $ticket->status_id=1;


}
if(auth()->user()->id!=$ticket->user_id){

    $datatoinsert[0]['user_id'] = $ticket->user_id;
    $ticket->agent_no_read=0;
    $ticket->user_no_read=1;
    $email=$ticket->user->email;;
}else{
    $datatoinsert[0]['user_id'] = $ticket->agent_id;
    $email='upport@neiros.ru';
    $ticket->agent_no_read=1;
    $ticket->user_no_read=0;
}

     $adm_mess=new Admin_messages();
     $id = Admin_messages::insertGetId(
         [
             'tema' => 'Поступило сообщение',
             'message' => 'Поступило сообщение по обращению  '.$ticket->id,
             'created_at' =>  date('Y-m-d H:i:s'),
             'updated_at' =>  date('Y-m-d H:i:s'),
             'tickets'=>$ticket->id

         ]);


     $datatoinsert[0]['mess_id'] = $id;
     $datatoinsert[0]['user_id'] = $ticket->user_id;
     $datatoinsert[0]['status'] = 0;
     $datatoinsert[0]['created_at'] = date('Y-m-d H:i:s');
     $datatoinsert[0]['updated_at'] = date('Y-m-d H:i:s');

     \DB::table('admin_messages_read')->insert($datatoinsert);

     $ticket->save();
$message=$request->content;
     $data['text']=view('tickets.emails.comment',compact('ticket','message'))->render();
     $data['subject']='[Ticket#'.$ticket->number.'] '.$ticket->subject;
     $data['mail']=$email;

     try {


         $mail = new SMTP();
         $mail->to($data['mail']);
         $mail->from('support@neiros.ru', 'Support Neiros');
         $mail->subject($data['subject']);
         $mail->body(view('email',$data)->render());
         $result = $mail->send();


     } catch (\Exception $e) {

     }
return redirect()->route('wtickets.view',$ticket->id);
 }

 public function completed($id){
     $tick=Ticket::find($id);
     $tick->completed_at=date('Y-m-d H:i:s');
     $tick->save();

     $data['text']='Здравствуйте!<br>
Ваше обращение переведено в статус выполнено.<br>
С уважением,<br>
Служба технической поддержки Neiros<br>
https://neiros.ru/support/';
     $data['subject']='[Ticket#'.$tick->number.'] '.$tick->subject;
     $data['mail']=$tick->user->email;

     try {
         \Mail::send(['html' => 'email'], $data, function ($message) use ($data) {


             $message->to($data['mail'], '');

             $message->subject($data['subject']);
         });
     } catch (\Exception $e) {

     }


     return redirect()->route('wtickets.list');
 }
    public function reopen($id){
        $tick=Ticket::find($id);
        $tick->completed_at=NULL;
        $tick->save();

        return redirect()->route('wtickets.list');
    }
    public function delete($id){
         Ticket::where('id',$id)->delete();

        return redirect()->route('wtickets.list');
    }
}
