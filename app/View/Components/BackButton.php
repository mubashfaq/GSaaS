<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BackButton extends Component
{
    public $route;

    public function __construct($route = null)
    {
        $this->route = $route ?: url()->previous(); // Default to the previous URL if not provided
    }

    public function render()
    {
        return view('components.back-button', [
            'route' => $this->route, // Pass the route to the Blade view
        ]);
    }
}