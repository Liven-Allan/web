<?php

namespace App\Models;

use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property string|null $contact
 * @property string $password
 * @property string $status
 * @property string|null $first_name
 * @property string|null $last_name
 */
// class User extends Authenticatable
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'contact',
        'profile_picture',
        'password_changed',
        'about',
        'role',
        'status',
        'first_name',
        'last_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFullNameAttribute(): string
    {
        $first = trim((string) $this->first_name);
        $last = trim((string) $this->last_name);
        if ($first === '' && $last === '') {
            return (string) $this->name;
        }
        return trim($first . ' ' . $last);
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Relation to roles via pivot table. Kept for compatibility.
     * Uses string-based model reference to avoid hard dependency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\\Models\\Role', 'role_user', 'user_id', 'role_id');
    }

    public function sendEmailVerificationNotification()
    {
        $registeredBy = auth()->check() ? auth()->user()->name : 'Admin';
        $this->notify(new CustomVerifyEmail($registeredBy));
    }
}
