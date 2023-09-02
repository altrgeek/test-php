<?php

namespace App\View\Components\Layout;

use App\Models\Roles\Client;
use Illuminate\View\Component;
use App\Models\User;

class Navbar extends Component
{
    public  $user;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout.navbar', ['user' => $this->user]);
    }
}
