<?php

namespace App\Http\Livewire\Group;

use Livewire\Component;
use App\Models\Store as StoreModel;
use App\Models\Group;
use App\Models\Municipality;
use App\Models\State;

class Store extends Component
{
    public Group $group;
    public StoreModel $store;

    public $states;
    public $state;
    public $municipalities = [];

    protected function rules() {
        return [
            'store.name' => 'required|unique:stores,name',
            'store.tokencash_node' => 'required|unique:stores,tokencash_node',
            'store.tokencash_account' => 'required|unique:stores,tokencash_account',
            'store.business_name' => 'required',
            'store.municipality_id' => 'nullable|numeric',
            'store.street' => 'nullable|string',
            'store.postal_code' => 'nullable|digits:5',
            'store.contact_name' => 'nullable|string',
            'store.contact_phone' => 'nullable|digits:10'
        ];
    }

    protected $messages = [
        'store.name.required' => 'El nombre del establecimiento es requerido',
        'store.name.unique' => 'El establecimiento ya existe',
        'store.contact_phone.digits' => 'El campo solo puede contener 10 números',
        'store.tokencash_node.unique' => 'Este nodo ya se registro en otro establecimiento',
        'store.tokencash_node.unique' => 'Esta cuenta ya se registro en otro establecimiento',
        'store.business_name.required' => 'La razón social es requerida'
    ];


    public function mount(Group $group)
    {
        $this->group = $group;
        $this->states = State::all()->pluck('name', 'id');
        $this->store = new StoreModel();
    }

    public function submit()
    {
        try
        {
            $this->validate();
            $this->store->group_id = $this->group->id;
            $this->store->save();
            return redirect()->route('groups.edit', $this->group);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            dd($e);
        }
    }

    public function render()
    {
        return view('livewire.group.store');
    }

    public function chargeMunicipalities()
    {
        if($this->state)
        {
            $this->municipalities = Municipality::where('state_id', $this->state)->pluck('name', 'id');
        }
        else {
            $this->municipalities = [];
        }
    }

    public function updatedTokencashNodo()
    {
        $this->validateOnly('store.tokencash_nodo');
    }
}
