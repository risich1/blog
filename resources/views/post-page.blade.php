@extends('layouts.page')

@section('title', 'Страница поста')

@section('content')
                <div class="post">
                     
                    <h1>{!! $post->title !!}</h1>
                    @if($post->image != ' ')
                        <img src="{{ URL::to('img/posts'). '/' . $post->id . '.png' }}" alt="{!! $post->title !!}">
                    @endif
                    <p>{!! $post->content !!}</p>

            </div>
@endsection