<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ToggleButton extends Component
{
    public $enabled;
    public $gift;

    public function mount()
    {
        $this->enabled = (bool) $this->enabled;
    }

    public function render()
    {
        return view('livewire.toggle-button');
    }
}
