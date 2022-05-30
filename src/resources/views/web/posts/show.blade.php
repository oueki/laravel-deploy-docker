@extends('web.layout.one-layout')

@section('content')

    <h1 class="text-2xl">{{ $post->title }}</h1>


    <div class="prose">
        {!! $post->content !!}
    </div>
@endsection
