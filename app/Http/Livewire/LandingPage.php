<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class LandingPage extends Component
{
    public string $email = '';

    public function subscribe()
    {
        Log::debug($this->email);
    }

    public function render()
    {
        return view('livewire.landing-page');
    }
}
