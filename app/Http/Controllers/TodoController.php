<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $todos = Todo::get();
        return view('todolist', ['todos' => $todos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('addtodo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);
		
        $input = $request->input();
		
       
        $todoStatus = Todo::create($validatedData);
        if ($todoStatus) {
            $request->session()->flash('success', 'Todo successfully added');
        } else {
            $request->session()->flash('error', 'Oops something went wrong, Todo not saved');
        }
        return redirect('todo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $where = array('id' => $id);
		$todo = Todo::where($where)->first();
        if (!$todo) {
            return redirect('todo')->with('error', 'Todo not found');
        }
        return view('view', ['todo' => $todo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
		$todo = Todo::where(['id' => $id])->first();
		
        if ($todo) {
            return view('edittodo', [ 'todo' => $todo ]);
        } else {
            return redirect('todo')->with('error', 'Todo not found');
        }
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
	   
        $todo = Todo::find($id);
		
        $input = $request->input();
      
        $todoStatus = $todo->update($input);
        if ($todoStatus) {
            return redirect('/')->with('success', 'Todo successfully updated.');
        } else {
            return redirect('/')->with('error', 'Oops something went wrong. Todo not updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
        $todo = Todo::where(['id' => $id])->first();
        $responseStatus = $responseMsg = '';
        if (!$todo) {
            $responseStatus = 'error';
            $responseMsg = 'Todo not found';
        }
        $todoDelStatus = $todo->delete();
        if ($todoDelStatus) {
            $responseStatus = 'success';
            $responseMsg = 'Todo deleted successfully';
        } else {
            $responseStatus = 'error';
            $responseMsg = 'Oops something went wrong. Todo not deleted successfully';
        }
        return back()->with($responseStatus, $responseMsg);
    }
}
