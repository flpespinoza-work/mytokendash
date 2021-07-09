<div>
    <div class="flex flex-col w-full pb-10">
        <div class="items-center space-y-3 sm:space-y-0 sm:space-x-4 sm:flex">
            <div class="w-full p-4 bg-white border border-gray-100 rounded-md shadow-sm sm:w-1/2 md:w-64">
                <h5 class="text-sm font-medium text-gray-500">Calificaciones Totales </h5>
                <span class="inline-block mt-2 text-lg font-semibold text-gray-dark md:text-xl xl:text-5xl">{{ $scores['totalScores'] }}</span>
            </div>
            <div class="w-full p-4 bg-white border border-gray-100 rounded-md shadow-sm sm:w-1/2 md:w-64">
                <h5 class="text-sm font-medium text-gray-500">Tu calificación: </h5>
                <span class="inline-block mt-2 text-lg font-semibold text-gray-dark md:text-xl xl:text-5xl">{{ $scores['scorePromedio'] }} %</span>
            </div>
        </div>

        <div class="w-full p-3 mt-5 bg-white border border-gray-100 rounded-md shadow-sm md:w-2/4 h-96">
            <livewire:livewire-column-chart key="{{ $columnChartModel->reactiveKey() }}" :column-chart-model="$columnChartModel"/>
        </div>

        <div class="flex flex-col mt-10">
            <h5 class="text-base font-medium">Comentarios</h5>
            <div class="mt-8 overflow-x-hidden bg-white border border-gray-300 rounded-md" x-data="{ openTab: 5 }  ">
                <ul class="flex items-center justify-between border-b border-gray-300">
                    <li @click="openTab = 5" :class="openTab === 5 ? 'bg-white' : 'bg-gray-100'" class="flex-1"><a class="block w-full py-5 font-semibold text-center border-r border-gray-300 cursor-pointer sm:text-xs text-xxs md:text-sm">5</a></li>
                    <li @click="openTab = 4" :class="openTab === 4 ? 'bg-white' : 'bg-gray-100'" class="flex-1"><a class="block w-full py-5 font-semibold text-center border-r border-gray-300 cursor-pointer sm:text-xs text-xxs md:text-sm">4</a></li>
                    <li @click="openTab = 3" :class="openTab === 3 ? 'bg-white' : 'bg-gray-100'" class="flex-1"><a class="block w-full py-5 font-semibold text-center border-r border-gray-300 cursor-pointer sm:text-xs text-xxs md:text-sm">3</a></li>
                    <li @click="openTab = 2" :class="openTab === 2 ? 'bg-white' : 'bg-gray-100'" class="flex-1"><a class="block w-full py-5 font-semibold text-center border-r border-gray-300 cursor-pointer sm:text-xs text-xxs md:text-sm">2</a></li>
                    <li @click="openTab = 1" :class="openTab === 1 ? 'bg-white' : 'bg-gray-100'" class="flex-1"><a class="block w-full py-5 font-semibold text-center border-r border-gray-300 cursor-pointer sm:text-xs text-xxs md:text-sm">1</a></li>
                    <li @click="openTab = 0" :class="openTab === 0 ? 'bg-white' : 'bg-gray-100'" class="flex-1"><a class="block w-full py-5 font-semibold text-center cursor-pointer text-xxs sm:text-xs">Solo comentarios</a></li>
                </ul>
                <div class="w-full px-16 py-8">
                    @foreach ($scores['comments'] as $score => $comments)
                        <div class="space-y-2" id="score-{{$score}}" x-show="openTab === {{ $score }}">
                            @foreach ($comments as $comment)
                               <div class="p-4 space-y-3 border rounded-md bg-gray-50">
                                    <div class="flex items-center space-x-3">
                                        <p class="font-semibold text-gray-600 text-xxs">{{ $comment['FECHA_COMENTARIO'] }}</p>
                                        <p class="inline-flex px-2 py-1 font-medium rounded-full bg-orange-lightest text-orange-dark text-xxs">Usuario: {{ $comment['USUARIO'] }}</p>
                                        @if ($comment['TIPO_VENTA'] == 'CANJE')
                                        <p class="inline-flex px-2 py-1 font-medium text-green-600 lowercase bg-green-100 rounded-full text-xxs">{{ $comment['TIPO_VENTA'] }}</p>
                                        @else
                                        <p class="inline-flex px-2 py-1 font-medium text-blue-600 lowercase bg-blue-100 rounded-full text-xxs">{{ $comment['TIPO_VENTA'] }}</p>
                                        @endif
                                    </div>
                                    <p class="text-xs">Atendió: <span class="text-xxs">{{ $comment['VENDEDOR'] }}</span></p>
                                    <p class="text-xs sm:text-sm md:text-base">{{ $comment['COMENTARIO'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    @livewireChartsScripts
@endpush
