@extends('adminlte::page')

@section('title', 'deposito')

@section('content_header')
    <h1>Realizar deposito</h1>
@stop

@section('content')
    <div class="box">

        <div class="box-body">
            <div class="col-xs-12 col-md-4 formDeposito">

                @include('admin.includes.alerts')

                <form method="POST" action="{{ route('deposit.store') }}">
                    {!! csrf_field() !!}
                    
                    <div class="form-group">
                        <input type="text" name="valor" class="form-control" placeholder="Valor da recarga">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Depositar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@stop