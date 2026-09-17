<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;
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

    /**
     * Relationship: A User belongs to a Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

   
     public function canViewBudget(): bool
{
    return $this->role && in_array(strtolower($this->role->name), ['admin', 'accountant', 'committee']);
}
    /**
     * Relationship: User's pledge
     */
    public function pledge()
    {
        return $this->hasOne(Pledge::class);
    }

    /**
     * Helper: Check if user has 'admin' role dynamically by role name
     */
    public function isAdmin(): bool
    {
        return $this->role && strtolower($this->role->name) === 'admin';
    }

    /**
     * Helper: Check if user has 'accountant' role dynamically by role name
     */
    public function isAccountant(): bool
    {
        return $this->role && strtolower($this->role->name) === 'accountant';
    }

    /**
     * Helper: Check if user has 'committee' role dynamically by role name
     */
    public function isCommittee(): bool
    {
        return $this->role && strtolower($this->role->name) === 'committee';
    }

   
}