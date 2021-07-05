<div class="flex flex-col">
  <div class="flex items-center space-x-4">
    <div class="w-1/2 p-4 bg-white border border-gray-100 rounded-md shadow-sm md:w-64">
        <h5 class="text-sm font-medium text-gray-500">Cupones impresos: {{ $coupons['TOTALS']['printed_coupons']}}</h5>
        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-2xl">${{ number_format($coupons['TOTALS']['printed_ammount'], 2) }} </span>
    </div>
    <div class="w-1/2 p-4 bg-white border border-gray-100 rounded-md shadow-sm md:w-64">
        <h5 class="text-sm font-medium text-gray-500">Cupones canjeados: {{ $coupons['TOTALS']['redeemed_coupons']}}</h5>
        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-2xl">${{ number_format($coupons['TOTALS']['redeemed_ammount'], 2) }} </span>
    </div>
  </div>

  <div class="mt-6 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
      <h5 class="text-sm font-medium text-gray-500 md:text-base">Detallado de cupones impresos vs canjeados</h5>
      <div class="mt-3 overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                Fecha
              </th>
              <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                Cupones impresos
              </th>
              <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                Cupones canjeados
              </th>
              <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                %
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($coupons['REGISTROS'] as $date => $coupon)
            <tr>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ $date }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ $coupon['CUPONES'] }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ $coupon['CANJES'] }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ round($coupon['CANJES'] * 100 / $coupon['CUPONES'], 2) }} %
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

  <div class="mt-6 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
      <h5 class="text-sm font-medium text-gray-500 md:text-base">Detallado de dinero impreso vs canjeado</h5>
      <div class="mt-3 overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                Fecha
              </th>
              <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                Dinero impreso
              </th>
              <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                Dinero canjeado
              </th>
              <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                %
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($coupons['REGISTROS'] as $date => $coupon)
            <tr>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ $date }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ $coupon['MONTO_IMPRESO'] }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ $coupon['MONTO_CANJE'] }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ round($coupon['MONTO_CANJE'] * 100 / $coupon['MONTO_IMPRESO'], 2) }} %
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
</div>

