<?php 
namespace App\Http\Controllers;
use App\Models\Pledge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PledgeController extends Controller
{
    /**
     * Display the pledge form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Unaweza kuongeza data zingine za contact hapa, kama contacts za viongozi
        $contacts = [
            'CHAIRPERSON' => '07xx xxx xxx',
            'ACCOUNTANT' => '07xx xxx xxx',
        ];

        return view('pledges.create', compact('contacts'));
    }

    /**
     * Store a newly created pledge in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validator = Validator::make($request->all(), [
            'category' => 'required|in:SINGLE,DOUBLE,OTHERS',
            'amount' => 'required|numeric|min:0',
            // Payment method can be nullable if they don't select immediately
            'payment_method' => 'nullable|in:M-PESA,AIRTEL MONEY,MIXX BY YAS,HALOPESA', 
        ]);

        if ($validator->fails()) {
            return redirect()->route('pledges.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        // 2. Create the pledge
        Pledge::create([
            'category' => $request->category,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending', // Default status
        ]);

        // 3. Redirect with success message
        return redirect()->route('pledges.create')->with('success', 'Ahadi yako imerekodiwa kikamilifu!');
    }

    /**
     * Display the status of pledges. (Example)
     *
     * @return \Illuminate\View\View
     */
    public function status()
    {
        // Hapa utatafuta pledges zote au za user fulani
        $pledges = Pledge::orderBy('created_at', 'desc')->get();
        return view('pledges.status', compact('pledges'));
    }
}