<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    public $timestamps = false;

    public function deposit($valor) : array {
        $this->amount += number_format($valor, 2, '.', '');
        $deposit = $this->save();
        if($deposit)
            return [
                'success' => true,
                'message' => 'deposito realizado com sucesso!'
            ];

        return [
            'success' => false,
            'message' => 'falha em depositar'
        ];
    }
}
