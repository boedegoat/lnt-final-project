<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ImageInput extends Component
{
    public $mode;
    public $item;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($mode = 'create', $item = null)
    {
        $this->mode = $mode;
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.image-input');
    }
}
