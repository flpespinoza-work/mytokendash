<div class="flex flex-col">
  <div class="flex items-center space-x-4">
    <div class="w-1/2 p-4 bg-white border border-gray-100 rounded-md shadow-sm md:w-64">
        <h5 class="text-sm font-medium text-gray-500">Cupones canjeados: {{ $coupons['TOTALS']['redeemed_coupons']}}</h5>
        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-2xl">
        ${{ number_format($coupons['TOTALS']['redeemed_ammount'], 2) }}
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
</div>


