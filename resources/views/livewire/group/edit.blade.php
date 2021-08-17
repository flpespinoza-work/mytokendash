<div class="flex flex-col w-full max-w-3xl space-y-8">
    <div>
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-3">
                <div>
                    <h3 class="font-me<dium leading-6 text-gray-900 text-md lg:text-lg">Editar grupo {{ $group->name }}</h3>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-3">
                <form wire:submit.prevent="submit">
                    <div class="overflow-hidden rounded-md shadow">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-4">
                                <div class="col-span-6 sm:col-span-6">
                                    <x-forms.label for="group.name" value="Nombre" />
                                    <x-forms.input wire:model.debounce.1s='group.name' type="text" name="name" id="name"/>
                                    @error('group.name') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-forms.label for="group.contact_name" value="Nombre de contacto" />
                                    <x-forms.input wire:model.defer='group.contact_name' type="text" name="contact_name" id="contact_name" />
                                    @error('group.contact_name') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-forms.label for="group.contact_phone" value="Teléfono de contacto" />
                                    <x-forms.input wire:model.defer='group.contact_phone' maxlength="10" size="10" type="text" name="contact_phone" id="contact_phone" />
                                    @error('group.contact_phone') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                            <x-forms.button>
                                <x-heroicon-s-check class="w-4 h-4 mr-2"/>
                                Guardar
                            </x-forms.button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div>
        <div class="flex items-center">
            <h4 class="text-sm font-medium leading-4 text-gray-800">Establecimientos del grupo</h4>
            <a href="{{ route('groups.store', $group) }}" class="flex items-center p-2 ml-auto text-xs font-bold tracking-wide bg-blue-700 rounded-md shadow md:p-3 text-blue-50" >
                <x-heroicon-s-plus-circle class="w-4 h-4 md:mr-2"/>
                <span class="hidden md:inline-block">
                    Crear establecimiento
                </span>
            </a>
        </div>

        <div class="flex flex-col mt-4">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border border-gray-200 rounded-sm shadow">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="px-3 py-2 text-sm font-medium tracking-wider text-left text-gray-500 capitalize lg:py-3 lg:px-6">
                          Nombre
                        </th>
                        <th scope="col" class="px-3 py-2 text-sm font-medium tracking-wider text-left text-gray-500 capitalize lg:py-3 lg:px-6">
                          Nodo
                        </th>
                        <th scope="col" class="px-3 py-2 text-sm font-medium tracking-wider text-left text-gray-500 capitalize lg:py-3 lg:px-6">
                            Giftcard
                          </th>
                          <th scope="col" class="px-3 py-2 text-sm font-medium tracking-wider text-left text-gray-500 capitalize lg:py-3 lg:px-6">
                            Presupuesto
                          </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      @forelse ($stores as $store)
                      <tr>
                        <td class="px-3 py-2 text-sm lg:px-6 lg:py-3 whitespace-nowrap">
                          {{ $store->name }}
                        </td>
                        <td class="px-3 py-2 text-sm lg:px-6 lg:py-3 whitespace-nowrap">
                          {{ $store->tokencash_node }}
                        </td>
                        <td class="px-3 py-2 text-sm lg:px-6 lg:py-3 whitespace-nowrap">
                            {{ $store->giftcard }}
                          </td>
                          <td class="px-3 py-2 text-sm lg:px-6 lg:py-3 whitespace-nowrap">
                            {{ $store->budget }}
                          </td>
                      </tr>
                      @empty
                      <tr>
                        <td class="px-6 py-4 whitespace-nowrap" colspan="5">
                          <div class="flex items-center justify-center">
                              <span class="py-6 text-base text-gray-400">No hay establecimientos registrados</span>
                          </div>
                        </td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>



