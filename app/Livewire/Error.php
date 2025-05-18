<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Error extends Component
{
    public $error = null;

    public function render()
    {
        return view('livewire.error');
    }

    #[On('error')]
    public function error($error)
    {
        $this->error = $error;
    }
}
