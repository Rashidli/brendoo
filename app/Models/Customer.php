<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Customer extends Model
{

    use HasFactory, Notifiable, HasRoles, HasApiTokens,LogsActivityTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'is_active',
        'is_blocked',
        'password',
        'phone',
        'gender',
        'email_verification_code',
        'email_verification_token',
        'password_reset_token_expiry',
        'password_reset_token',
        'email_verified_at'
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

    public function basketItems() : HasMany
    {
        return $this->hasMany(BasketItem::class);
    }

    public function orders() : HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function address() : HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function coupons() : BelongsToMany
    {
        return $this->belongsToMany(Coupon::class, 'coupon_customer');
    }

    public function favorites() : HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function fcmTokens() : HasMany
    {
        return $this->hasMany(CustomerFcmToken::class);
    }

    public function order_items() : HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

}
