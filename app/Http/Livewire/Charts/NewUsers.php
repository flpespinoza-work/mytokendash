<?php

namespace App\Http\Livewire\Charts;

use Asantibanez\LivewireCharts\Models\AreaChartModel;
use Livewire\Component;

class NewUsers extends Component
{
    public $users = null;

    public function mount($users)
    {
        $this->users = $users;
    }

    public function render()
    {
        $userList = collect($this->users['USUARIOS']);
        $areaChartModel = $userList->reduce(function (AreaChartModel $areaChartModel, $data, $key) use($userList) {
            $user = $userList[$key];

            return $areaChartModel->addPoint($user['DIA'], $user['USUARIOS']);
        }, (new AreaChartModel())
            ->setTitle('Nuevos usuarios')
            ->setAnimated(true)
            ->setSmoothCurve()
            ->withGrid()
            ->setXAxisVisible(true)
            ->setColor('#FFA35E')

        );


        return view('livewire.charts.new-users')->with(['areaChartModel' => $areaChartModel]);
    }
}
