@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto sm:mt-10 mb-5">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif
            <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-8" method="POST" action="/task">
                @csrf

                <div class="flex flex-wrap">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                        Task Description
                    </label>
                    <input id="description" type="description"
                           class="form-input w-full @error('description') border-red-500 @enderror" name="description"
                           required>

                    @error('description')
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="flex flex-wrap justify-center align-center">
                    <button type="submit"
                            class="select-none font-bold whitespace-no-wrap p-3 rounded-lg text-base leading-normal no-underline text-gray-100 bg-blue-500 hover:bg-blue-700 mb-4">
                        Create
                    </button>
                </div>
            </form>
            <form action="{{ route('task.search')}}" method="GET" id="taskSearch">
            <div class="flex items-center max-w-md mx-auto bg-white rounded-lg mb-4">
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
        <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">
            @foreach($tasks as $task)
                <div class="p-5 mx-2 bg-white rounded-lg flex items-center justify-between space-x-8">
                    <div class="flex-1 flex justify-between items-center">
                        <form action="/check-task/{{$task->id}}" class="inline-block" id="check{{$task->id}}" action="{{ route('status-check',['task' => $task->id]) }}"
                              method="POST">
                            <input name="description" type="hidden" value="{{$task->description}}">
                            <label class="inline-flex items-center mt-3">
                                <input type="checkbox" class="form-checkbox h-5 w-5 text-green-600" name="status" {{ ($task->status) ? "checked" : "" }} onchange="event.preventDefault();document.getElementById('check{{$task->id}}').submit();">
                            </label>
                            {{ csrf_field() }}
                        </form>
                        <div class="h-4 w-48 rounded @if($task->status)line-through @endif">
                            {{$task->description}}
                        </div>
                        <div class="w-24 h-6 rounded-lg ">
                            <a href="/task/{{$task->id}}" name="edit" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Edit</a>
                        </div>
                        <div class="w-24 h-6">
                            <form action="/task/{{$task->id}}" class="inline-block" action="{{ route('up.Delete',['task' => $task->id]) }}">
                                <button type="submit" name="delete" formmethod="POST" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button>
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>

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
</main>
@endsection
