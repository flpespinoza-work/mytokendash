<div class="flex flex-col">
  <div class="flex items-center space-x-4">
    <div class="w-1/2 p-4 bg-white border border-gray-100 rounded-md shadow-sm md:w-64">
        <h5 class="text-sm font-medium text-gray-500">Cupones impresos:</h5>
        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-2xl">{{ $coupons['TOTALS']['printed_coupons'] }} </span>
    </div>
    <div class="w-1/2 p-4 bg-white border border-gray-100 rounded-md shadow-sm md:w-64">
        <h5 class="text-sm font-medium text-gray-500">Dinero impreso:</h5>
        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-2xl">${{ number_format($coupons['TOTALS']['printed_ammount'], 2) }} </span>
    </div>
  </div>
  <div class="items-center w-full md:flex md:space-x-8">
    <div class="w-full h-56 p-3 mt-5 bg-white border border-gray-100 rounded-md shadow-sm md:w-1/2 md:h-96">
        <livewire:livewire-line-chart :line-chart-model="$lineChartModel"/>
    </div>
    <div class="w-full h-56 p-3 mt-5 bg-white border border-gray-100 rounded-md shadow-sm md:w-1/2 md:h-96">
        <livewire:livewire-line-chart :line-chart-model="$montoChartModel"/>
    </div>
  </div>
  <div class="mt-10 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
      <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                Fecha
              </th>
              <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                Cupones impresos
              </th>
              <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                Monto
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($coupons['REGISTROS'] as $dia => $coupon)
            <tr>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ $dia }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ $coupon['CUPONES'] }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ $coupon['MONTO_IMPRESO'] }}
                </td>
            </tr>
            @empty
            <tr>
              <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                No existen registros para esta búsqueda
              </td>
            </tr>
            @endforelse
            @if ($coupons['TOTALS'])
            <tr>
              <td>&nbsp;</td>
              <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                <span class="font-semibold text-gray-darker">Cupones totales: {{ $coupons['TOTALS']['printed_coupons']}}</span>
              </td>
              <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                <span class="font-semibold text-gray-darker">Monto total: ${{ number_format($coupons['TOTALS']['printed_ammount'], 2) }}</span>
              </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@push('scripts')
    @livewireChartsScripts
@endpush
