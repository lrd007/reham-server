<?php

namespace Modules\User\Entities;

use App\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Modules\Payment\Entities\Payment;
use Modules\Subscriber\Entities\Subscriber;
use Laravel\Sanctum\HasApiTokens;
use Modules\NotificationCenter\Entities\Notification;
use Modules\NotificationCenter\Entities\NotificationUser;
use LamaLama\Wishlist\HasWishlists;
use Asciisd\Knet\HasKnet;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable, SoftDeletes;
    use HasWishlists;

    protected $fillable = ['email', 'password', 'name'];
    protected $hidden = ['password', 'remember_token'];

    public static function registered($email)
    {
        return static::where('email', $email)->exists();
    }

    public static function registeredAsAdmin($email)
    {
        return static::where('email', $email)->where('is_admin', true)->exists();
    }

    public static function findByEmail($email)
    {
        return static::where('email', $email)->first();
    }

    public function isAdmin()
    {
        return $this->is_admin ?? false;
    }

    public function setIPAddress()
    {
        $this->ip_address = request()->ip();
        $this->save();
    }

    public function setLastLogin()
    {
        $this->last_login = Carbon::now();
        $this->save();
        $this->setIPAddress();
    }

    public function isOnline()
    {
        return false;
    }

    public function status()
    {
        $status = '<span><small class="mdi mdi-circle text-danger"></small> Offline</span>';
        if ($this->isOnline()) {
            $status = '<span><small class="mdi mdi-circle text-success"></small> Online</span>';
        }
        return $status;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentDetails()
    {
        return $this->hasMany(Payment::class, 'subscriber_id', 'id');
    }

    public function subscriber()
    {
        return $this->hasOne(Subscriber::class);
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, NotificationUser::class, 'user_id', 'notification_id')->latest();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token, $this->email));
    }
}
