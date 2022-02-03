@extends('layouts.app')

@section('content')
    <main class="sm:container sm:mx-auto sm:mt-10 mb-5">
        <div class="w-full sm:px-6">

            @if (session('status'))
                <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif
                @if (session('message'))
                    <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

            <form action="{{ route('task.search')}}" method="GET" id="taskSearch">
                <div class="flex items-center mx-2 bg-white rounded-lg mb-4 mt-3 md:mx-auto">
                    <div class="w-full">
                        <input type="search" name="searchQuery" class="w-full px-4 py-1 text-gray-800 rounded-full focus:outline-none"
                               placeholder="Search">
                    </div>
                    <div>
                        <button onclick="event.preventDefault();document.getElementById('taskSearch').submit();" class="flex items-center bg-blue-500 justify-center w-12 h-12 text-white rounded-r-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>

                </div>
                {{ csrf_field() }}
            </form>
            <div class="flex flex-col pt-10 justify-center px-2">
                <div>
                    <form class="bg-white rounded-md py-10 shadow-lg"
                          method="POST"
                          action="{{session('task') ? route('task.update') : route('task.create')}}">
                        @csrf

                        <input name="task" type="hidden" value="{{session('task')}}">

                        <h1 class="text-xl mt-2 text-center font-semibold text-gray-600">Task</h1>
                        <div class="mt-6 flex space-x-4 justify-center">
                            <input placeholder="Add new task"
                                   class="bg-gray-100 rounded-md py-2 px-4 border-2 outline-none @error('description') border-red-500 @enderror"
                                   @if(session('task')) value="{{session('task')->description}}" @endif
                                   name="description"
                                   required>
                            @error('description')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                            @enderror
                            <button type="submit" class="bg-blue-500 px-4 text-white rounded-md font-semibold">
                                {{session('task') ? 'Update' : 'Create'}}
                            </button>
                        </div>
                    </form>
                    @forelse($tasks as $task)
                        <div class="mt-6 bg-white p-6 rounded-md text-gray-500 shadow-lg">
                            <div class="flex-1 flex justify-between items-center">
                                <form action="/check-task/{{$task->id}}" class="inline-block" id="check{{$task->id}}" action="{{ route('status-check',['task' => $task->id]) }}"
                                      method="POST">
                                    <input name="description" type="hidden" value="{{$task->description}}">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="form-checkbox h-5 w-5 text-green-600" name="status" {{ ($task->status) ? "checked" : "" }} onchange="event.preventDefault();document.getElementById('check{{$task->id}}').submit();">
                                    </label>
                                    {{ csrf_field() }}
                                </form>
                                <div class="h-4 w-48 text-center rounded @if($task->status)line-through @endif">
                                    {{$task->description}}
                                </div>
                                @if(!$task->status)
                                    <div class="w-24 h-6">
                                        <button class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">
                                            <a href="{{route('task.edit',$task->id)}}">
                                                Edit
                                            </a>
                                        </button>
                                    </div>
                                @endif

                                <div class="w-24 h-6">
                                    <button onclick="deleteConfirmation()" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">
                                        Delete
                                    </button>
                                    <form class="inline-block" id="deleteTaskForm" method="POST" action="{{route('task.delete',$task->id)}}">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                            <div class="text-sm border border-t-8 rounded text-red-700 border-red-600 bg-red-100 px-3 py-4 mb-4" role="alert">
                               Oops! 💀 You don't have any tasks.
                            </div>
                    @endforelse

                </div>
                @if($tasks->hasPages())
                    <section class="flex pl-0 list-none rounded my-2 justify-center align-center">
                        <div class="row">
                            <div class="relative block py-2 px-3 leading-tight bg-white border border-gray-300 text-blue-700 border-r-0 hover:bg-gray-200">
                                {{ $tasks->links('pagination::tailwind') }}
                            </div>

                        </div>
                    </section>
                @endif
            </div>
        </div>
    </main>
@endsection
