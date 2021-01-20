<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Goal;
use App\Record;
use Illuminate\Support\Facades\DB;

class GoalsController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $goals = Goal::where('deleted',0)->where('created_by',$user_id)->paginate(3);
        return response()->json($goals);
    }

    public function view_detail($id)
    {
        $goal = Goal::where('deleted',0)->where('id',$id)->first();
        $records = Record::where('deleted',0)->where('goal_id',$id)->get();
        $data = ([
            'goals'=> $goal,
            'records'=> $records
        ]);
        return response()->json($data);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'money' => 'required|integer',
            'date' => 'date',
            'created_by' => 'required'
        ]);

        if ($validator->fails()) {
            // return response()->json($validator->errors()->toJson(), 400);
            $errors = $validator->errors(); 
            return response()->json([
                'status'=>'fail',
                'message'=>'Failed to post.',
                'errors'=> [
                    'title'=> $errors->first('title'),
                    'money'=> $errors->first('money'),
                    'date'=> $errors->first('date'),
                    'description'=> $errors->first('description'),
                ]
            ]);
        }

        $goal = new Goal;
        $goal->title = $request->title;
        $goal->money = $request->money;
        $goal->date = $request->date;
        $goal->description = $request->description;
        $goal->created_by = $request->created_by;
        $goal->save();

        if ($validator->passes()) {
            return response()->json([
                'status'=> 'success',
                'message'=> 'Posted successfully.'
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'money' => 'required|integer',
            'date' => 'date'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors(); 
            return response()->json([
                'status'=>'fail',
                'message'=>'Failed to update post.',
                'errors'=> [
                    'title'=> $errors->first('title'),
                    'money'=> $errors->first('money'),
                    'date'=> $errors->first('date'),
                    'description'=> $errors->first('description'),
                ]
            ]);
        }

        $post_id = $request->id;

        $goal = Goal::find($post_id);
        $goal->title = $request->title;
        $goal->money = $request->money;
        $goal->date = $request->date;
        $goal->description = $request->description;
        $goal->save();

        if ($validator->passes()) {
            return response()->json([
                'status'=> 'success',
                'message'=> 'Updated post successfully.'
            ]);
        }
    }
    

    public function delete($id)
    {
        $deleted = Goal::where('id',$id)
            ->update(['deleted'=>1]);
        if ($deleted) {
            return response()->json([
                'status'=>'success',
                'message'=>'Deleted successfully.'
            ]);
        }else {
            return response()->json([
                'status'=>'fail',
                'message'=>'Failted to delete.'
            ]);

        }
    }
}
