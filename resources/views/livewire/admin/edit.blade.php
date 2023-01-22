<x-jet-dialog-modal wire:model="confirmingEdit">
    <x-slot name="title">
        {{ __('Edit Data Daerah') }}
    </x-slot>

    <x-slot name="content">
        <!-- Kelurahan -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <x-jet-label for="kelurahan" value="{{ __('Kelurahan') }}" />
            <x-jet-input id="kelurahan" type="text" class="mt-1 block w-full" wire:model.defer="kelurahan" required />
        </div>

        <!-- Kecamatan -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <x-jet-label for="kecamatan" value="{{ __('Kecamatan') }}" />
            <x-jet-input id="kecamatan" type="text" class="mt-1 block w-full" wire:model.defer="kecamatan" required />
        </div>

        <!-- Kota -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <x-jet-label for="kota" value="{{ __('Kota / Kabupaten') }}" />
            <x-jet-input id="kota" type="text" class="mt-1 block w-full" wire:model.defer="kota" required />
        </div>

        <div class="flex justify-center mt-8">
            <p class="text-sm">
                <b>Periksa kembali data yang Anda masukkan sebelum Anda menekan tombol edit.</b>
            </p>
        </div>
    </x-slot>
            
    <x-slot name="footer">
        <x-jet-secondary-button class="mr-3" wire:click="$set('confirmingEdit', false)" wire:loading.attr="disabled">
            {{ __('Kembali') }}
        </x-jet-secondary-button>
            
        <x-jet-button class="bg-blue-500 hover:bg-blue-700" wire:click="update()" wire:loading.attr="disabled">
            {{ __('Perbarui') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
