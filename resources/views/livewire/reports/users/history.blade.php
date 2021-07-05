<div class="flex flex-col">
  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
      <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                Usuarios registrados
              </th>
              <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                Saldo actual en monederos
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($users['USUARIOS'] as $usuarios)
            <tr>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ $usuarios['USUARIOS'] }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                    ${{ number_format($usuarios['MONTO'],2) }}
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


