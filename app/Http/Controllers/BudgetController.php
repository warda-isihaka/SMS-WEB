<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Pledge;
use app\Models\Event;

class BudgetController extends Controller
{
    public function index()
    {
        if (!auth()->check() || !auth()->user()->canViewBudget()) {
        abort(403, 'Unauthorized access to Budget.');
        $eventId = session('active_event_id');
        $needs = Budget::where('event_id', $eventId)->get();
    }
    

        // 2. Hesabu jumla ya kiasi cha mahitaji zote (Needs Total Amount)
        $totalNeedsAmount = Budget::sum('amount');

        // 3. Chukua AVAILABLE MONEY kutoka kwenye table ya pledges (column ya 'paid')
        $availableMoney = Pledge::sum('paid');

        // 4. Tuma data kwenye View ya budget
        return view('budget', compact('needs', 'totalNeedsAmount', 'availableMoney'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        Budget::create([
            'user_id' => auth()->id() ?? 1,
            'event_id' => session('active_event_id'),
            'amount'  => $request->amount,
        ]);

        return redirect()->back()->with('success', 'Budget item added successfully!');
    }

    
}