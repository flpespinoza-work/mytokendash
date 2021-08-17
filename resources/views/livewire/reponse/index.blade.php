<div class="sm:max-w-2xl">
    @if(session()->has('success'))
    <x-alert type="success" title="Éxito" message="{{ session('success') }}"/>
    @elseif (session()->has('error'))
    <x-alert type="error" title="Error" message="{{ session('error') }}"/>
    @endif

    <div class="flex flex-col p3">
        <label class="text-xs font-normal text-gray-500 md:text-sm" for="response">Ingresa el texto para la respuesta</label>
        <textarea name="response"
        maxlength="120"
        class="w-full h-24 mt-3 text-xs border border-gray-200 rounded-md shadow-sm resize-none md:text-sm p2 focus:ring-2 focus:ring-orange-light focus:border-orange-lightest"
        wire:model.debounce.1000ms='response'></textarea>
        <x-forms.button wire:click="saveResponse" class="w-full mt-3 ml-auto md:w-auto" type="button">Guardar respuesta</x-forms-button>
    </div>
    <div class="p-2 mt-4 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-light">
                    <thead>
                      <tr>
                        <x-table.heading value="Respuesta"/>
                        <x-table.heading />
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-light">
                      @forelse ($responses as $response)
                      <tr class="cursor-pointer hover:bg-gray-lightest">
                        <x-table.cell>
                            <p class="text-sm">{{ $response->response}}</p>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex items-center justify-end space-x-2 lg:space-x-4">
                                <a href="#" wire:click="confirmResponseDeletion({{$response->id}})" class="text-gray-400 hover:text-red">
                                    <x-heroicon-s-trash class="w-5 h-5" />
                                </a>
                            </div>
                        </x-table.cell>
                      </tr>
                      @empty
                      <tr>
                        <td class="px-6 py-4 whitespace-nowrap" colspan="2">
                          <div class="flex items-center justify-center">
                              <span class="py-6 text-base text-gray">No hay respuestas registradas</span>
                          </div>
                        </td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                  <div>
                        {!! $responses->links() !!}
                </div>
    </div>
    <x-confirm-modal wire:model="deletingResponse" title="Eliminar">
        <x-slot name="icon">
            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </x-slot>
        <x-slot name="content">
            <p class="text-xs text-gray-500 md:text-sm">
                Esta seguro de querer eliminar este registro?
            </p>
        </x-slot>
        <x-slot name="footer">
            <button wire:click="deleteResponse({{ $deletingResponse }})" type="button" class="inline-flex justify-center w-full px-4 py-2 text-xs font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm md:text-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                Eliminar
            </button>
            <button wire:click="$set('deletingResponse', false)" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm md:text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancelar
            </button>
        </x-slot>
    </x-confirm-modal>
</div>
