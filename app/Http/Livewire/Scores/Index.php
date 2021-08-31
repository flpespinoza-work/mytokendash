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
        $this->stores = fn_obtener_establecimientos();
    }

    public function render()
    {
        if(isset($this->scores['comments']))
        {
            $columnChartModel = (new ColumnChartModel())
                ->setTitle('Calificaciones')
                ->setHorizontal(true)
                ->setDataLabelsEnabled(false)
                ->addColumn('😆', $this->scores['stars_5'], '#09D17F')
                ->addColumn('😊', $this->scores['stars_4'], '#A8E485')
                ->addColumn('😐', $this->scores['stars_3'], '#F7DA38')
                ->addColumn('😠', $this->scores['stars_2'], '#F7A038')
                ->addColumn('🤬', $this->scores['stars_1'], '#F54924')
            ;

            $columnChartModelScore = (new ColumnChartModel())
                ->setTitle('Calificaciones - Comentarios')
                ->setDataLabelsEnabled(false)
                ->addColumn('Califico', $this->scores['totalScores'], '#09D17F')
                ->addColumn('No califico, pero comentó', $this->scores['stars_N'], '#F7DA38');


            return view('livewire.scores.index')->with(['columnChartModel' => $columnChartModel, 'columnChartModelScore' => $columnChartModelScore]);
        }

        return view('livewire.scores.index');
    }

    public function getScoreList()
    {
        $this->scores = $this->getScores($this->store, $this->initialDate, $this->finalDate, $this->period);
    }
}
