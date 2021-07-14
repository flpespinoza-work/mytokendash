<div class="relative col-span-1 p-4 bg-white border border-gray-100 rounded-md shadow-sm">
    <h5 class="text-sm font-medium text-gray-500">Redención de pagos: {{ $sales['TOTALS']['sales'] }}</h5>
    <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">${{ number_format($sales['TOTALS']['ammount'], 2) }} </span>
</div>
