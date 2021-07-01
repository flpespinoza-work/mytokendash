<?php

namespace App\Http\Livewire\Reponse;

use Livewire\Component;
use App\Models\Response;
use Livewire\WithPagination;
use PhpParser\Node\Expr\Cast\Object_;

class Index extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $response = '';
    public $deletingResponse = false;

    protected function rules() {
        return [
            'response' => 'required|max:120|unique'
        ];
    }

    protected $messages = [
        'response.required' => 'El mensaje es requerido',
        'response.max' => 'El mensaje no debe sobrepasar los 120 caracteres',
    ];

    private function resetForm()
    {
        $this->response = '';
    }

    public function render()
    {
        $responses = Response::paginate($this->perPage);
        //dd($this->responses);
        return view('livewire.reponse.index', compact('responses'));
    }

    public function saveResponse()
    {
        try
        {
            $this->validate();
            Response::create([
                'response' => $this->response
            ]);

            $this->resetForm();
            session()->flash('success', 'Respuesta creada');
        }
        catch(\Illuminate\Database\QueryException $e)
        {

        }
    }

    public function confirmResponseDeletion($id)
    {
        $this->deletingResponse = $id;
    }

    public function deleteResponse(Response $response)
    {
        $response->delete();
        $this->deletingResponse = false;
        session()->flash('success', 'Registro eliminado');
    }

}
