@extends('adminlte::page')

@section('title', 'confirmar transferencia do saldo')

@section('content_header')
    <h1>Confirmar transferência</h1>
@stop

@section('content')
    <div class="box">

        <div class="box-body">
            <div class="col-xs-12 col-md-4 formDeposito">

                @include('admin.includes.alerts')

                <p><strong>Recebedor: </strong> {{ $sender->name }} </p>
                <p><strong>Seu saldo atual: </strong> R${{ number_format($balance->amount, 2, '.', '') }} </p>


                <form method="POST" action="{{ route('transfer.store') }}">
                    {!! csrf_field() !!}

                    <input type="hidden" name="senderId" value="{{ $sender->id }}">
                    
                    <div class="form-group">
                        <input type="text" name="valor" class="form-control" placeholder="Valor:">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Transferir</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@stop