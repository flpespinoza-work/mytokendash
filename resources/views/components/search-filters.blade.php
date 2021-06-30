@props([

])
<div class="flex items-center w-full space-x-2">
    <div class="flex w-full">
        <span class="inline-flex items-center p-1 text-sm text-gray-400 border border-r-0 md:px-3 border-transparent0 rounded-l-md bg-gray-lightest">
            <x-heroicon-s-search-circle class="w-5 h-5" />
        </span>
        <input
        wire:model.debounce.300ms="search"
        type="text"
        class="block w-full p-2 text-xs leading-tight bg-white border border-gray-200 rounded-none appearance-none md:text-sm rounded-r-md text-gray-dark focus:ring-0 md:p-3 focus:outline-none focus:border-gray-300"
        placeholder="Buscar...">
    </div>

    <select wire:model="perPage"
    class="inline-block p-2 text-xs leading-tight bg-white border border-gray-200 rounded-md appearance-none w-36 md:text-sm md:p-3 focus:outline-none focus:ring-0 focus:border-gray-300">
        <option value="10">Mostrar 10</option>
        <option value="20">Mostrar 20</option>
        <option value="30">Mostrar 30</option>
        <option value="50">Mostrar 50</option>
    </select>
</div>

