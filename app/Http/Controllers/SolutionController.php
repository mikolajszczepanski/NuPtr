<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Lang;
use DB;
use Auth;
use Log;
use Cache;
use App;
use App\Category;
use App\Statistic;
use App\Solution;
use App\Task;
use App\SolutionFile;
use App\Alert;

class SolutionController extends Controller
{
    public function getCreateView($id = null){
        
        return view('solution/create',['id' => $id,
                                        'solution' => null]);
    }
    
    public function getEditView($solution_id = null){
        $solution = null;
        if(!empty($solution_id)&&  is_numeric($solution_id)){
            $solution = Solution::where('id', $solution_id)
                    ->where('deleted',false)
                    ->where('user_id',Auth::user()->id)
                    ->first();
        }
        if(!$solution){
            abort(404);
        }
        

        $solution->files = SolutionFile::where('deleted',false)
                           ->where('solution_id',$solution_id)
                           ->where('user_id',Auth::user()->id)
                           ->get();
        
        return view('solution/create',['id' => $solution->task_id,
                                       'solution' => $solution]);
    }
    
    public function createOrEdit(Request $request){
        
        $this->validate($request, [
            'task_id' => 'required|numeric',
            'files' => 'required|array',
            'files.*.name' => 'required|min:2|max:60',
            'files.*.data' => 'required|min:2|max:1000000',
        ]);
        
        $task_id = $request->input('task_id');
        $user_id = $request->user()->id;
        $filesArray = $request->input('files');
        
        $task = Task::where('id',$task_id)->first();
        if(!$task){
            abort(406);
        }
        $solution = null;
        $solution_id = $request->input('solution_id');
        if(!empty($solution_id) && is_numeric($solution_id)){
            $solution = Solution::where('id',$solution_id)
                    ->where('user_id',$request->user()->id)
                    ->where('deleted',false)
                    ->first();
            if(!$solution){
                abort(406);
            }
            DB::table('solution_files')
                    ->where('solution_id',$solution_id)
                    ->where('user_id',$request->user()->id)
                    ->update(array('deleted' => true));
            
        }
        else{
            $solution_id = null;
            $solution = new Solution();
            Statistic::AddSolution();
        }
  
        $solution->user_id = $user_id;
        $solution->task_id = $task_id;
        
        $pass = $solution->save();
        $this->clearCache($solution);
        
        if(is_array($filesArray)){
            
            foreach($filesArray as $file){

                $solutionFile = new SolutionFile;

                $solutionFile->name = $file['name'];
                $solutionFile->data = $file['data'];
                $solutionFile->user_id = $request->user()->id;
                $solutionFile->solution_id = $solution->id;

                if(!$solutionFile->save()){
                    $pass = false;
                }
            }
            
        }
        
        if($pass){
            Alert::setSuccessAlert(Lang::get('app.solution_save'));
        }
        else{
            Log::alert(__METHOD__.'('.__FILE__.')', array(
                                  'solution_id' => $solution->id,
                                  'user_id' => Auth::user()->id,
            ));
            
            Alert::setErrorAlert(Lang::get('app.unknown_error'));
        }
        
            
        return redirect()->action('HomeController@index');
        
    }
    
    
    public function viewSolutionFile($id = null){
        
        $solutionFile = SolutionFile::where('id',$id)
                        ->where('deleted',false)
                        ->first();
        
        if(!$solutionFile){
            abort(404);
        }
        
        $solution = Solution::where('id',$solutionFile->solution_id)
                ->first();
        
        if(!$solution){
            abort(404);
        }
        
        $task = Task::where('id',$solution->task_id)
                ->first();
        
        if(!$task){
            abort(404);
        }
        
        $category = Category::where('id',$task->category_id)
                ->first();
        
        
        if(!$category){
            abort(500);
        }
        
        return view('solution/file',['solutionFile' => $solutionFile,
                                     'solution' => $solution,
                                     'task' => $task,
                                     'alias' => $category->alias,
                                     'script' => $category->script]);
        
    }
    
     public function getDeleteView($solution_id = null){
        
        if(empty($solution_id) || !is_numeric($solution_id)){
            abort(406);
        }
        
        $solution = Solution::where('id',$solution_id)
                ->where('deleted',false)
                ->where('user_id',Auth::user()->id)
                ->first();
        
        if(!$solution){
            abort(404);
        }
            
        return view('solution/delete',['solution' => $solution]);
    }
    
    public function delete(Request $request){
        $this->validate($request, [
            'solution_id' => 'required|numeric',
        ]);
        $solution_id = $request->input('solution_id');
        $solution = Solution::where('id',$solution_id)
                ->where('deleted',false)
                ->where('user_id',Auth::user()->id)
                ->first();
        
        if(!$solution){
            abort(404);
        }
        
        $solution->deleted = true;
        
        $pass = $solution->save();
        $this->clearCache($solution);
        
        if($pass){
            Alert::setSuccessAlert(Lang::get('app.deleted_solution'));
        }
        else{
            
            Log::alert(__METHOD__.'('.__FILE__.')', array(
                                  'solution_id' => $solution->id,
                                  'user_id' => Auth::user()->id,
            ));
            
            Alert::setErrorAlert(Lang::get('app.unknown_error'));
        }
        
        Statistic::SubSolution();    
        return redirect()->action('UserController@solutions');
        
    }
    
    
    private function clearCache($solution){
        $cache_name = 'App\Task::resolveTaskDependencies_task_id='.$solution->task_id;
        Cache::forget($cache_name);
        if(App::environment('local')) {
            Log::debug('Clear: '.$cache_name);
        }
        
        $cache_name = 'App\Solution::getTaskSolutionsDependencies_task_id='.$solution->task_id;
        Cache::forget($cache_name);
        if(App::environment('local')) {
            Log::debug('Clear: '.$cache_name);
        }
        
        $cache_name = 'App\Solution::resolveSolutionFiles_solution_id='.$solution->id;
        Cache::forget($cache_name);
        if(App::environment('local')) {
            Log::debug('Clear: '.$cache_name);
        }
    }
}
