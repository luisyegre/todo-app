<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return response()->json($todos);
    }

    public function show($id)
    {
        $todo = Todo::find($id);
        return response()->json($todo);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $todo = new Todo([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        $todo->save();

        return response()->json('Todo created!');
    }

    public function update($id, Request $request)
    {
        $todo = Todo::find($id);

        $todo->update($request->all());

        return response()->json('Todo updated!');
    }

    public function destroy($id)
    {
        $todo = Todo::find($id);
        $todo->delete();

        return response()->json('Todo deleted!');
    }
}
