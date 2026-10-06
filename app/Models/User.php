<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

public function currentEventRoleName()
    {
        // 1. Check direct role assignment via user's role_id relationship
        if ($this->role_id) {
            $userRole = Role::find($this->role_id);
            if ($userRole) {
                $roleName = strtolower(trim($userRole->name));
                // Checks for 'admin', 'adnib', or any admin variant
                if (in_array($roleName, ['admin', 'adnib', 'system admin'])) {
                    return 'admin';
                }
            }
        }

        $eventId = session('active_event_id');
        if (!$eventId) {
            return null;
        }

        // 2. Check role assigned in event_user table for active event
        $pivot = DB::table('event_user')
            ->where('event_id', $eventId)
            ->where('user_id', $this->id)
            ->first();

        if ($pivot && $pivot->role_id) {
            $role = Role::find($pivot->role_id);
            if ($role) {
                $roleName = strtolower(trim($role->name));
                if (in_array($roleName, ['admin', 'adnib', 'system admin'])) {
                    return 'admin';
                }
                return $roleName;
            }
        }

        return null;
    }

    public function isAdmin(): bool
    {
        return $this->currentEventRoleName() === 'admin';
    }

    public function isAccountant(): bool
    {
        return $this->currentEventRoleName() === 'accountant';
    }

    public function isCommittee(): bool
    {
        return $this->currentEventRoleName() === 'committee';
    }

    public function canViewBudget(): bool
    {
        $role = $this->currentEventRoleName();
        return in_array($role, ['admin', 'accountant', 'committee']);
    }}