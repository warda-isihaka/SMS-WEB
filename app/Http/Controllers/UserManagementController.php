<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    public function store(Request $request)
    {
        return $this->update($request);
    }

    // 1. Onyesha ukurasa na uvute watumiaji pamoja na role zao za active event
    public function index()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $eventId = session('active_event_id');

        // Fetch users along with their assigned role for the currently active event
        $users = User::all()->map(function ($user) use ($eventId) {
            $eventRole = DB::table('event_user')
                ->where('event_id', $eventId)
                ->where('user_id', $user->id)
                ->value('role_id');

            // Fallback to default user role_id if no event-specific role exists
            $user->role_id = $eventRole ?? $user->role_id;
            return $user;
        });

        return view('user-management', compact('users'));
    }

    // 2. Hifadhi au sasisha role ya mtumiaji kwa ACTIVE EVENT pekee
    public function update(Request $request)
    {
        $rolesData = $request->input('roles', []);
        $eventId = session('active_event_id');

        // Automatically retrieve or create the roles in the database
        $accountantRole = Role::firstOrCreate(['name' => 'accountant']);
        $committeeRole  = Role::firstOrCreate(['name' => 'committee']);
        $adminRole      = Role::firstOrCreate(['name' => 'admin']);

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
                $roleId = $roleMap[$key];

                // Update or insert into event_user pivot table for the active event
                DB::table('event_user')->updateOrInsert(
                    [
                        'event_id' => $eventId,
                        'user_id'  => $userId,
                    ],
                    [
                        'role_id'    => $roleId,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Taarifa za majukumu zimehifadhiwa kikamilifu!');
    }
}