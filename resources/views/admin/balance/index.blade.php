@extends('adminlte::page')

@section('title', 'Saldo')

@section('content_header')
    <h1>Saldo</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <a href="{{ route('balance.deposit') }}" class="btn btn-primary"> 
                <i class="fa fa-cart-plus"></i> Recarregar
            </a>

            <a href="#" class="btn btn-danger"> 
                <i class="fa fa-cart-plus"></i> Sacar
            </a>
        </div>

        <div class="box-body">
            <div class="col-xs-12 col-md-4 blocoSaldo">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>R$ {{ number_format($amount, 2, '.', '') }}</h3>
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