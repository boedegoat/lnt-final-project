<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PageTitle extends Component
{
    public $backHref;

    public function __construct($backHref = null)
    {
        $this->backHref = $backHref;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.page-title');
    }
}
