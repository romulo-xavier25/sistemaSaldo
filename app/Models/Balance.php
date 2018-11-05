<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Balance extends Model
{
    public $timestamps = false;

    public function deposit($valor) : array {

        DB::beginTransaction();        

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount += number_format($valor, 2, '.', '');
        $deposit = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'          => 'I',
            'amount'        => $valor,
            'total_before'  => $totalBefore,
            'total_after'   => $this->amount,
            'date'          => date('Ymd'),
        ]);

        if($deposit && $historic){
            
            DB::commit();

            return [
                'success' => true,
                'message' => 'deposito realizado com sucesso!'
            ];

        } else {
            
            DB::rollback();
            
            return [
                'success' => false,
                'message' => 'falha em depositar'
            ];

        }
    }

    public function withdraw(float $valor) : array
    {

        if ($this->amount < $valor)
            return [
                'success' => 'false',
                'message' => 'Saldo insuficiente',
            ];

        DB::beginTransaction();        

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($valor, 2, '.', '');
        $withdraw = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'          => 'O',
            'amount'        => $valor,
            'total_before'  => $totalBefore,
            'total_after'   => $this->amount,
            'date'          => date('Ymd'),
        ]);

        if($withdraw && $historic){
            
            DB::commit();

            return [
                'success' => true,
                'message' => 'saque realizado com sucesso!'
            ];

        } else {
            
            DB::rollback();
            
            return [
                'success' => false,
                'message' => 'falha no saque'
            ];

        }
    }


}
