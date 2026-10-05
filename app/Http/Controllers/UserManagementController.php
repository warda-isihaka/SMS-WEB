<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    public function index()
    {
        $eventId = session('active_event_id');

        // Retrieve all users
        $users = User::all();

        // Get roles assigned to users for the current active event
        $userRoles = [];
        if ($eventId) {
            $userRoles = DB::table('event_user')
                ->where('event_id', $eventId)
                ->pluck('role_id', 'user_id')
                ->toArray();
        }

        $roles = Role::all();

        return view('user-management', compact('users', 'userRoles', 'roles'));
    }
    
    public function store(Request $request)
    {
        return $this->update($request);
    }

    // 1. Onyesha ukurasa na uvute watumiaji pamoja na role zao za active event
  
    // 2. Hifadhi au sasisha role ya mtumiaji kwa ACTIVE EVENT pekee
    public function update(Request $request)
    {
        $rolesData = $request->input('roles', []);
        $eventId = session('active_event_id');

        if (!$eventId) {
            return redirect()->back()->with('error', 'Tafadhali chagua event kwanza.');
        }
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
if ($roleId === null) {
                    // Remove role for this event if 'none' is selected
                    DB::table('event_user')
                        ->where('event_id', $eventId)
                        ->where('user_id', $userId)
                        ->delete();
                } else {
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
                // Update or insert into event_user pivot table for the active event
            }
        }

        return redirect()->back()->with('success', 'Taarifa za majukumu zimehifadhiwa kikamilifu!');
    }
}