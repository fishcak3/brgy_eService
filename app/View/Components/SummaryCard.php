<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SummaryCard extends Component
{
    public $title;
    public $value;
    public $icon;
    public $color;

    public function __construct($title = '', $value = 0, $icon = 'heroicon-o-document', $color = 'blue')
    {
        $this->title = $title;
        $this->value = $value;
        $this->icon = $icon;
        $this->color = $color;
    }

    public function render()
    {
        return view('components.summary-card');
    }
}
