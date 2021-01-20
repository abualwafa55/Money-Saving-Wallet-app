<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Goal;
use App\Record;
use Illuminate\Support\Facades\DB;


class RecordsController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $goals = Record::leftJoin('goals','records.goal_id','=','goals.id')
            ->select('records.*','goals.title as goal_title','goals.date as goal_date')
            ->where('records.deleted',0)->where('goals.created_by',$user_id)->paginate(3);
        return response()->json($goals);
    }

    public function view_detail($id)
    {
        $goals = Record::leftJoin('goals','records.goal_id','=','goals.id')
            ->select('records.*','goals.id as goal_id','goals.title as goal_title','goals.date as goal_date','goals.date as goal_date')
            ->where('records.deleted',0)
            ->where('records.id',$id)
            ->first();
        $data = ([
            'records'=> $goals
        ]);
        return response()->json($data);
    }

    public function get_goals_category(Request $request)
    {
        $user_id = $request->user_id;
        $goals_category = Goal::select('goals.title as category_name','goals.id as category_id')
            ->where('goals.deleted',0)->where('goals.created_by',$user_id)->get();
        return response()->json($goals_category);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string',
            'money' => 'required|integer',
            'date' => 'date',
            'goal_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors(); 
            return response()->json([
                'status'=>'fail',
                'message'=>'Failed to post.',
                'errors'=> [
                    'title'=> $errors->first('title'),
                    'money'=> $errors->first('money'),
                    'date'=> $errors->first('date'),
                    'goal_id'=> $errors->first('goal_id'),
                    'description'=> $errors->first('description'),
                ]
            ]);
        }

        $record = new Record;
        $record->title = $request->title;
        $record->money = $request->money;
        $record->date = $request->date;
        $record->goal_id = $request->goal_id;
        $record->description = $request->description;
        $record->save();

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
            'date' => 'date',
            'goal_id' => 'required|integer',
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
                    'goal_id'=> $errors->first('goal_id'),
                    'description'=> $errors->first('description'),
                ]
            ]);
        }

        $post_id = $request->id;

        $record = Record::find($post_id);
        $record->title = $request->title;
        $record->money = $request->money;
        $record->date = $request->date;
        $record->goal_id = $request->goal_id;
        $record->description = $request->description;
        $record->save();

        if ($validator->passes()) {
            return response()->json([
                'status'=> 'success',
                'message'=> 'Updated post successfully.'
            ]);
        }
    }

    public function delete($id)
    {
        $deleted = Record::where('id',$id)
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
