@component('mail::message')
    # Hello, {{ $data['user']->name }}

    Your task {{ $data['task']['description'] }} {{$data['task']['status'] == 'on' ? 'has been completed' : 'is incomplete'}}.




    Thanks,
    {{ config('app.name') }}
@endcomponent
