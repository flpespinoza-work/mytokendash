
<div>
    <div class="flex flex-col w-full pb-10 space-y-4">
        <div class="flex items-center">
            <div class="w-full mr-2">
                <x-search-filters/>
            </div>
            <a href="{{ route('users.create') }}" class="flex items-center flex-shrink-0 p-2 ml-auto text-xs font-bold leading-tight tracking-wide rounded-md bg-blue md:p-3 text-blue-lighter" >
                <x-heroicon-s-plus-circle class="w-4 h-4 md:w-5 md:h-5 md:mr-2"/>
                <span class="hidden md:inline-block">
                    Nuevo role
                </span>
            </a>
        </div>

        <div class="flex flex-col mt-10">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white border rounded-sm">
                  <table class="min-w-full divide-y divide-gray-light">
                    <thead>
                      <tr>
                        <x-table.heading value="Nombre"/>
                        <x-table.heading value="Permisos" class="hidden md:table-cell"/>
                        <x-table.heading />
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-light">
                      @forelse($roles as $role)
                      <tr class="hover:bg-gray-lightest">
                        <x-table.cell>
                            <span class="inline-flex font-semibold leading-5 capitalize text-xxs text-gray">{{ $role->name }}</span>
                        </x-table.cell>
                        <x-table.cell class="hidden md:table-cell">
                            @forelse($role->permissions as $key => $permission)
                                <span class="inline-flex px-1 font-semibold leading-5 rounded-full text-xxs text-orange-darker bg-orange-lightest">{{ $permission->description }}</span>
                            @empty
                                <span class="inline-flex font-semibold leading-5 text-xxs text-gray">Sin permisos asignados</span>
                            @endforelse
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex items-center justify-end space-x-2 lg:space-x-4">
                                <a href="#" class="text-gray-400 hover:text-gray-dark">
                                    <x-heroicon-s-eye class="w-5 h-5" />
                                </a>
                                <a href="#" class="text-gray-400 hover:text-gray-dark">
                                    <x-heroicon-s-pencil-alt class="w-5 h-5" />
                                </a>
                                <a href="#" wire:click="delete({{$role->id}})" class="text-gray-400 hover:text-red">
                                    <x-heroicon-s-trash class="w-5 h-5" />
                                </a>
                            </div>
                        </x-table.cell>
                      </tr>
                      @empty
                      <tr>
                        <td class="px-6 py-4 whitespace-nowrap" colspan="5">
                          <div class="flex items-center justify-center">
                              <span class="py-6 text-base text-gray">No hay roles registrados</span>
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
            {!! $roles->links() !!}
          </div>
    </div>
</div>
