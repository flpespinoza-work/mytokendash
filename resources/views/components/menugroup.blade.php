<div class="px-6 py-4 mt-3">
    <h3 class="pl-1 text-xs font-light uppercase text-gray">{{ $menuGroup['name'] }}</h3>
    @if( count($menuGroup['submenu']) )
        @include('components.submenu', [ 'menuGroup' => $menuGroup['submenu'], 'isMain' => true ])
    @endif
</div>
