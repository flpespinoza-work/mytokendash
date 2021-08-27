<div class="flex flex-col">
    <div class="flex items-end w-full">
        <form class="items-end flex-1 md:flex" wire:submit.prevent="getDetails">
            <div class="w-1/5 px-2 space-y-2">
                <label for="store" class="block text-sm font-medium text-gray-700">Usuario</label>
                <input type="text" id="user" wire:model.lazy="user" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>

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
                    <span wire:loading wire:target="getDetails" class="mr-2">
                        <x-loader class="w-5 h-5"/>
                    </span>
                    Buscar
                </button>
            </div>
        </form>
    </div>



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


