<?php
namespace Danielthalmann\AuthUi\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name = 'button',
        public string $type = 'button',
        public string $aspect = 'normal',
        public string $href = '#'
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('authui::components.button');
    }
}
