<?php

namespace App\Http\Controllers;

use App\Mail\TaskMail;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class TasksController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id',auth()->id())->latest()
            ->paginate(5);
        //dd($tasks);
        return view('home', compact('tasks'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);
        $task = new Task();
        $task->description = $request->description;
        $task->user_id = auth()->user()->id;
        $task->save();
        return redirect()->back()->with('message', 'Task created');
    }

    public function edit(Task $task)
    {
        if (auth()->user()->id == $task->user_id)
        {
            return redirect()->back()->with('task',$task);
        }
        else {
            return redirect('/home');
        }
    }

    public function deleteTask(Request $request, Task $task)
    {
        $task->delete();
        return redirect()->back()->with('message', 'Task deleted');
    }

    public function update(Request $request)
    {
        //dd(json_decode($request->task)->id);
        $taskId = json_decode($request->task)->id;
        $task=Task::Find($taskId);
        $task->description=$request->description;
        $task->update();

        return redirect('/home')->with('message', 'Task updated');
    }

    public function store(Request $request, Task $task){
        $task->update([
            'status' => $request->has('status') ? 1 : 0
        ]);
        $emailAddress = auth()->user()->email;

        //Send email
        $toEmail    =   $emailAddress;
        $data       =   array(
            "description"    =>   $request->description,
            "status"    =>   $request->status
        );
        // pass dynamic message to mail class
        Mail::to($toEmail)->send(new TaskMail($data));

        return redirect()->back()->with('success', 'Task checked successfully');
    }

    public function search(Request $request)
    {
        $taskDescription = $request->searchQuery;
        $tasks = Task::where('description','LIKE','%'.$taskDescription.'%')
            ->latest()
            ->paginate(5);
        return view('home', compact('tasks'));
    }
}
