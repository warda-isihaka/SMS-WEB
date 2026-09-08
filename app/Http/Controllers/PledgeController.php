<?php 

namespace App\Http\Controllers;

use App\Models\Pledge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PledgeController extends Controller
{
    public function create()
    {
        $contacts = [
            'CHAIRPERSON' => '07xx xxx xxx',
            'ACCOUNTANT'  => '07xx xxx xxx',
        ];

        // Mipangilio ya chaguomsingi ikiwa huna Setting model
        $settings = (object)[
            'single_amount' => 50000,
            'double_amount' => 100000,
        ];

        return view('create', compact('contacts', 'settings'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category'       => 'required|in:SINGLE,DOUBLE,OTHERS',
            'amount'         => 'required|numeric|min:0',
            'payment_method' => 'nullable|in:M-PESA,AIRTEL MONEY,MIXX BY YAS,HALOPESA', 
        ]);

        if ($validator->fails()) {
            return redirect()->route('create')
                        ->withErrors($validator)
                        ->withInput();
        }

        Pledge::create([
            'category'       => $request->category,
            'amount'         => $request->amount,
            'payment_method' => $request->payment_method,
            'status'         => 'pending',
        ]);

        return redirect()->route('create')->with('success', 'Ahadi yako imerekodiwa kikamilifu!');
    }

    // Onyesha ukurasa wa status mara ya kwanza (kabla ya kutafuta)
    public function showStatus()
    {
        return view('status');
    }

    // Tafuta taarifa za ahadi kwa namba ya simu
    public function searchStatus(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $phone = $request->input('phone');

        // Tafuta ahadi ya hivi karibuni inayofanana na namba iliyoingizwa
        $pledge = Pledge::where('phone', $phone)->latest()->first();

        // Hesabu salio lililobaki ikiwa ahadi imepatikana
        $remain = 0;
        if ($pledge) {
            $remain = ($pledge->amount ?? 0) - ($pledge->paid_amount ?? $pledge->paid ?? 0);
        }

        return view('status', compact('pledge', 'remain'));
    }
}