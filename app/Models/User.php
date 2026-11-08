<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
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
        'is_permanent',
        'discount_tier',
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
        'is_permanent' => 'boolean',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservasi::class, 'user_id');
    }

    public function updateDiscountTier()
    {
        $completedReservations = $this->reservations()
            ->whereIn('status', ['Diterima'])
            ->count();

        $newTier = 0;

        if ($completedReservations >= 90) {
            $newTier = 7; // 35% discount
        } elseif ($completedReservations >= 70) {
            $newTier = 6; // 30% discount
        } elseif ($completedReservations >= 50) {
            $newTier = 5; // 25% discount
        } elseif ($completedReservations >= 30) {
            $newTier = 4; // 20% discount
        } elseif ($completedReservations >= 20) {
            $newTier = 3; // 15% discount
        } elseif ($completedReservations >= 10) {
            $newTier = 2; // 10% discount
        } elseif ($completedReservations >= 5) {
            $newTier = 1; // 5% discount
        }

        $this->discount_tier = $newTier;
        $this->is_permanent = $completedReservations >= 3;
        $this->save();

        return $newTier;
    }

    public function getDiscountPercentage()
    {
        return $this->discount_tier * 5; // Each tier = 5% discount
    }
}
