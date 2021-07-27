<?php

namespace App\Http\Livewire\Notifications;

use Livewire\Component;
use App\Models\Store;
use App\Traits\Notifications;
class Index extends Component
{
    use Notifications;

    public $stores;
    /*public $store;
    public $type;
    public $name;
    public $title;
    public $body;
    public $gender;
    public $inactive;
    public $coupon;*/
    public $campaigns;

    public $campaign = [
        'store' => '',
        'name' => '',
        'type' => '',
        'title' => '',
        'body' => '',
        'gender' => '',
        'inactive' => '',
        'coupon' => ''
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
