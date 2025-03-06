<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'alamat',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Get user profiles
     *
     * @return ... db row? Whatever it's type is
     */
    public function profile()
    {
        return match ($this->role) {
            'juleha' => $this->belongsTo(
                Juleha::class, 'user_id'),

            'peternak' => $this->belongsTo(
                Peternak::class, 'user_id'),

            'penyelia' => $this->belongsTo(
                Penyelia::class, 'user_id'),

            'admin_rph' => $this->belongsTo(
                AdminRph::class, 'user_id'),

            'super_admin' => $this->belongsTo(
                SuperAdmin::class, 'user_id'),

            'lapak' => $this->belongsTo(
                lapak::class, 'user_id'),

            default => null,
        };
    }
}
