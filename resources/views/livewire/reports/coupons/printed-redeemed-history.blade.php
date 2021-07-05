<div class="flex flex-col">
  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
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
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
