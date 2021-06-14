<?php

namespace App\Http\Livewire\Group;

use Livewire\Component;
use App\Models\Group;
use App\Models\Store;
use Livewire\WithPagination;

class Edit extends Component
{
    use WithPagination;
    public Group $group;
    public $stores;

    protected function rules() {
        return [
            'group.name' => 'required|unique:groups,name,' . $this->group->id,
            'group.contact_name' => 'nullable|string',
            'group.contact_phone' => 'nullable|digits:10'
        ];
    }

    protected $messages = [
        'group.name.required' => 'El nombre del grupo es requerido',
        'group.name.unique' => 'El grupo ya existe',
        'group.contact_phone.digits' => 'El campo solo puede contener 10 números'
    ];

    public function mount(Group $group)
    {
        $this->group = $group;
        $this->stores = $this->group->stores;
    }

    public function render()
    {
        return view('livewire.group.edit');
    }

    public function submit()
    {

        try
        {
            $this->validate();
            $this->group->save();
            return redirect()->route('groups.index');
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            dd($e);
        }
    }
}
