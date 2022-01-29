@component('mail::message')
    # Hello, {{ $data['user']->name }}

    Your task {{ $data['task']['description'] }} {{$data['task']['status'] == 1 ? 'has been completed' : 'is incomplete'}}.




    Thanks,
    {{ config('app.name') }}
@endcomponent
