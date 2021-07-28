<?php

namespace App\Http\Livewire\Scores;

use App\Traits\Scores;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use App\Models\Store;

class Index extends Component
{
    use Scores;

    public $scores;
    public $stores;
    public $store;
    public $period;
    public $initialDate;
    public $finalDate;

    public function mount()
    {
        $this->stores = Store::orderBy('name')->pluck('name', 'id')->toArray();
    }

    public function render()
    {
        if(isset($this->scores['comments']))
        {
            $columnChartModel = (new ColumnChartModel())
                ->setTitle('Calificaciones')
                ->addColumn('5', $this->scores['stars_5'], '#f6ad55')
                ->addColumn('4', $this->scores['stars_4'], '#fc8181')
                ->addColumn('3', $this->scores['stars_3'], '#90cdf4')
                ->addColumn('2', $this->scores['stars_2'], '#90cdf4')
                ->addColumn('1', $this->scores['stars_1'], '#90cdf4')
            ;


            return view('livewire.scores.index')->with(['columnChartModel' => $columnChartModel]);
        }

        return view('livewire.scores.index');
    }

    public function getScoreList()
    {
        $this->scores = $this->getScores($this->store, $this->initialDate, $this->finalDate, $this->period);
    }
}
