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
                <button type="submit" class="flex items-center px-5 py-2 text-sm font-semibold bg-gray-700 rounded-md text-gray-50">
                    <span wire:loading wire:target="generateReport" class="mr-2">
                        <x-loader class="w-5 h-5"/>
                    </span>
                    Generar reporte
                </button>
            </div>
        </form>
    </div>
    @isset($coupons[0])
    <div class="mt-8 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
        <div class="flex flex-col space-y-4 overflow-hidden sm:rounded-lg">
            <h5 class="text-sm font-medium text-gray-500 md:text-base">Cupones impresos</h5>
            <table class="w-full divide-y divide-gray-200 md:w-1/2">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                            Cupones impresos
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                            Monto impreso
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                            Promedio
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $coupons[0]['CUPONES_IMPRESOS'] }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            ${{ number_format($coupons[0]['MONTO_IMPRESO'], 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            ${{ number_format($coupons[0]['PROMEDIO_IMPRESO'], 3) }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <h5 class="text-sm font-medium text-gray-500 md:text-base">Cupones canjeados</h5>
            <table class="w-full divide-y divide-gray-200 md:w-1/2">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                            Cupones canjeados
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                            Saldo canjeados
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                            Promedio
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $coupons[1]['CUPONES_CANJEADOS'] }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            ${{ number_format($coupons[1]['MONTO_CANJEADO'], 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            ${{ number_format($coupons[1]['PROMEDIO_CANJE'], 3) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
    @endisset

</div>
