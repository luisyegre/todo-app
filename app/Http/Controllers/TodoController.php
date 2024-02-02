<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoStore;
use App\Models\Todo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function __construct() {

    }
    public function index()
    {
        $todos = Todo::where("user_id",Auth::user()->id)->get();
        return response()->json($todos);
    }

    public function show($id)
    {
        $todo = Todo::where("user_id",Auth::user()->id)->where('id',$id)->first();
        if ($todo === null) {
            return response()->json(["data" => $todo,"message"=>"Todo not found"],404);
        }
        return response()->json(["data" => $todo]);

    }

    public function store(TodoStore $request)
    {
        try {
            $todo = new Todo([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'user_id'=> Auth::user()->id
            ]);

            $todo->save();

            return response()->json(["message"=>"Todo created"],201);
        } catch(\Exception $e) {
            return response()->json(["message"=>"Something went wrong","error"=> $e->getMessage()],400);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $todo = Todo::where("user_id",Auth::user()->id)->where('id',$id)->first();
            if ($todo === null) {
                return response()->json(["data" => $todo,"message"=>"Todo not found"],404);
            }
            $todo->update($request->all());
            return response()->json(["message"=>"Todo updated"]);
        } catch(\Exception $e){
            return response()->json(["message"=>"Todo updated","error"=>$e->getMessage()],400);
        }
    }

    public function destroy($id)
    {
        try {
            $todo = Todo::where("user_id",Auth::user()->id)->where('id',$id)->first();
            if ($todo === null) {
                return response()->json(["data" => $todo,"message"=>"Todo not found"],404);
            }
            $todo->delete();
            return response()->json(["message"=>"Todo deleted"]);
        } catch(\Exception $e){
            return response()->json(["message"=>"Todo updated","error"=>$e->getMessage()],400);
        }
    }
}
