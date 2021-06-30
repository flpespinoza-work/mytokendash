<div>
    <div class="flex flex-col w-full pb-10 space-y-4">
        <div class="flex items-center">
            <div class="w-full mr-2">
                <x-search-filters/>
            </div>
            <a href="{{ route('groups.create') }}" class="flex items-center flex-shrink-0 p-2 ml-auto text-xs font-bold leading-tight tracking-wide bg-blue-700 rounded-md shadow md:p-3 text-blue-50" >
                <x-heroicon-s-plus-circle class="w-4 h-4 md:w-5 md:h-5 md:mr-2"/>
                <span class="hidden md:inline-block">
                    Nuevo grupo
                </span>
            </a>
        </div>
        <div class="flex flex-col mt-10">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border border-gray-200 rounded-sm shadow">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <x-table.heading value="Nombre"/>
                        <x-table.heading value="Contacto"/>
                        <x-table.heading value="Teléfono"/>
                        <x-table.heading value="Correo electrónico"/>
                        <x-table.heading/>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      @forelse ($groups as $group)
                      <tr class="text-sm">
                        <x-table.cell>{{ $group->name }}</x-table.cell>
                        <x-table.cell>{{ $group->contact_name }}</x-table.cell>
                        <x-table.cell>{{ $group->contact_phone }}</x-table.cell>
                        <x-table.cell>{{ $group->contact_email }}</x-table.cell>
                        <x-table.cell class="justify-end space-x-2 lg:space-x-4">
                            <div class="flex items-center justify-end space-x-2 lg:space-x-4">
                                <a href="{{ route('groups.show', $group) }}" class="text-gray-400 hover:text-gray-dark">
                                    <x-heroicon-s-eye class="w-5 h-5" />
                                </a>
                                <a href="{{ route('groups.edit', $group) }}" class="text-gray-400 hover:text-gray-dark">
                                    <x-heroicon-s-pencil-alt class="w-5 h-5" />
                                </a>
                            </div>
                        </x-table.cell>
                      </tr>
                      @empty
                      <tr>
                        <td class="px-6 py-4 whitespace-nowrap" colspan="5">
                          <div class="flex items-center justify-center">
                              <span class="py-6 text-base text-gray-400">No hay grupos registrados</span>
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
        <div>
        {!! $groups->links() !!}
        </div>
    </div>
</div>

