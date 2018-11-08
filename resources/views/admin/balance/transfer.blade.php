@extends('adminlte::page')

@section('title', 'transferir saldo')

@section('content_header')
    <h1>Realizar transferência</h1>
@stop

@section('content')
    <div class="box">

        <div class="box-body">
            <div class="col-xs-12 col-md-4 formDeposito">

                @include('admin.includes.alerts')

                <h3>informe o recebedor</h3>

                <form method="POST" action="{{ route('confirm.transfer') }}">
                    {!! csrf_field() !!}
                    
                    <div class="form-group">
                        <input type="text" name="sender" class="form-control" placeholder="Informação de quem vai receber o saque(Nome ou Email)">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Próxima Etapa</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@stop