<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;
use App\User;
use App\ContactMessage;
use App\ContactMessagesCategory;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct() {
        if(!Auth::user()->admin){
            abort(403);
        }
    }
    
    public function messages(){
        
        $contact_messages = DB::table('contact_messages')
                ->join('contact_messages_categories','contact_messages.category_id','=','contact_messages_categories.id')
                ->select('contact_messages.*','contact_messages_categories.name AS category_name')
                ->orderBy('contact_messages.created_at','desc')
                ->paginate(15);
        
        return view('admin.messages',['messages' => $contact_messages]);
    }
    
    public function users(){
        
        $users = User::orderBy('created_at','desc')
                ->paginate(15);
        
        return view('admin.users',['users' => $users]);
    }
    
    public function logs(){
        return redirect()->route('\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    }
}
