<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Http\Requests\MoneyValidationFormRequest;

class BalanceController extends Controller
{
    public function index(){
        $balance = auth()->user()->balance;
        $amount = $balance ? $balance->amount : 0;
        return view('admin.balance.index', compact('amount'));
    }

    public function deposit(){
        return view('admin.balance.deposit');
    }

    public function depositStore(MoneyValidationFormRequest $request){
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->deposit($request->valor);

        if ($response['success'])
            return redirect()
                        ->route('admin.balance')
                        ->with('success', $response['message']);

        return redirect()
                    ->back('admin.balance')
                    ->with('error', $response['message']);
    }

    public function withdraw()
    {
        $balance = auth()->user()->balance;
        $amount = $balance ? $balance->amount : 0;
        return view('admin.balance.withdraw', compact('amount'));
    }

    public function withdrawStore(MoneyValidationFormRequest $request){
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->withdraw($request->valor);

        if ($response['success'])
            return redirect()
                        ->route('admin.balance')
                        ->with('success', $response['message']);

        return redirect()
                    ->back('admin.balance')
                    ->with('error', $response['message']);
    }

}
