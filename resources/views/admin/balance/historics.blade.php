@extends('adminlte::page')

@section('title', 'Histórico de movimentações')

@section('content_header')
    <h1>Histórico de movimentações</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header">

        </div>

        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>?Sender?</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historics as $historic)
                    <tr>
                        <td>{{ $historic->id }}</td>
                        <td>R${{ number_format($historic->amount, 2, '.', '') }}</td>
                        <td>{{ $historic->type($historic->type) }}</td>
                        <td>{{ $historic->date }}</td>
                        <td>
                            @if ($historic->user_id_transaction)
                                {{ $historic->userSender->name }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {!! $historics->links() !!}

        </div>

    </div>
    
@stop