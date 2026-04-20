<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
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
        'email',
        'nisn',
        'role',
        'password',
        'phone',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'nisn',
        'role', // Hapus 'role' dari sini jika perlu diakses di controller
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
            'last_login_at' => 'datetime',
            'nisn' => 'string',
            'role' => 'string', // Pertimbangkan enum jika role terbatas
        ];
    }

    public $timestamps = true;

    // Method untuk cek role
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    // Method untuk cek multiple roles
    public function hasAnyRole(array $roles)
    {
        return in_array($this->role, $roles);
    }

    public function isSiswa()
    {
        return $this->role === 'siswa';
    }

    public function isGuru()
    {
        return $this->role === 'petugas';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}