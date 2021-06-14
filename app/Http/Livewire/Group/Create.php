<?php

namespace App\Http\Livewire\Group;
use Livewire\Component;
use App\Models\Group;

class Create extends Component
{
    public Group $group;

    protected function rules() {
        return [
            'group.name' => 'required|unique:groups,name',
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
    }

    public function render()
    {
        return view('livewire.group.create');
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

        }
    }

    public function updatedGroupName()
    {
        $this->validateOnly('group.name');
    }
}
