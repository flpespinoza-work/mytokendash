<?php

namespace App\Http\Livewire\Reponse;

use Livewire\Component;
use App\Models\Response;

class Index extends Component
{
    public $response = '';
    public $responses = [];
    public $deletingResponse = false;

    protected function rules() {
        return [
            'response' => 'required|max:120'
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
        $this->responses = Response::all();
        return view('livewire.reponse.index');
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
    }

}
