<?php

namespace App\Http\Controllers;
use App\Models\User; 
use App\Models\Role;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    // Function ya kuonyesha ukurasa na kuvuta users kutoka database
    public function index()
    {
        $users = User::with('roles')->get();
        return view('user-management', compact('users'));
    }

    // Function ya kuhifadhi/usave roles zilizochaguliwa
    public function update(Request $request)
    {
        $rolesData = $request->input('roles', []);
        $allRoles = Role::pluck('id', 'name');
        $allUsers = User::all();

        foreach ($allUsers as $user) {
            $userRoleIds = [];

            if (isset($rolesData[$user->id])) {
                foreach ($rolesData[$user->id] as $roleName => $value) {
                    if (isset($allRoles[$roleName])) {
                        $userRoleIds[] = $allRoles[$roleName];
                    }
                }
            }

            // Sync itahifadhi au kurekebisha roles za user kwenye role_user pivot table
            $user->roles()->sync($userRoleIds);
        }

        return redirect()->back()->with('success', 'Taarifa za majukumu zimehifadhiwa kikamilifu!');
    }

}
