@component('mail::message')

@slot('header')
        @component('mail::header', ['url' => $url])
            <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}" style="height: 60px;">
        @endcomponent
@endslot

# @lang('email.hello')@if(!empty($notifiableName)){{ ' '.$notifiableName }}@endif!

@if (!empty($content))

@component('mail::text', ['text' => $content])

@endcomponent
@endif

@if (!empty($url))
    @component('mail::button', ['url' => $url, 'themeColor' => ((!empty($themeColor)) ? $themeColor : '#1f75cb')])
    {{ $actionText }}
    @endcomponent
@endif

@lang('email.regards'),<br>
{{ config('app.name') }}
@endcomponent
