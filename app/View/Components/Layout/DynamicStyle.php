<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;

class DynamicStyle extends Component
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
        return view('components.layout.dynamic-style', ['user' => $this->user]);
    }
}
