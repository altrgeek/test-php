<?php

namespace App\View\Components\Dashboard\Cards;

use Illuminate\View\Component;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileAvatar extends Component
{
    private User|null $user = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->user = $request->user();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {


        return view('components.dashboard.cards.profile-avatar', [
            'avatar' => $this->user?->avatar,
            'name'   => $this->user?->name,
            'email'  => $this->user?->email,
        ]);
    }
}
