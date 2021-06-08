<div class="flex flex-col text-xs md:flex-row">
    <div class="w-full px-5 py-3 mt-5 bg-white rounded-lg shadow md:w-80 md:mt-0">
        <form action="#">
            <div class="my-2">
                <label for="name" class="block font-medium text-gray-500">Nombre</label>
                <div class="mt-1">
                    <input class="w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-gray-500"
                    type="email" name="name" id="name" wire:model='"menu.name'>
                </div>
            </div>
            <div class="my-2">
                <label for="name" class="block font-medium text-gray-500">URL</label>
                <div class="mt-1">
                    <input class="w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-gray-500"
                    type="email" name="name" id="name" wire:model='"menu.route'>
                </div>
            </div>
            <div class="my-2">
                <label for="name" class="block font-medium text-gray-500">Orden</label>
                <div class="mt-1">
                    <input class="w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-gray-500"
                    type="email" name="name" id="name" wire:model='"menu.order'>
                </div>
            </div>
        </form>
    </div>
</div>
