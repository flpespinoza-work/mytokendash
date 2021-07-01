<div class="sm:max-w-2xl">
    <div class="flex flex-col p3">
        <label class="text-xs font-normal text-gray-500 md:text-sm" for="response">Ingresa el texto para la respuesta</label>
        <textarea name="response"
        maxlength="120"
        class="w-full h-24 mt-3 text-xs border border-gray-200 rounded-md shadow-sm resize-none md:text-sm p2 focus:ring-2 focus:ring-orange-light focus:border-orange-lightest"
        wire:model.debounce.1000ms='response'></textarea>
        <x-forms.button wire:click="saveResponse" class="w-full mt-3 ml-auto md:w-auto" type="button">Guardar respuesta</x-forms-button>
    </div>
    <div class="p-2 mt-4 bg-white">
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
                            {{ $response->response}}
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex items-center justify-end space-x-2 lg:space-x-4">
                                <a href="#" class="text-gray-400 hover:text-gray-dark">
                                    <x-heroicon-s-pencil-alt class="w-5 h-5" />
                                </a>
                                <a href="#" class="text-gray-400 hover:text-red">
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
    </div>
    <x-modal/>
</div>
