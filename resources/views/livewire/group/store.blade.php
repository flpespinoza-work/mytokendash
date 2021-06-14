<div class="max-w-2xl">
    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-3">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Crear establecimiento</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Ingrese la siguiente información para dar de alta un nuevo establecimiento
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-3">
                <form wire:submit.prevent="submit">
                    <div class="overflow-hidden rounded-md shadow">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-4">
                                <div class="col-span-6 sm:col-span-4">
                                    <x-forms.label for="store.name" value="Nombre" />
                                    <x-forms.input wire:model.debounce.1s='store.name' type="text" name="name" id="name" />
                                    @error('store.name') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <x-forms.label for="store.tokencash_nodo" value="Nodo Tokencash" />
                                    <x-forms.input wire:model.debounce.1s='store.tokencash_nodo' type="text" name="nodo" id="nodo" />
                                    @error('store.tokencash_nodo') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-forms.label for="state" value="Estado" />
                                    <select wire:change="chargeMunicipalities()" class="w-full mt-1 text-sm border border-gray-300 rounded-md shadow-sm focus:border-gray-400 focus:ring-1 focus:ring-gray-200" wire:model="state" name="state" id="state">
                                        <option value="">Estado...</option>
                                        @foreach ($states as $id => $state)
                                        <option value="{{ $id }}">{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-forms.label for="municipality" value="Municipio" />
                                    <select class="w-full mt-1 text-sm border border-gray-300 rounded-md shadow-sm focus:border-gray-400 focus:ring-1 focus:ring-gray-200" wire:model="municipality" name="municipality" id="municipality">
                                        <option value="">Municipio...</option>
                                        @forelse ($municipalities as $id => $municipality)
                                        <option value="{{ $id }}">{{ $municipality }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <x-forms.label for="store.street" value="Domicilio" />
                                    <x-forms.input wire:model='store.street' type="text" name="store.street" id="store.street" />
                                    @error('store.street') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <x-forms.label for="store.postal_code" value="Código postal" />
                                    <x-forms.input wire:model.defer='store.postal_code' maxlength="10" size="10" type="text" name="postal_code" id="postal_code" />
                                    @error('store.postal_code') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-forms.label for="store.contact_name" value="Nombre de contacto" />
                                    <x-forms.input wire:model.defer='store.contact_name' type="text" name="contact_name" id="contact_name" />
                                    @error('store.contact_name') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-forms.label for="store.contact_phone" value="Teléfono de contacto" />
                                    <x-forms.input wire:model.defer='store.contact_phone' maxlength="10" size="10" type="text" name="contact_phone" id="contact_phone" />
                                    @error('store.contact_phone') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
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


