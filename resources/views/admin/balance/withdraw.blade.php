@extends('adminlte::page')

@section('title', 'Saque')

@section('content_header')
    <h1>Realizar saque</h1>
@stop

@section('content')
    <div class="box">

        <div class="box-body">
            <div class="col-xs-12 col-md-6 formDeposito">

                @include('admin.includes.alerts')

                <form method="POST" action="{{ route('withdraw.store') }}">
                    {!! csrf_field() !!}
                    
                    <div class="form-group">
                        <input type="text" name="valor" class="form-control" placeholder="Valor do saque">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Sacar</button>
                    </div>
                </form>
            </div>

            <div class="col-xs-12 col-md-7 blocoSaldo">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>Saldo atual: R$ {{ number_format($amount, 2, '.', '') }}</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Histórico <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>

@stop