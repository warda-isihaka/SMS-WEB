<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Pledge;

class BudgetController extends Controller
{
    public function index()
    {
        if (!auth()->check() || !auth()->user()->canViewBudget()) {
        abort(403, 'Unauthorized access to Budget.');
    }
    
        // 1. Chukua mahitaji yote ya budget kutoka kwenye database
        $needs = Budget::all();

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
            'amount'  => $request->amount,
        ]);

        return redirect()->back()->with('success', 'Budget item added successfully!');
    }

    
}