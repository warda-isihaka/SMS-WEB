<?php

namespace App\Http\Controllers;

use App\Models\Pledge;
use Illuminate\Http\Request;

class PledgeController extends Controller
{
    // 1. Method ya kuonyesha fomu ya /create
    public function create()
    {
        $settings = (object)[
            'single_amount' => 50000,
            'double_amount' => 100000,
        ];

        return view('create', compact('settings'));
    }

    // 2. Method ya kuhifadhi ahadi kutoka kwenye fomu kwenda database
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|in:SINGLE,DOUBLE,OTHERS',
            'amount'   => 'required|numeric|min:1',
        ]);

        Pledge::create([
            'user_id'  => auth()->id(),
            'category' => $request->category,
            'amount'   => $request->amount,
            'paid'     => 0,
            'remain'   => $request->amount,
            'status'   => 'pending',
        ]);

        return redirect()->back()->with('success', 'Ahadi yako imerekodiwa kikamilifu!');
    }

    // 3. ONGEZA HII: Inaonyesha ukurasa wa status wa user aliyelogin
    public function showStatus()
    {
        $pledges = Pledge::where('user_id', auth()->id())->get();
        return view('status', compact('pledges'));
    }

    // 4. ONGEZA HII: Inatafuta status ya ahadi
    public function searchStatus(Request $request)
    {
        $search = $request->input('search');

        $pledges = Pledge::whereHas('user', function ($q) use ($search) {
            $q->where('phone', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%");
        })->get();

        return view('status', compact('pledges'));
    }

    // 5. Admin: Ukurasa wa usimamizi
    public function pledgeManagement()
    {
        $pledges = Pledge::with('user')->get();
        return view('pledge_management', compact('pledges'));
    }

    // 6. Admin: Kurekebisha malipo na status
    public function updateStatusAndPaid(Request $request)
    {
        $pledgesData = $request->input('pledges', []);

        foreach ($pledgesData as $item) {
            $pledge = Pledge::find($item['id']);

            if ($pledge) {
                $pledge->paid = $item['paid'];
                $pledge->remain = $item['remain'];

                if ($pledge->remain == 0 && $pledge->paid > 0) {
                    $pledge->status = 'completed';
                } else {
                    $pledge->status = 'pending';
                }

                $pledge->save();
            }
        }

        return response()->json(['success' => true]);
    }

        public function showCard()
{
    // Inavuta ahadi ya hivi karibuni ya user aliyelogin
    $pledge = Pledge::where('user_id', auth()->id())->latest()->first();

    return view('card', compact('pledge'));
}

public function manage()
{
    if (!auth()->check() || !auth()->user()->isAccountant()) {
        abort(403, 'Unauthorized access to Pledge Management.');
    }

    return view('pledge_management');
}
}