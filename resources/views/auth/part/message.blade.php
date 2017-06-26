@if(Session::has('auth'))

<div class="alert alert-danger">
    {{ Session::get('auth') }}
</div>

@endif