<?php

namespace App\Http\Livewire\Notifications;

use Livewire\Component;
use App\Models\Store;
use App\Traits\Notifications;
class Index extends Component
{
    use Notifications;

    public $stores;
    public $campaigns;

    public $campaign = [
        'store' => '',
        'name' => '',
        'type' => '',
        'title' => '',
        'body' => '',
        'gender' => '',
        'inactive' => '',
        'coupon' => '',
        'file' => null
    ];

    public function mount()
    {
        $this->stores = Store::orderBy('name')->pluck('name', 'id')->toArray();
        $this->campaigns = $this->getCampaigns();
    }

    public function render()
    {
        return view('livewire.notifications.index');
    }

    public function crearCampana()
    {
        return $this->saveCampaign($this->campaign);
    }
}
