<ul class="mt-3">
    @foreach($menuGroup as $menu)
    @php $isActive = ( request()->routeIs($menu['route']) ) ? true : false @endphp
    <li class="{{ $isActive ? 'bg-orange-lightest': '' }} px-2 py-2 rounded-md mb-0.5 last:mb-0" >
        <a class="block text-gray-600 transition duration-150 hover:text-gray-800" href="{{ ($menu['route']) ? route($menu['route']) : '#' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center flex-grow">
                    @if($menu['icon'])
                        {{ svg($menu['icon'], ['class'=>'w-5 h-5 mr-2 text-orange']) }}
                    @endif
                    <span class="text-xs font-medium capitalize">{{ $menu['name'] }}</span>
                </div>
                @if(count($menu['submenu']))
                <div class="flex flex-shrink-0 ml-2">
                    <x-heroicon-s-chevron-down x-show="selected != 1" class="flex-shrink-0 w-3 h-3 ml-1 fill-current text-gray-darker"/>
                    <x-heroicon-s-chevron-up x-show="selected == 1" class="flex-shrink-0 w-3 h-3 ml-1 fill-current text-gray-darker"/>
                </div>
                @endif
            </div>
        </a>
        @if(count($menu['submenu']))

        @endif
    </li>
    @endforeach
</ul>
