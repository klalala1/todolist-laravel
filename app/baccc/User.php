<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cookie;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Events\Registered;
use App\Providers\AuthServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\InvoicePaid;



class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function __construct()
    {
    }

    protected $guarded = [];

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
    ];
    public function createUser(Request $request)
    {

        $this->username = $request->user['username'];
        $this->email = $request->user['email'];
        $this->password = $request->user['password'];
        $this->created_at =  Carbon::now();

        $this->save();
        User::create($request->getAttributes())->sendEmailVerificationNotification();


        return  $this;
    }
    public function toMail($notifiable)
    {
        $url = url('/invoice/' . $this->invoice->id);

        return (new MailMessage)
            ->greeting('Hello!')
            ->line('One of your invoices has been paid!')
            ->action('View Invoice', $url)
            ->line('Thank you for using our application!');
    }
    // public function via($notifiable)
    // {
    //     return $notifiable->prefers_sms ? ['nexmo'] : ['mail', 'database'];
    // }
    public function sendTest()
    {
        $this->notify((new MailMessage)
            ->greeting('Hello!')
            ->line('One of your invoices has been paid!')
            ->line('Thank you for using our application!'));
    }
}
