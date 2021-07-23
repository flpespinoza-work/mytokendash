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
    <div class="mt-3 -my-2 overflow-x-auto md:mt-8 sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Ventas realizadas
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Saldo total vendido
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Promedio por venta
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($sales['VENTAS'] as $establecimiento => $venta)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $venta['VENTAS'] }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            ${{ number_format($venta['MONTO'],2) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            ${{ number_format($venta['PROMEDIO_VENTA'],3) }}
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



