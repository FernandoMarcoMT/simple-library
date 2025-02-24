<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'phone_number',
        'password',
        'role'
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

    public static function generateUserName() {
        $lastUser = User::where('username', 'like', 'user-%')
                ->orderBy('username', 'desc')
                ->first();

        if (!$lastUser) {
            return 'user-001';
        }
        // karyawan-001
        $lastUsername = $lastUser->username;
        $number = intval(substr($lastUsername, 5)) + 1;
        return 'user-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public static function generatePassword()
    {
        return Hash::make('test123');
    }


    public function books(): BelongsToMany 
    {
        return $this->belongsToMany(\App\Models\Book::class);
    }

}
