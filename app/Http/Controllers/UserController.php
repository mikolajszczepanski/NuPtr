<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Lang;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Alert;
use App\User;
use App\Task;
use App\Solution;
use DB;
use Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function account(){
        $user = Auth::user();
        return view('user/account',['user' => $user]);
    }
    
    public function getChangeEmailView(){
        $user = Auth::user();
        return view('user/change/email',['user' => $user]);
    }
    
    public function changeEmail(Request $request){
        $this->validate($request, [
            'email' => 'required|email|max:255|unique:users|confirmed',
        ]);
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $user->email = $request->input('email');
        if($user->save()){
            Alert::setSuccessAlert(Lang::get('app.email_change'));
        }
        else{
            Alert::setErrorAlert(Lang::get('app.unknown_error'));
        }
        return redirect()->action('UserController@account');
    }
    
    public function getChangeNameView(){
        $user = Auth::user();
        return view('user/change/name',['user' => $user]);
    }
    
    public function changeName(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255|min:4',
        ]);
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $user->name = $request->input('name');
        if($user->save()){
            Alert::setSuccessAlert(Lang::get('app.name_change'));
        }
        else{
            Alert::setErrorAlert(Lang::get('app.unknown_error'));
        }
        return redirect()->action('UserController@account');
    }
    
    public function getChangePasswordView(){
        $user = Auth::user();
        return view('user/change/password',['user' => $user]);
    }
    
    public function changePassword(Request $request){
        
        Validator::extend('password_check', function ($attribute, $value, $parameters) {
            return Hash::check($value, Auth::user()->getAuthPassword());
        });
        
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|password_check',
            'password' => 'required|min:6|confirmed',
        ],['password_check' => Lang::get('app.incorrect_current_password')]);
        
        if ($validator->fails()) {
            return redirect()
                        ->action('UserController@getChangePasswordView')
                        ->withErrors($validator)
                        ->withInput();
        }

        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $user->password = Hash::make($request->input('password'));
        if($user->save()){
            Alert::setSuccessAlert(Lang::get('app.password_change'));
        }
        else{
            Alert::setErrorAlert(Lang::get('app.unknown_error'));
        }
        return redirect()->action('UserController@account');
    }
    
    public function tasks(){
        $user_id = Auth::user()->id;
        $tasks = Task::where('user_id',$user_id)
                ->where('deleted',false)
                ->orderBy('created_at','desc')
                ->paginate(15);
        Task::resolveTasksDependencies($tasks);
        return view('user/tasks',['tasks' => $tasks]);
    }
    
    public function solutions(){
        $user_id = Auth::user()->id;
        $solutions = DB::table('solutions')
                ->join('tasks','solutions.task_id','=','tasks.id')
                ->where('solutions.user_id',$user_id)
                ->where('solutions.deleted',false)
                ->where('tasks.deleted',false)
                ->orderBy('solutions.created_at','desc')
                ->select('solutions.*','tasks.name AS task_name')
                ->paginate(15);
        Solution::resolveSolutionsFiles($solutions);
        return view('user/solutions',['solutions' => $solutions]);
    }
}
