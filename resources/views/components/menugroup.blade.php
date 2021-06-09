<div class="p-4 mt-3">
    <h3 class="pl-3 text-xs font-light text-gray-400 uppercase">{{ $menuGroup['name'] }}</h3>
    @if( count($menuGroup['submenu']) )
        @include('components.submenu', [ 'menuGroup' => $menuGroup['submenu'], 'isMain' => true ])
    @endif
</div>
