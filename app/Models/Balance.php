<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;

class Balance extends Model
{
    public $timestamps = false;

    public function deposit($valor) : array 
    {

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

        if ($deposit && $historic) {
            
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

        if ($withdraw && $historic) {
            
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

    public function transfer(float $valor, User $sender) : array
    {
        if ($this->amount < $valor)
            return [
                'success' => 'false',
                'message' => 'Saldo insuficiente',
            ];

        DB::beginTransaction();
        
        // Atualiza o proprio saldo
        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($valor, 2, '.', '');
        $transfer = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'                  => 'T',
            'amount'                => $valor,
            'total_before'          => $totalBefore,
            'total_after'           => $this->amount,
            'date'                  => date('Ymd'),
            'user_id_transaction'   => $sender->id,
        ]);

        // Atualiza o saldo do recebedor
        $senderBalance = $sender->balance()->firstOrCreate([]);
        $totalBeforeSender = $senderBalance->amount ? $senderBalance->amount : 0;
        $senderBalance->amount += number_format($valor, 2, '.', '');
        $transferSender = $senderBalance->save();

        $historicSender = $sender->historics()->create([
            'type'                  => 'I',
            'amount'                => $valor,
            'total_before'          => $totalBeforeSender,
            'total_after'           => $senderBalance->amount,
            'date'                  => date('Ymd'),
            'user_id_transaction'   => auth()->user()->id,
        ]);

        if ($transfer && $historic && $transferSender && $historicSender) {
            
            DB::commit();

            return [
                'success' => true,
                'message' => 'transferencia realizado com sucesso!'
            ];

        } 
        
        DB::rollback();
            
        return [
            'success' => false,
            'message' => 'falha na transferencia'
        ];
    }
}
