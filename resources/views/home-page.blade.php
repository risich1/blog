@extends('layouts.page')

@section('title', 'Главная')

@section('content')
@include('auth.part.message')
@if(Auth::guest())
    <h1 style="text-align:center">Чтобы просматривать новости, вам нужно авторизоваться или зарегистрироваться</h1>
@else
    @foreach($post as $p)

            <div class="post col-md-4">
                <a href="{{ URL::to('full'). '/' . $p->id }}">
                    <h1>{!! $p->title !!}</h1>
                    <p>{!! $p->content !!}</p>
                </a>
            </div>
    @endforeach
@endif 

    <div class="col-md-12">
        {{$post->links()}}
    </div>
    

@endsection


