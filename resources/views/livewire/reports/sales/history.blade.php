<div class="flex flex-col">
  <div class="mt-3 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
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



