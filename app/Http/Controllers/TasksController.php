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
        $tasks = Task::where('user_id',auth()->id())->paginate(5);
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
        return redirect('/home');
    }

    public function edit(Task $task)
    {

        if (auth()->user()->id == $task->user_id)
        {
            return view('edit', compact('task'));
        }
        else {
            return redirect('/home');
        }
    }

    public function update(Request $request, Task $task)
    {
        //dd($task);
        if(isset($_POST['delete'])) {
            $task->delete();
            return redirect('/home');
        }
        else
        {
            $this->validate($request, [
                'description' => 'required'
            ]);
            $task->description = $request->description;
            $task->save();
            return redirect('/home');
        }
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

        return redirect()->back()->with('success', 'Task updated successfully');
    }

    public function search(Request $request)
    {
        $taskDescription = $request->searchQuery;
        $tasks = Task::where('description','LIKE','%'.$taskDescription.'%')
            ->paginate(5);
        return view('home', compact('tasks'));
    }
}
