<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            
            return (new MailMessage)
                ->from('example@example.com', 'Example')
                ->subject('تأكيد البريد الالكتروني')
                ->line('Click the button below to verify your email address.')
                ->action('تأكيد البريد الالكتروني', $url);
        });

        $this->registerPolicies();

        Passport::routes();
    }
}
