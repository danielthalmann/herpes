<?php
namespace Danielthalmann\AuthUi\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name = 'input',
        public string $value = '',
        public string $label = 'label',
        public string $required = 'false',
        public string $type = 'text'
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('authui::components.input');
    }
}
