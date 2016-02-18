<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;
use App\Task;
use App\Statistic;
use App\ContactMessage;
use App\ContactMessagesCategory;
use App\Alert;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nowDateMinusWeek = date('Y-m-d', strtotime("-1 week")).' 00:00:00';
        $tasks = Task::where('deleted',false)
                ->where('created_at','>=',$nowDateMinusWeek)
                ->orderBy('created_at','desc')
                ->paginate(15);
         
        Task::resolveTasksDependencies($tasks);
        
        $statistics = Statistic::all();
        
        $statistics_array = array(
            'users' => $statistics[0]->value,
            'tasks' => $statistics[1]->value,
            'solutions' => $statistics[2]->value
            );
        
        return view('home/index',['tasks' => $tasks,
                                  'statistics' => $statistics_array]);
    }
    
    public function contact()
    {
        $contact_messages_categories = ContactMessagesCategory::all();
        return view('home/contact',['contact_messages_categories' => $contact_messages_categories]);
    }
    
    public function createContactMessage(Request $request){
        $this->validate($request, [
            'email' => 'email|max:40',
            'text' => 'required|max:100000|min:2',
            'category_id' => 'required|numeric',
        ]);
        
        $email = $request->input('email');
        $text = $request->input('text');
        $category_id = $request->input('category_id');
        
        $category = ContactMessagesCategory::where('id',$category_id)->first();
        
        if(!$category){
            abort(406);
        }
        
        $message = new ContactMessage;
        $message->email = !empty($email) ? $email : NULL;
        $message->text = $text;
        $message->category_id = $category_id;
        
        $pass = $message->save();
        
        if($pass){
            Alert::setSuccessAlert('Your message was send.');
        }
        else{
            Alert::setErrorAlert('Error '.__METHOD__);
        }
        
        return redirect()->action('HomeController@index');
    }
}
