<div>
    <div class="flex flex-col w-full pb-10">
        <div class="flex items-center">
            <div class="w-2/4 mx-1 md:w-1/4">
                <input wire:model.debounce.300ms="search" type="text"
                class="block w-full px-4 py-3 leading-tight text-gray-700 bg-white border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-300"
                placeholder="Buscar usuarios...">
            </div>
            <a class="px-2 py-3 ml-auto text-xs font-bold tracking-wide bg-blue-600 rounded-md shadow text-blue-50" href="{{ route('users.create') }}">Nuevo usuario</a>
        </div>
        <div class="flex flex-col mt-6">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                          Nombre
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                          Rol
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                          Estatus
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                          Grupo
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      @forelse ($users as $user)
                      <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex items-center">
                            <div class="ml-4">
                              <div class="text-sm font-medium text-gray-900">
                                {{ $user->name }}
                              </div>
                              <div class="text-gray-500 text-xxs">
                                {{ $user->email }}
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @foreach($user->roles as $key => $role)
                                <span class="inline-flex px-2 font-semibold leading-5 text-blue-800 bg-blue-100 rounded-full text-xxs">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(Cache::has('user-online-'. $user->id ))
                                <span class="inline-flex px-2 font-semibold leading-5 text-green-800 bg-green-100 rounded-full text-xxs">
                                    Online
                                </span>
                            @else
                                <span class="inline-flex px-2 font-semibold leading-5 text-red-800 bg-red-100 rounded-full text-xxs">
                                    Offline
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                          Admin
                        </td>
                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                          <a href="{{ route('users.edit', $user->id) }}" class="text-gray-600 hover:text-gray-900">Editar</a>
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td class="px-6 py-4 whitespace-nowrap" colspan="5">
                          <div class="flex items-center justify-center">
                              <span class="py-6 text-base text-gray-400">No hay usuarios registrados</span>
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
        {!! $users->links() !!}
    </div>

</div>
