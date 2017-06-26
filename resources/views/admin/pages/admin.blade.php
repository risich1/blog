@extends('layouts.page')

@section('title', 'Управление новостями')

@section('content')
@include('admin.part.message')
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Заголовок</th>
            <th>Статус</th>
            <th>Контент</th>
            <th>Управление</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach($post as $p)
            <tr>
                <th scope="row">{!! $p->id !!}</th>
                <th>{!! $p->title !!}</th>
                <th>
                    @if($p->status == false)
                        Не опубликована
                    @else
                        Опубликована
                    @endif
                </th>


                <th style="max-width:300px">{!! $p->content !!}</th>
 
                <th style="width: 260px; overflow: hidden;">
                    <a href="{{ URL::to('admin-panel/' . $p->id . '/edit') }}" class="btn btn-default edit-btn-table">Редактировать</a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Modal{{$p->id}}">Удалить</button>





<div id="Modal{{$p->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Удаление</h4>
      </div>
      <div class="modal-body">
        <p>Вы точно хотите удалить эту новость?</p>
      </div>
      <div class="modal-footer">
            {{ Form::open(['route' => ['admin-panel.destroy', $p->id], 'method' => 'delete']) }}
            {{ Form::submit('Да', ['class' => 'btn btn-danger']) }}
            {{ Form::close() }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Нет</button>
      </div>
    </div>

  </div>
</div>





                @if($p->status == false)

                    {{ Form::open(['route' => ['admin-panel.show', $p->id], 'method' => 'get']) }}
                    {{ Form::submit('Опубликовать', ['class' => 'btn btn-primary pub-btn', 'method' => 'get']) }}
                    {{ Form::close() }}
                    @else
                    {{ Form::open(['route' => ['admin-panel.show', $p->id], 'method' => 'get']) }}
                    {{ Form::submit('Снять с публикации', ['class' => 'btn btn-info pub-btn', 'method' => 'get']) }}
                    {{ Form::close() }}
                @endif    
                </th>
            </tr>
        @endforeach
    </tbody>

</table>

{{$post->links()}}

  

@endsection