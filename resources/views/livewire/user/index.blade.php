<div>
    <div class="flex flex-col w-full pb-10 space-y-4">
        <div class="flex items-center">
            <div class="w-full mr-2">
                <x-search-filters/>
            </div>
            <a href="{{ route('users.create') }}" class="flex items-center flex-shrink-0 p-2 ml-auto text-xs font-bold leading-tight tracking-wide rounded-md bg-blue md:p-3 text-blue-lighter" >
                <x-heroicon-s-plus-circle class="w-4 h-4 md:w-5 md:h-5 md:mr-2"/>
                <span class="hidden md:inline-block">
                    Nuevo usuario
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
                        <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wider text-left capitalize text-gray-dark lg:py-3 lg:px-6">
                          Nombre
                        </th>
                        <th scope="col" class="hidden px-3 py-3 text-xs font-medium tracking-wider text-left capitalize md:table-cell text-gray-dark lg:py-3 lg:px-6">
                          Rol
                        </th>
                        <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wider text-left capitalize text-gray-dark lg:py-3 lg:px-6">
                          Estado
                        </th>
                        <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wider text-left capitalize text-gray-dark lg:py-3 lg:px-6">
                          Ultima sesión
                        </th>
                        <th scope="col" class="px-3 py-3 text-xs font-medium tracking-wider text-left capitalize text-gray-dark lg:py-3 lg:px-6">
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-light">
                      @forelse ($users as $user)
                      <tr class="cursor-pointer hover:bg-gray-lightest">
                        <td class="px-3 py-2 lg:px-6 lg:py-3 whitespace-nowrap">
                          <div class="flex items-center">
                            <div class="flex-shrink-0 hidden w-8 h-8 lg:block">
                                <img class="w-8 h-8 rounded-full" src="{{ $user->profile_image }}" alt="">
                            </div>
                            <div class="lg:ml-4">
                              <div class="text-sm font-medium text-gray-dark">
                                {{ $user->name }}
                              </div>
                              <div class="text-gray text-xxs mt-0.5">
                                {{ $user->email }}
                              </div>
                              <div class="mt-1 text-gray text-xxs">
                                Tel: {{ $user->phone_number }}
                              </div>
                            </div>
                          </div>
                        </td>

                        <td class="hidden px-3 py-2 lg:px-6 lg:py-3 whitespace-nowrap md:table-cell">
                            @foreach($user->roles as $key => $role)
                                <span class="inline-flex font-semibold leading-5 capitalize text-xxs text-gray">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-3 py-2 lg:px-6 lg:py-3 whitespace-nowrap">
                            @if(Cache::has('user-online-'. $user->id ))
                                <span class="inline-flex w-3 h-3 font-semibold leading-5 rounded-full md:px-2 bg-green md:w-auto md:h-auto text-xxs md:bg-green-light text-green-dark">
                                    <span class="hidden md:inline-block">Conectado</span>
                                </span>
                            @else
                                <span class="inline-flex w-3 h-3 font-semibold leading-5 rounded-full md:px-2 bg-red md:w-auto md:h-auto text-xxs md:bg-red-lightest text-red-darker">
                                    <span class="hidden md:inline-block">Desconectado</span>
                                </span>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-xs lg:px-6 lg:py-3 whitespace-nowrap">
                          {{ $user->last_login_at }}
                        </td>
                        <td class="px-3 py-2 text-sm lg:px-6 lg:py-3 whitespace-nowrap">
                            <div class="flex items-center justify-end space-x-2 lg:space-x-4">
                                <a href="{{ route('users.show', $user) }}" class="text-gray-400 hover:text-gray-dark">
                                    <x-heroicon-s-eye class="w-5 h-5" />
                                </a>
                                <a href="{{ route('users.edit', $user) }}" class="text-gray-400 hover:text-gray-dark">
                                    <x-heroicon-s-pencil-alt class="w-5 h-5" />
                                </a>
                                <a href="{{ route('users.edit', $user) }}" class="text-gray-400 hover:text-red">
                                    <x-heroicon-s-trash class="w-5 h-5" />
                                </a>
                            </div>
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td class="px-6 py-4 whitespace-nowrap" colspan="5">
                          <div class="flex items-center justify-center">
                              <span class="py-6 text-base text-gray">No hay usuarios registrados</span>
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
            {!! $users->links() !!}
          </div>
    </div>
</div>
