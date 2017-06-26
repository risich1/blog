
@if(count($errors) > 0)
<?php 
$messages = [ $errors->first('title', "Поле 'заголовок' обязательно для заполнения"),
$errors->first('content', "Поле 'контент' обязательно для заполнения"),
$errors->first('image', "Загруженный вами файл не является изображением") ];
?>

<div class="alert alert-danger">
    @foreach ($messages as $message)
    <li style="list-style: none" >{{ $message }}</li>
    @endforeach
</div>
@endif

@if(Session::has('success'))

<div class="alert alert-success">
    {{ Session::get('success') }}
</div>

@endif

@if(Session::has('delete'))

<div class="alert alert-danger">
    {{ Session::get('delete') }}
</div>

@endif







