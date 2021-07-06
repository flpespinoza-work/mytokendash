<div>
    <div class="flex flex-col w-full pb-10">
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

        <div class="grid grid-cols-4 gap-2 mt-6">
            @forelse ($groups as $group)
                <div class="col-span-4 p-3 bg-white border border-gray-100 rounded-md md:col-span-2 xl:col-span-1">
                    <div class="flex flex-col space-x-2">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full">
                            <x-heroicon-s-office-building class="w-3.5 h-3.5 text-gray-600"/>
                        </div>
                        <div class="flex-1 mt-2">
                            <h5 class="text-sm font-semibold md:text-base">{{ $group->name}}</h5>
                            <p class="flex items-center mt-4 text-xs text-gray-700">
                                <x-heroicon-s-user class="w-3 h-3 mr-2"/>
                                <span class="font-medium text-gray">{{ $group->contact_name }}</span>
                            </p>
                            <p class="flex items-center mt-1 text-xs text-gray-600">
                                <x-heroicon-s-phone class="w-3 h-3 mr-2"/>
                                <span class="font-medium text-gray">{{ $group->contact_phone }}</span>
                            </p>
                            <p class="flex items-center mt-1 text-xs text-gray-600">
                                <x-heroicon-s-mail class="w-3 h-3 mr-2"/>
                                <span class="font-medium text-gray">{{ $group->contact_email }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @empty

            @endforelse
        </div>

        <div class="flex flex-col mt-10">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border border-gray-200 rounded-sm shadow">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <x-table.heading value="Nombre"/>
                        <x-table.heading value="Contacto" class="hidden md:table-cell"/>
                        <x-table.heading value="Teléfono" class="hidden md:table-cell"/>
                        <x-table.heading value="Correo electrónico" class="hidden md:table-cell"/>
                        <x-table.heading/>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      @forelse ($groups as $group)
                      <tr class="text-sm">
                        <x-table.cell>{{ $group->name }}</x-table.cell>
                        <x-table.cell class="hidden md:table-cell">{{ $group->contact_name }}</x-table.cell>
                        <x-table.cell class="hidden md:table-cell">{{ $group->contact_phone }}</x-table.cell>
                        <x-table.cell class="hidden md:table-cell">{{ $group->contact_email }}</x-table.cell>
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

