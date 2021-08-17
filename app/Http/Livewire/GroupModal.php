<?php

namespace App\Http\Livewire;
use App\Http\Livewire\Modal;

class GroupModal extends Modal
{
    public $group;

    protected function rules() {
        return [
            'group.name' => 'required|unique:groups,name',
            'group.contact_name' => 'nullable|string',
            'group.contact_phone' => 'nullable|digits:10',
            'group.contact_email' => 'nullable|email:rfc'
        ];
    }

    protected $messages = [
        'group.name.required' => 'El nombre del grupo es requerido',
        'group.name.unique' => 'El grupo ya existe',
        'group.contact_phone.digits' => 'El campo solo puede contener 10 números'
    ];

    public function render()
    {
        return view('livewire.group-modal');
    }

    public function submit()
    {
        $this->validate();
        $this->emitTo('group.index', 'groupAdded', $this->group);
        $this->reset();
        $this->show = false;
    }
}
