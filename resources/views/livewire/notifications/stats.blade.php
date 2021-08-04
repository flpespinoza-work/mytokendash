<div class="flex flex-col">
    <h3 class="text-sm font-semibold">Campaña: {{ $stats['CAMP_NOMBRE'] }}</h3>
    <div class="flex items-center mt-8 space-x-4">
        <div class="w-1/2 p-4 bg-white border border-gray-100 rounded-md shadow-sm md:w-64">
            <h5 class="text-sm font-medium text-gray-500">Exitosas:</h5>
            <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-2xl">{{ $stats['CAMP_EXITOSAS'] }}</span>
        </div>
        <div class="w-1/2 p-4 bg-white border border-gray-100 rounded-md shadow-sm md:w-64">
            <h5 class="text-sm font-medium text-gray-500">Fallidas:</h5>
            <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-2xl">{{ $stats['CAMP_FALLIDAS'] }}</span>
        </div>
        <div class="w-1/2 p-4 bg-white border border-gray-100 rounded-md shadow-sm md:w-64">
            <h5 class="text-sm font-medium text-gray-500">Android:</h5>
            <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-2xl">{{ $stats['CAMP_ANDROID'] }}</span>
        </div>
        <div class="w-1/2 p-4 bg-white border border-gray-100 rounded-md shadow-sm md:w-64">
            <h5 class="text-sm font-medium text-gray-500">iOS:</h5>
            <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-2xl">{{ $stats['CAMP_IOS'] }}</span>
        </div>
    </div>
    <div class="items-center w-full md:flex md:space-x-8">
        <div class="w-full h-56 p-3 mt-5 bg-white border border-gray-100 rounded-md shadow-sm md:w-1/2 md:h-96">
            <livewire:livewire-column-chart :column-chart-model="$columnChartModel"/>
        </div>
        <div class="w-full h-56 p-3 mt-5 bg-white border border-gray-100 rounded-md shadow-sm md:w-1/2 md:h-96">
            <livewire:livewire-column-chart :column-chart-model="$columnChartModelDispositivo"/>
        </div>
    </div>
</div>

@push('scripts')
    @livewireChartsScripts
@endpush
