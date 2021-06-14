<div class="max-w-2xl">
    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-3">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Crear grupo</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Ingrese la siguiente información para dar de alta un nuevo grupo
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-3">
                <form wire:submit.prevent="submit">
                    <div class="overflow-hidden rounded-md shadow">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-4">
                                <div class="col-span-6 sm:col-span-6">
                                    <x-forms.label for="group.name" value="Nombre" />
                                    <x-forms.input wire:model.debounce.1s='group.name' type="text" name="name" id="name" />
                                    @error('group.name') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-forms.label for="group.contact_name" value="Nombre de contacto" />
                                    <x-forms.input wire:model.defer='group.contact_name' type="text" name="contact_name" id="contact_name" />
                                    @error('group.contact_name') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-forms.label for="group.contact_phone" value="Teléfono de contacto" />
                                    <x-forms.input wire:model.defer='group.contact_phone' maxlength="10" size="10" type="text" name="contact_phone" id="contact_phone" />
                                    @error('group.contact_phone') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                            <x-forms.button>Guardar</x-forms.button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


