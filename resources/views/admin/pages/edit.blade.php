@extends('layouts.page')

@section('title', 'Редактировать новость')
@section('content')
@include('admin.part.message')

    <h1>Редактировать новость</h1>
    {!! Form::model($post, array('route' => array('admin-panel.update', $post->id), 'method' =>'PUT', 'enctype' => 'multipart/form-data' )) !!}

    {!! Form::label('title', 'Заголовок') !!}
    {!! Form::text('title', NULL, ['class' => 'form-control']) !!}

    {!! Form::label('content', 'Содержимое') !!}
    {!! Form::textarea('content', NULL, ['class' => 'form-control']) !!}

    {!! Form::label('image', 'Изображение') !!}

    @if($post->image != ' ')
        <div class="img">
            <img style="max-height: 100px" src="{{ URL::to('img/posts'). '/' . $post->id . '.png' }}" alt="{!! $post->title !!}">
        </div>
        
        {!! Form::label('image', 'Изменить изображение') !!}

        @else <p>Вы пока не загрузили изображение</p>
    @endif
    
        

        {!! Form::file('image' , ['class' => 'form-control']) !!}

        @if($post->image != ' ')
             {!! Form::checkbox('delete_image', '1') !!} 
             {!! Form::label('delete_image', 'Удалить изображение') !!}
        @endif

    <div class="form-group">
        {!! Form::submit('Опубликовать', ['class' => 'btn btn-primary']) !!}
    </div>
    

    {!! Form::close() !!}


@endsection