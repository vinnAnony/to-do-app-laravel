@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto sm:mt-10">
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
        <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">
            @foreach($tasks as $task)
                <div class="p-5 mx-2 bg-white rounded-lg flex items-center justify-between space-x-8">
                    <div class="flex-1 flex justify-between items-center">
                        <form action="/task/{{$task->id}}" class="inline-block" id="check{{$task->id}}" action="{{ route('status-check',['task' => $task->id]) }}"
                              method="POST">
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
                            <form action="/task/{{$task->id}}" class="inline-block">
                                <button type="submit" name="delete" formmethod="POST" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button>
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

        </section>
    </div>
</main>
@endsection
