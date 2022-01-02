<?php

namespace App\Http\Livewire;

use App\Models\Subscriber;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class LandingPage extends Component
{
    public string $email = '';
    public bool $showSubscribeModal = false;
    public bool $showSuccess = false;
    protected array $rules = [
        'email' => 'required|email:filter|unique:subscribers,email',
    ];

    public function mount(Request $request)
    {
        if ($request->verified) {
            $this->showSuccess = true;
        }
    }

    public function subscribe()
    {
        $this->validate();
        DB::transaction(function () {
            $subscriber = Subscriber::create(['email' => $this->email]);
            $notification = new VerifyEmail;
            $notification->createUrlUsing(function ($notifiable) {
                return URL::temporarySignedRoute(
                    'subscriber.verify',
                    Carbon::now()->addMinutes(Config::get('auth.verification.expire', 30)),
                    ['subscriber' => $notifiable->getKey()]
                );
            });
            $subscriber->notify($notification);
        }, $deadlockRegistries = 5);
        $this->reset('email');
        $this->showSubscribeModal = false;
        $this->showSuccess = true;
    }

    public function render()
    {
        return view('livewire.landing-page');
    }
}
