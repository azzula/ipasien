<x-jet-dialog-modal wire:model="confirmingEdit">
    <x-slot name="title">
        {{ __('Edit Data Pasien') }}
    </x-slot>

    <x-slot name="content">
        <!-- Nama -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <x-jet-label for="nama" value="{{ __('Nama') }}" />
            <x-jet-input id="nama" type="text" class="mt-1 block w-full" wire:model.defer="nama" required />
        </div>

        <!-- Alamat -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <x-jet-label for="alamat" value="{{ __('Alamat') }}" />
            <x-jet-input id="alamat" type="text" class="mt-1 block w-full" wire:model.defer="alamat" required />
        </div>

        <!-- Telepon -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <x-jet-label for="telepon" value="{{ __('Telepon') }}" />
            <x-jet-input id="telepon" type="number" class="mt-1 block w-full" wire:model.defer="telepon" required />
        </div>

        <!-- RT -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <x-jet-label for="rt" value="{{ __('RT') }}" />
            <x-jet-input id="rt" type="number" class="mt-1 block w-full" wire:model.defer="rt" required />
        </div>

        <!-- RW -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <x-jet-label for="rw" value="{{ __('RW') }}" />
            <x-jet-input id="rw" type="number" class="mt-1 block w-full" wire:model.defer="rw" required />
        </div>

        <!-- Daerah -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <x-jet-label for="kelurahan" value="{{ __('Kelurahan') }}" />
            <select id="kelurahan" class="py-2 px-3 mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="kelurahan" wire:model.defer="kelurahan" required>
                <option value=""></option>
                @foreach($daerah as $kel)
                    <option value="{{ $kel->id }}" selected="{{ $kel->id == $this->kelurahan ? 'selected' : ''}}">{{ $kel->kelurahan }}, {{ $kel->kecamatan }}, {{ $kel->kota }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tanggal Lahir -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <x-jet-label for="tanggal_lahir" value="{{ __('Tanggal Lahir') }}" />
            <x-jet-input id="tanggal_lahir" type="date" class="mt-1 block w-full" wire:model.defer="tanggal_lahir" required />
        </div>

        <!-- Tempat Lahir -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <x-jet-label for="tempat_lahir" value="{{ __('Tempat Lahir') }}" />
            <x-jet-input id="tempat_lahir" type="text" class="mt-1 block w-full" wire:model.defer="tempat_lahir" required />
        </div>

        <!-- Jenis Kelamin -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <x-jet-label for="jenis_kelamin" value="{{ __('Jenis Kelamin') }}" />
            <select id="jenis_kelamin" class="py-2 px-3 mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="jenis_kelamin" wire:model.defer="jenis_kelamin" required>
                <option value=""></option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <div class="flex justify-center mt-8">
            <p class="text-sm">
                <b>Periksa kembali data yang Anda masukkan sebelum Anda menekan tombol buat.</b>
            </p>
        </div>
    </x-slot>
            
    <x-slot name="footer">
        <x-jet-secondary-button class="mr-3" wire:click="$set('confirmingEdit', false)" wire:loading.attr="disabled">
            {{ __('Kembali') }}
        </x-jet-secondary-button>
            
        <div wire:loading.remove>
            <x-jet-button class="bg-blue-500 hover:bg-blue-700" wire:click="update()" wire:loading.attr="disabled">
                {{ __('Perbarui') }}
            </x-jet-button>
        </div>
    </x-slot>
</x-jet-dialog-modal>
