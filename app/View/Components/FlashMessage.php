<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FlashMessage extends Component
{
    public $type;
    public $message;
    /**
     * Create a new component instance.
     */
    public function __construct($type = 'success', $message = null)
    {
        $this->type = $type;
        $this->message = $message ?? session($type);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.flash-message');
    }
}
