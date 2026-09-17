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
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $users = User::all();
        return view('user-management', compact('users'));
    }

    // 2. Hifadhi au sasisha role moja tu kwa kila mtumiaji kwenye column ya role_id
    public function update(Request $request)
    {
        
        $rolesData = $request->input('roles', []);

     // Automatically retrieve or create the roles in the database
$accountantRole = Role::firstOrCreate(['name' => 'accountant']);
$committeeRole  = Role::firstOrCreate(['name' => 'committee']);
$adminRole = Role::firstOrCreate(['name' => 'admin']);

$roleMap = [
    'admin'      => $adminRole->id,
    'accountant' => $accountantRole->id,
    'committee'  => $committeeRole->id,
    'none'       => null,
];

foreach ($rolesData as $userId => $selectedRole) {
    $user = User::find($userId);
    $key = strtolower(trim($selectedRole));

    if ($user && array_key_exists($key, $roleMap)) {
        $user->role_id = $roleMap[$key];
        $user->save();
    }
}
        return redirect()->back()->with('success', 'Taarifa za majukumu zimehifadhiwa kikamilifu!');
    }
}