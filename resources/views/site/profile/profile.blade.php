@extends('site.layout.app')

@section('title', 'Meu perfil')

@section('content')

    <h1>Meu perfil</h1>

@include('admin.includes.alerts')

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group">
            <label for="name">nome</label>
            <input type="text" value="{{ auth()->user()->name }}" class="form-control" name="nome" placeholder="nome">
        </div>

        <div class="form-group">
            <label for="email">email</label>
            <input type="email" value="{{ auth()->user()->email }}" class="form-control" name="email" placeholder="email">
        </div>

        <div class="form-group">
            <label for="password">senha</label>
            <input type="password" value="{{ auth()->user()->senha }}" class="form-control" name="password" placeholder="senha">
        </div>

        <div class="form-group btnFile">
            @if (auth()->user()->image != null)
                <img src="{{ url('storage/users/'.auth()->user()->image) }}" alt="{{auth()->user()->image}}">
            @endif

            <label for="image">imagem</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-info">Atualizar perfil</button>
        </div>
    </form>

@endsection
