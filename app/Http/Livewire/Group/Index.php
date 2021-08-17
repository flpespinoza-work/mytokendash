<?php

namespace App\Http\Livewire\Group;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Group;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['groupAdded'];


    protected $queryString = [
        'search' => [
            'except' => '',
        ]
    ];

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    public function render()
    {
        $groups = Group::search($this->search)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage);

        return view('livewire.group.index', compact('groups'));
    }

    public function groupAdded($group)
    {
        Group::create($group);
    }
}
