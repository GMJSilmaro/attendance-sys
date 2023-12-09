<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use App\Models\User;

class Welcome extends Component
{
    public $user; // Declare the $user variable

    public function render()
    {
        return view('livewire.welcome');
    }

    // Controller or route where you render the Livewire component
    public function showWelcomePage()
    {
        $user = User::find(1); // Replace this with your logic to retrieve the user

        return view('welcome', compact('user'));
    }

    public function redirectToLogin()
    {
        return Redirect::to('/login');
    }

    public function redirectToAdmin()
    {
        return Redirect::to('/admin');
    }


}
