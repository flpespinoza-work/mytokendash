<div>
    <div class="flex flex-col w-full pb-10">
        <div class="flex items-end w-full">
            <form class="items-end flex-1 md:flex" wire:submit.prevent="getScoreList">
                <div class="w-1/5 px-2 space-y-2" wire:ignore>
                    <label for="store" class="block text-sm font-medium text-gray-700">Establecimientos</label>
                    <select id="store" name="store" autocomplete="store" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
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
                        <span wire:loading wire:target="getScoreList" class="mr-2">
                            <x-loader class="w-5 h-5"/>
                        </span>
                        Generar reporte
                    </button>
                </div>
            </form>
        </div>
        @if(isset($scores['comments']))
        <div class="items-center mt-8 space-y-3 sm:space-y-0 sm:space-x-4 sm:flex">
            <div class="w-full p-4 bg-white border border-gray-100 rounded-md shadow-sm sm:w-1/2 md:w-64">
                <h5 class="text-sm font-medium text-gray-500">Calificaciones Totales </h5>
                <span class="inline-block mt-2 text-lg font-semibold text-gray-dark md:text-xl xl:text-5xl">{{ $scores['totalScores'] }}</span>
            </div>
            <div class="w-full p-4 bg-white border border-gray-100 rounded-md shadow-sm sm:w-1/2 md:w-64">
                <h5 class="text-sm font-medium text-gray-500">Tu calificación: </h5>
                <span class="inline-block mt-2 text-lg font-semibold text-gray-dark md:text-xl xl:text-5xl">{{ $scores['scorePromedio'] }} %</span>
            </div>
        </div>
        <div class="items-center md:flex md:space-x-2">
            <div class="w-full p-3 mt-5 bg-white border border-gray-100 rounded-md shadow-sm md:w-2/4 h-96">
                <livewire:livewire-column-chart key="{{ $columnChartModel->reactiveKey() }}" :column-chart-model="$columnChartModel"/>
            </div>

            <div class="w-full p-3 mt-5 bg-white border border-gray-100 rounded-md shadow-sm md:w-2/4 h-96">
                <livewire:livewire-column-chart key="{{ $columnChartModelScore->reactiveKey() }}" :column-chart-model="$columnChartModelScore"/>
            </div>
        </div>

        <div class="flex flex-col mt-10">
            <h5 class="text-base font-medium">Comentarios</h5>
            <div class="mt-8 overflow-x-hidden bg-white border border-gray-300 rounded-md" x-data="{ openTab: 5 }  ">
                <ul class="flex items-center justify-between border-b border-gray-300">
                    <li @click="openTab = 5" :class="openTab === 5 ? 'bg-white' : 'bg-gray-100'" class="flex-1">
                        <a class="block w-full py-2 font-semibold text-center border-r border-gray-300 cursor-pointer sm:text-xs text-xxs md:text-sm">
                            <x-emojis.contento class="w-12 h-12 mx-auto" />
                        </a>
                    </li>
                    <li @click="openTab = 4" :class="openTab === 4 ? 'bg-white' : 'bg-gray-100'" class="flex-1">
                        <a class="block w-full py-2 font-semibold text-center border-r border-gray-300 cursor-pointer sm:text-xs text-xxs md:text-sm">
                            <x-emojis.feliz class="w-12 h-12 mx-auto" />
                        </a>
                    </li>
                    <li @click="openTab = 3" :class="openTab === 3 ? 'bg-white' : 'bg-gray-100'" class="flex-1">
                        <a class="block w-full py-2 font-semibold text-center border-r border-gray-300 cursor-pointer sm:text-xs text-xxs md:text-sm">
                            <x-emojis.neutral class="w-12 h-12 mx-auto" />
                        </a>
                    </li>
                    <li @click="openTab = 2" :class="openTab === 2 ? 'bg-white' : 'bg-gray-100'" class="flex-1">
                        <a class="block w-full py-2 font-semibold text-center border-r border-gray-300 cursor-pointer sm:text-xs text-xxs md:text-sm">
                            <x-emojis.molesto class="w-12 h-12 mx-auto" />
                        </a>
                    </li>
                    <li @click="openTab = 1" :class="openTab === 1 ? 'bg-white' : 'bg-gray-100'" class="flex-1">
                        <a class="block w-full py-2 font-semibold text-center border-r border-gray-300 cursor-pointer sm:text-xs text-xxs md:text-sm">
                            <x-emojis.enojado class="w-12 h-12 mx-auto" />
                        </a>
                    </li>
                    <li @click="openTab = 0" :class="openTab === 0 ? 'bg-white' : 'bg-gray-100'" class="flex-1">
                        <a class="block w-full py-6 font-semibold text-center cursor-pointer text-xxs sm:text-xs">Solo comentarios</a>
                    </li>
                </ul>
                <div class="w-full px-16 py-8">
                    @foreach ($scores['comments'] as $score => $comments)
                        <div class="space-y-3" id="score-{{$score}}" x-show="openTab === {{ $score }}">
                            @foreach ($comments as $comment)
                               <div class="space-y-3 overflow-hidden border rounded-md">
                                    <div class="flex items-center p-3 border-b border-gray-200 bg-gray-50">
                                        <p class="font-semibold text-gray-600 text-xxs">{{ $comment['FECHA_COMENTARIO'] }}</p>
                                        <p class="inline-flex px-2 py-1 font-medium rounded-full bg-orange-lightest text-orange-darker text-xxs mx-1.5">Usuario: {{ $comment['USUARIO'] }}</p>
                                        @if ($comment['TIPO_VENTA'] == 'CANJE')
                                        <p class="inline-flex px-2 py-1 font-medium text-green-600 lowercase bg-green-100 rounded-full text-xxs">{{ $comment['TIPO_VENTA'] }}</p>
                                        @else
                                        <p class="inline-flex px-2 py-1 font-medium text-blue-600 lowercase bg-blue-100 rounded-full text-xxs">{{ $comment['TIPO_VENTA'] }}</p>
                                        @endif
                                        <button class="flex items-center ml-auto text-xs font-medium text-gray-600">
                                            <x-heroicon-s-chat class="w-4 h-4"/>
                                            <span class="mr-1">Responder</span>
                                        </button>
                                    </div>
                                    <div class="px-4 py-2 space-y-2 bg-white">
                                        <p class="text-xs">Atendió: <span class="text-xxs">{{ $comment['VENDEDOR'] }}</span></p>
                                        <p class="text-xs sm:text-sm">{{ $comment['COMENTARIO'] }}</p>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="w-full p-3 mt-12">
            <h3 class="text-center">No hay comentarios y calificaciones para este establecimiento en las fechas indicadas</h3>
        </div>
        @endif
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
            $(document).ready(function() {
                $('#store').select2();
                $('#store').on('change', function (e) {
                    var data = $('#store').select2("val");
                    @this.set('store', data);
                });
            });

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
