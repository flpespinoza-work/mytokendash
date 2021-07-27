<div>
    <div class="max-w-screen-md">
        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-3">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Crear campaña</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Ingrese la siguiente información para dar de alta una nueva campaña
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-3">
                    <form wire:submit.prevent="crearCampana">
                        <div class="overflow-hidden rounded-md shadow">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-4">

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="store" class="block text-sm font-medium text-gray-700">Selecciona un establecimiento</label>
                                        <select wire:model.defer="campaign.store" id="store" name="store" autocomplete="store" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option></option>
                                            @foreach ($stores as $store => $name)
                                            <option value="{{ $store }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="type" class="block text-sm font-medium text-gray-700">Tipo de notificación</label>
                                        <select wire:model.defer="campaign.type" id="type" name="type" autocomplete="type" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option></option>
                                            <option value="INFORMATIVA">Informativa</option>
                                            <option value="CANJE_CUPON">Cupón</option>
                                        </select>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la campaña</label>
                                        <input type="text" id="name" wire:model.defer="campaign.name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="title" class="block text-sm font-medium text-gray-700">Encabezado de la campaña</label>
                                        <input type="text" id="title" wire:model.defer="campaign.title" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm">
                                    </div>

                                    <div class="col-span-6">
                                        <label for="store" class="block text-sm font-medium text-gray-700">Cuerpo de la campaña</label>
                                        <textarea name="body"
                                        maxlength="120"
                                        class="w-full h-24 mt-3 text-xs border border-gray-200 rounded-md shadow-sm resize-none md:text-sm p2 focus:ring-2 focus:ring-orange-light focus:border-orange-lightest"
                                        wire:model.defer="campaign.body"></textarea>
                                    </div>

                                    <div class="col-span-6 md:col-span-3">
                                        <label for="store" class="block text-sm font-medium text-gray-700">Sexo</label>
                                        <select wire:model.defer="campaign.gender" id="gender" name="gender" autocomplete="gender" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option></option>
                                            <option value="femenino">Femenino</option>
                                            <option value="masculino">Masculino</option>
                                            <option value="otro">Otro</option>
                                        </select>
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="inactive" class="block text-sm font-medium text-gray-700">Tiempo sin actividad</label>
                                        <input type="text" id="inactive" wire:model.defer="campaign.inactive" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm">
                                    </div>

                                    <div class="col-span-6">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Imagen para la campaña(Informativas)
                                        </label>
                                        <div class="flex justify-center px-6 pt-5 pb-6 mt-1 border-2 border-gray-300 border-dashed rounded-md">
                                            <div class="space-y-1 text-center">
                                            <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="file-upload" class="relative font-medium text-indigo-600 bg-white rounded-md cursor-pointer hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Seleccione una imagen</span>
                                                <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                PNG, JPG, GIF
                                            </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="inactive" class="block text-sm font-medium text-gray-700">Código cupón(Campañas de inducción)</label>
                                        <input type="text" id="coupon" wire:model.defer="campaign.coupon" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                                <x-forms.button>
                                    <x-heroicon-s-check class="w-4 h-4 mr-2"/>
                                    Guardar campaña
                                </x-forms.button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>








</div>

