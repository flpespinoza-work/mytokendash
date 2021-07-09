<?php

namespace App\Http\Livewire\Scores;

use App\Traits\Scores;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Index extends Component
{
    use Scores;

    public function render()
    {
        $scores = $this->getScores();

        $columnChartModel = (new ColumnChartModel())
            ->setTitle('Calificaciones')
            ->addColumn('5', $scores['stars_5'], '#f6ad55')
            ->addColumn('4', $scores['stars_4'], '#fc8181')
            ->addColumn('3', $scores['stars_3'], '#90cdf4')
            ->addColumn('2', $scores['stars_2'], '#90cdf4')
            ->addColumn('1', $scores['stars_1'], '#90cdf4')
        ;


        return view('livewire.scores.index')->with(['scores' => $scores, 'columnChartModel' => $columnChartModel]);
    }
}
