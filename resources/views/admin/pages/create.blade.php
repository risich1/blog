@extends('layouts.page')

@section('title', 'Создать новость')
@section('content')
@include('admin.part.message')

    <h1>Создать новость</h1>

    
    
    {!! Form::open(array('route' => 'admin-panel.store', 'files' => true)) !!}

    {!! Form::label('title', 'Заголовок') !!}

    @if(isset($error))
    
        {!! Form::text('title', $post, ['class' => 'form-control']) !!}
    }
    }
    @else 
        {!! Form::text('title', NULL, ['class' => 'form-control']) !!}
    @endif

    {!! Form::label('content', 'Содержимое') !!}

    @if(isset($error))
        {!! Form::textarea('content', $content, ['class' => 'form-control']) !!}
    @else 
        {!! Form::textarea('content', NULL, ['class' => 'form-control']) !!}
    @endif

    {!! Form::label('image', 'Изображение') !!}

   @if(isset($error))
    
    @if($imageWith == true)
        <div class="image">
            Изображение загружено
        </div>
    @endif

   @endif

    {!! Form::file('image' , ['class' => 'form-control']) !!}

    {!! Form::submit('Опубликовать', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
@endsection