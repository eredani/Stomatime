<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CabinetResetPasswordNotification;
class Cabinet extends Authenticatable
{
    use Notifiable;
    protected $guard = 'cabinet';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','email_token','judet'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email_token','verified','type'
    ];
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CabinetResetPasswordNotification($token));
    }
}