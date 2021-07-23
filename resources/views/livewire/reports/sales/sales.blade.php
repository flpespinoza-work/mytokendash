<div class="flex flex-col">
    <div class="flex items-end w-full">
        <form class="items-end flex-1 md:flex" wire:submit.prevent="generateReport">
            <div class="w-1/5 px-2 space-y-2">
                <label for="store" class="block text-sm font-medium text-gray-700">Establecimientos</label>
                <select wire:model.defer="store" id="store" name="store" autocomplete="store" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option></option>
                    @foreach ($stores as $store => $name)
                    <option value="{{ $store }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-1/5 px-2 space-y-2">
                <label for="store" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                <input type="text" id="initialDate" wire:model.lazy="initialDate" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>
            <div class="w-1/5 px-2 space-y-2">
                <label for="store" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                <input type="text" id="finalDate" wire:model.lazy="finalDate" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>

            <div class="w-1/5 px-2">
                <button type="submit" class="px-5 py-2 text-sm font-semibold bg-gray-700 rounded-md text-gray-50">Generar reporte</button>
            </div>
        </form>

        @if($sales)
         <button wire:click="exportReport" type="button"  class="px-5 py-2 text-sm font-semibold bg-green-600 rounded-md hover:bg-green-700 text-green-50">
            <x-heroicon-s-document-download class="w-4 h-4 md:h-5 md:w-5" />
         </button>
        @endif
    </div>

    @isset($sales['VENTAS'])
        <div class="flex items-center mt-8 space-x-4">
            <div class="w-1/2 p-4 bg-white border border-gray-100 rounded-md shadow-sm md:w-64">
                <h5 class="text-sm font-medium text-gray-500">Ventas totales: {{ $sales['TOTALS']['sales']}}</h5>
                <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-2xl">
                    ${{ number_format($sales['TOTALS']['ammount'], 2) }}
                </span>
            </div>
            <div class="w-1/2 p-4 bg-white border border-gray-100 rounded-md shadow-sm md:w-64">
                <h5 class="text-sm font-medium text-gray-500">Venta promedio</h5>
                <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-2xl">
                    ${{ number_format($sales['TOTALS']['average_sale'], 3) }}
                </span>
            </div>
        </div>

        <div class="items-center w-full mt-10 md:flex md:space-x-8">
            <div class="w-full h-56 p-3 mt-5 bg-white border border-gray-100 rounded-md shadow-sm md:h-96">
                <livewire:livewire-area-chart :area-chart-model="$areaChartModel"/>
            </div>
        </div>

        <div class="mt-10 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Fecha Venta
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Usuario
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Monto Venta
                    </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($sales['VENTAS'] as $i => $venta)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $i+=1 }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $venta['FECHA_VENTA'] }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $venta['USUARIO'] }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            ${{ number_format($venta['MONTO'],2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                        No existen registros para esta búsqueda
                    </td>
                    </tr>
                    @endforelse
                </tbody>
                </table>
            </div>
            </div>
        </div>
    @endisset

</div>

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
@endpush

@push('scripts')
    @livewireChartsScripts

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>

    <script>
    var startDate,
        endDate,
        updateStartDate = function() {
            startPicker.setStartRange(startDate);
            endPicker.setStartRange(startDate);
            endPicker.setMinDate(startDate);
        },
        updateEndDate = function() {
            startPicker.setEndRange(endDate);
            startPicker.setMaxDate(endDate);
            endPicker.setEndRange(endDate);
        },
        startPicker = new Pikaday({
            field: document.getElementById('initialDate'),
            i18n: {
                previousMonth : 'Anterior',
                nextMonth     : 'Siguiente',
                months        : ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                weekdays      : ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
                weekdaysShort : ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb']
            },
            format: 'DD/MM/YYYY',
            minDate: new Date(),
            maxDate: new Date(2020, 12, 31),
            onSelect: function() {
                startDate = this.getDate();
                updateStartDate();
            }
        }),
        endPicker = new Pikaday({
            field: document.getElementById('finalDate'),
            i18n: {
                previousMonth : 'Anterior',
                nextMonth     : 'Siguiente',
                months        : ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                weekdays      : ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
                weekdaysShort : ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb']
            },
            format: 'DD/MM/YYYY',
            minDate: new Date(),
            maxDate: new Date(2020, 12, 31),
            onSelect: function() {
                endDate = this.getDate();
                updateEndDate();
            }
        }),
        _startDate = startPicker.getDate(),
        _endDate = endPicker.getDate();

        if (_startDate) {
            startDate = _startDate;
            updateStartDate();
        }

        if (_endDate) {
            endDate = _endDate;
            updateEndDate();
        }
    </script>


@endpush

