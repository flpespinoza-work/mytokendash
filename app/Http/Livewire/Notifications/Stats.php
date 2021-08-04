<?php

namespace App\Http\Livewire\Notifications;

use Livewire\Component;
use App\Traits\Notifications;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Stats extends Component
{
    use Notifications;

    public $campaign;
    public $stats;

    public function mount($campaign)
    {
        $this->campaign = $campaign;
    }


    public function render()
    {
        $this->getStats();

        $columnChartModel = (new ColumnChartModel())
        ->setTitle('Estatus')
        ->addColumn('Leidos', $this->stats['LEIDAS'], '#21D134')
        ->addColumn('No leidos', $this->stats['NO_LEIDAS'], '#E4E41B')
        ->addColumn('Eliminados', $this->stats['ELIMINADAS'], '#E4761B');

        $columnChartModelDispositivo = (new ColumnChartModel())
        ->setTitle('Dispositivos')
        ->addColumn('Android', $this->stats['CAMP_ANDROID'], '#51D121')
        ->addColumn('iOS', $this->stats['CAMP_IOS'], '#219CD1');
    ;


        return view('livewire.notifications.stats', ['columnChartModel' => $columnChartModel, 'columnChartModelDispositivo' => $columnChartModelDispositivo]);
    }

    public function getStats()
    {
        $this->stats = collect($this->getCampaignStats($this->campaign));
    }
}
