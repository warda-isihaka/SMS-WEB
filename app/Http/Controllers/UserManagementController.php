<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Role;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function store(Request $request)
    {
        return $this->update($request);
    }

    // 1. Onyesha ukurasa na uvute watumiaji pamoja na role_id zao
    public function index()
    {
        $users = User::all();
        return view('user-management', compact('users'));
    }

    // 2. Hifadhi au sasisha role moja tu kwa kila mtumiaji kwenye column ya role_id
    public function update(Request $request)
    {
        $rolesData = $request->input('roles', []);

        // Chukua ID za roles kutoka kwenye database kulingana na majina yake
        $accountantRole = Role::where('name', 'accountant')->first();
        $committeeRole  = Role::where('name', 'committee')->first();

        $accountantId = $accountantRole ? $accountantRole->id : 1;
        $committeeId  = $committeeRole ? $committeeRole->id : 2;

        $roleMap = [
            'accountant' => $accountantId,
            'committee'  => $committeeId,
            'normal user' => null,
        ];

        // Pitia data zilizotumwa kutoka kwenye Radio Buttons za fomu
        foreach ($rolesData as $userId => $selectedRole) {
            $user = User::find($userId);

            if ($user) {
                // Kama ulichagua 'none', role_id inakuwa NULL, vinginevyo inachukua ID ya role husika
                $user->role_id = $roleMap[$selectedRole] ?? null;
                $user->save();
            }
        }

        return redirect()->back()->with('success', 'Taarifa za majukumu zimehifadhiwa kikamilifu!');
    }
}