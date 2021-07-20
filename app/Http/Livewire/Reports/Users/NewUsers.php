<?php

namespace App\Http\Livewire\Reports\Users;

use Asantibanez\LivewireCharts\Models\AreaChartModel;
use App\Traits\Reports\Users;
use Livewire\Component;
use App\Models\Store;

class NewUsers extends Component
{
    use Users;

    public $users;
    public $areaChartModel;
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
        /*$users = $this->getUsers();
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

        );*/

        return view('livewire.reports.users.new-users')->with(['users' => $this->users, 'areaChartModel' => $this->areaChartModel]);
    }

    public function generateReport()
    {
        $this->users = $this->getUsers($this->store, $this->initialDate, $this->finalDate);
        /*$userList = collect($this->users['USUARIOS']);

        $this->areaChartModel = $userList->reduce(function (AreaChartModel $areaChartModel, $data, $key) use($userList) {
            $user = $userList[$key];

            return $areaChartModel->addPoint($user['DIA'], $user['USUARIOS']);
        }, (new AreaChartModel())
            ->setTitle('Nuevos usuarios')
            ->setAnimated(true)
            ->setSmoothCurve()
            ->withGrid()
            ->setXAxisVisible(true)
            ->setColor('#FFA35E')

        );*/

        //dd($this->areaChartModel);
    }
}
