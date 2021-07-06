<?php

namespace App\Http\Livewire\Scores;

use App\Traits\Scores;
use Livewire\Component;

class Index extends Component
{
    use Scores;

    public function render()
    {
        $scores = $this->getScores();
        return view('livewire.scores.index', compact('scores'));
    }
}
