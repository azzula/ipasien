<div class="flex space-x-1 justify-around">
    @if($identity === 'pasien')
        <button class="p-1 text-green-600 hover:bg-green-600 hover:text-white rounded" wire:click="confirmPrint({{ $id }})" title="Cetak">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-printer-fill w-5 h-5" viewBox="0 0 16 16">
                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
            </svg>
        </button>
    @endif

    <button class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded" wire:click="confirmEdit({{ $id }})" title="Edit">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
    </button>

    @include('datatables::delete', ['value' => $id])
</div>
