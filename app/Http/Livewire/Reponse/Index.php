<?php
/**
 * Revisar Cache::remember
 * Cache::put, Cache::add
 */
namespace App\Http\Livewire\Reponse;

use Livewire\Component;
use App\Models\Response;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $response = '';
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

    public function render()
    {
        $responses = Response::paginate($this->perPage);
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

            $this->reset();
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            dd($e);
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
