<div class="flex flex-col space-y-2">
    <div class="w-full md:ml-auto md:w-72">
        <select wire:model="store" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-50 focus:border-graring-gray-50 sm:text-sm">
        @foreach ($stores as $name => $id)
            <option value="{{ $id}}">{{ $name }}</option>
        @endforeach
        </select>
    </div>
    <div class="grid grid-flow-row grid-cols-4 grid-rows-5 gap-4">
        <livewire:dashboard.pagos :store="$store" :wire:key="time().$store"/>
        <livewire:dashboard.cupones-impresos :store='$store' :wire:key="time().$store"/>
        <livewire:dashboard.cupones-canjeados :store='$store' :wire:key="time().$store"/>
        <livewire:dashboard.cupones-impresos-hora :store='$store' :wire:key="time().$store" />
    </div>
</div>
@push('scripts')
    @livewireChartsScripts
@endpush
