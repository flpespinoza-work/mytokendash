<div>
    <x-modal wire:model="show">
        <div class="p-4">
            <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-3">
                        <div>
                            <h3 class="font-medium leading-6 text-gray-900 text-md">Crear grupo</h3>
                            <p class="mt-1 text-xs text-gray-600">
                                Ingrese la siguiente información para dar de alta un nuevo grupo
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-3">
                        <form wire:submit.prevent="submit">
                            <div class="overflow-hidden">
                                <div class="bg-white">
                                    <div class="grid grid-cols-6 gap-4">
                                        <div class="col-span-6">
                                            <x-forms.label for="group.name" value="Nombre del grupo" />
                                            <x-forms.input wire:model.defer='group.name' type="text" name="name" id="name" />
                                            @error('group.name') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
                                        </div>

                                        <div class="col-span-6">
                                            <x-forms.label for="group.contact_name" value="Nombre de contacto" />
                                            <x-forms.input wire:model.defer='group.contact_name' type="text" name="contact_name" id="contact_name" />
                                            @error('group.contact_name') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
                                        </div>

                                        <div class="col-span-6">
                                            <x-forms.label for="group.contact_phone" value="Teléfono de contacto" />
                                            <x-forms.input wire:model.defer='group.contact_phone' maxlength="10" size="10" type="text" name="contact_phone" id="contact_phone" />
                                            @error('group.contact_phone') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
                                        </div>

                                        <div class="col-span-6">
                                            <x-forms.label for="group.contact_email" value="Correo de contacto" />
                                            <x-forms.input wire:model.defer='group.contact_email' type="email" name="contact_email" id="contact_email" />
                                            @error('group.contact_email') <x-forms.input-error>{{ $message }}</x-forms.input-error> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-end mt-4 space-x-1 text-right bg-white">
                                    <x-forms.button wire:click.prevent="$set('show', false)">
                                        Cancelar
                                    </x-forms.button>

                                    <x-forms.button>
                                        <x-heroicon-s-check class="w-4 h-4 mr-2"/>
                                        Guardar
                                    </x-forms.button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-modal>
</div>
