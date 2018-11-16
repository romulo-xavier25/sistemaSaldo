<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Historic;
use App\Http\Requests\MoneyValidationFormRequest;
use App\User;

class BalanceController extends Controller
{

    private $totalPaginacao = 5;

    public function index()
    {
        $balance = auth()->user()->balance;
        $amount = $balance ? $balance->amount : 0;
        return view('admin.balance.index', compact('amount'));
    }

    public function deposit()
    {
        return view('admin.balance.deposit');
    }

    public function depositStore(MoneyValidationFormRequest $request)
    {
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

    public function withdrawStore(MoneyValidationFormRequest $request)
    {
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

    public function transfer()
    {
        return view('admin.balance.transfer');
    }

    public function confirmTransfer(Request $request, User $user)
    {
        $sender = $user->getSender($request->sender);
        if (!$sender)
        {
            return redirect()
                        ->back()
                        ->with('error', 'Usuário informando não foi encontrado!');
        } if ($sender->id === auth()->user()->id) {
            return redirect()
                        ->back()
                        ->with('error', 'Não pode transferir para você mesmo!');
        } else {
            $balance = auth()->user()->balance;
            return view('admin.balance.transferConfirm', compact('sender', 'balance'));
        }
        
    }

    public function transferStore(MoneyValidationFormRequest $request, User $user)
    {

        if (!$sender = $user->find($request->senderId))
            return redirect()
                    ->route('admin.balance')
                    ->with('success', 'Recebedor não foi encontrado!');

        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->transfer($request->valor, $sender);

        if ($response['success'])
            return redirect()
                        ->route('balance.transfer')
                        ->with('success', $response['message']);

        return redirect()
                    ->back('balance.transfer')
                    ->with('error', $response['message']);
    }

    public function historic(Historic $historic)
    {
        $historics = auth()->user()
                                ->historics()
                                ->with(['userSender'])
                                ->paginate($this->totalPaginacao);

        $types = $historic->type();

        return view('admin.balance.historics', compact('historics', 'types'));
    }

    public function searchHistoric(Request $request, Historic $historic)
    {
        $dataForm = $request->all();

        $historics = $historic->search($dataForm, $this->totalPaginacao);

        $types = $historic->type();

        return view('admin.balance.historics', compact('historics', 'types'));
    }

}