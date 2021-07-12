<?php

namespace App\Http\Livewire\Reports\Users;

use Asantibanez\LivewireCharts\Models\AreaChartModel;
use App\Traits\Reports\Users;
use Livewire\Component;

class NewUsers extends Component
{
    use Users;
    public function render()
    {
        $users = $this->getUsers();
        $userList = collect($users['USUARIOS']);

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

        return view('livewire.reports.users.new-users')->with(['users' => $users, 'areaChartModel' => $areaChartModel]);
    }
}
