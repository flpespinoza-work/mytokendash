<?php

namespace App\Http\Livewire\Group;

use Livewire\Component;
use App\Models\Group;
use App\Models\Store;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    public Group $group;
    public $stores;

    public function mount(Group $group)
    {
        $this->group = $group;
        $this->stores = $this->group->stores;
    }

    public function render()
    {
        return view('livewire.group.show');
    }
}
