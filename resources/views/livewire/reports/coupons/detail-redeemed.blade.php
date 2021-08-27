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

            <div class="w-1/5 px-2 space-y-2">
                <label for="store" class="block text-sm font-medium text-gray-700">Periodo</label>
                <select wire:model.lazy="period" id="period" name="period"class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option></option>
                    <option value="30">30 días</option>
                    <option value="60">60 días</option>
                    <option value="90">90 días</option>
                </select>
            </div>

            <div class="w-1/5 px-2">
                <button type="submit" class="flex items-center px-5 py-2 text-sm font-semibold bg-gray-700 rounded-md text-gray-50">
                    <span wire:loading wire:target="generateReport" class="mr-2">
                        <x-loader class="w-5 h-5"/>
                    </span>
                    Generar reporte
                </button>
            </div>
        </form>

        @if($coupons)
         <button wire:click="exportReport" type="button"  class="px-5 py-2 text-sm font-semibold bg-green-600 rounded-md hover:bg-green-700 text-green-50">
            <x-heroicon-s-document-download class="w-4 h-4 md:h-5 md:w-5" />
         </button>
        @endif
    </div>

    @isset($coupons['REGISTROS'])
    <div class="flex items-center mt-8 space-x-4">
        <div class="w-1/2 p-4 bg-white border border-gray-100 rounded-md shadow-sm md:w-64">
            <h5 class="text-sm font-medium text-gray-500">Cupones canjeados: {{ $coupons['TOTALS']['redeemed_coupons']}}</h5>
            <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-2xl">
            ${{ number_format($coupons['TOTALS']['redeemed_ammount'], 2) }}
            </span>
        </div>
        <div class="w-1/2 p-4 bg-white border border-gray-100 rounded-md shadow-sm md:w-64">
            <h5 class="text-sm font-medium text-gray-500">Promedio por cupón:</h5>
            <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-2xl">
            ${{ number_format($coupons['TOTALS']['average_ammount'], 3) }}
            </span>
        </div>
    </div>

    <div class="mt-6 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
        <h5 class="text-sm font-medium text-gray-500 md:text-base">Detallado de cupones canjeados</h5>
        <div class="mt-3 overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                    #
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                    Usuario
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                    Cupón
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                    Impreso
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                    Canjeado
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                    Monto canje
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                    Saldo usuario
                </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($coupons['REGISTROS'] as $i => $coupon)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                        {{ $i + 1 }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none rounded-full">
                            {{ $coupon['USUARIO_NODO'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 font-bold leading-none rounded-full text-xxs text-orange-dark bg-orange-lightest">
                            {{ $coupon['CODIGO_CUPON'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-semibold leading-none rounded-full">
                            {{ $coupon['CUPON_FECHA_HORA'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-semibold leading-none rounded-full">
                            {{ $coupon['CANJE_FECHA_HORA'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 font-bold leading-none text-green-600 bg-green-100 rounded-full text-xxs">
                            ${{ number_format($coupon['CANJE_MONTO'], 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 font-bold leading-none text-blue-700 bg-blue-100 rounded-full text-xxs">
                            ${{ number_format($coupon['SALDO_USUARIO'], 2) }}
                        </span>
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
