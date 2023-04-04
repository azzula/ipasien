<?php

namespace App\Http\Livewire;

// use Livewire\Component;
use App\Models\Daerah;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Daerahs extends LivewireDatatable
{
    public $daerah_id, $kelurahan, $kecamatan, $kota;

    // modal
    public $confirmingAdd = false;
    public $confirmingEdit = false;

    // identitas page
    public $identity = 'daerah';

    // datatable livewire
    public $exportable = true;

    public function builder()
    {
        return Daerah::latest();
    }

    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label('ID Daerah')
                ->unsortable()
                ->alignCenter(),

            Column::name('kelurahan')
                ->label('Kelurahan')
                ->alignCenter()
                ->searchable(),

            Column::name('kecamatan')
                ->label('Kecamatan')
                ->alignCenter()
                ->searchable(),

            Column::name('kota')
                ->label('Kota')
                ->alignCenter()
                ->searchable(),

            Column::callback(['id'], function ($id) {
                return view('livewire.components.table-actions', ['id' => $id, 'identity' => 'daerah']);
            })->unsortable()
            ->alignCenter(),
        ];
    }

    // action sebelum modal tampil
    public function confirmAdd() 
    {
        $this->resetCreateForm();
        $this->confirmingAdd = true;
    }

    public function confirmEdit($id) 
    {
        $auth = Daerah::findOrFail($id);
        $this->daerah_id      = $id;
        $this->kelurahan      = $auth->kelurahan;
        $this->kecamatan      = $auth->kecamatan;
        $this->kota           = $auth->kota;
        $this->confirmingEdit = true;
    }

    // memastikan input kosong sebelum modal tampil
    private function resetCreateForm()
    {
        $this->daerah_id        = null;
        $this->kelurahan        = '';
        $this->kecamatan        = '';
        $this->kota             = '';
    }

    // create data dan menampilkan notifikasi berhasil atau gagal membuat data
    public function store()
    {
        try
        {
            $this->validate([
                'kelurahan' => 'required',
                'kecamatan' => 'required',
                'kota'      => 'required',
            ]);
            
            Daerah::create([
                'kelurahan' =>  $this->kelurahan,
                'kecamatan' =>  $this->kecamatan,
                'kota'      =>  $this->kota,
            ]);

            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Data Daerah berhasil dibuat."
            ]);

            $this->resetCreateForm();
            $this->confirmingAdd = false;
            return redirect()->route('daerah');
        }
        
        catch(\Exception $e)
        {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Data Daerah gagal dibuat."
            ]);

            $this->resetCreateForm();
            $this->confirmingAdd = false;
            return redirect()->route('daerah');
        }
    }

    // edit data dan menampilkan notifikasi berhasil atau gagal memperbarui data
    public function update()
    {
        try
        {
            $this->validate([
                'kelurahan' =>  'required',
                'kecamatan' =>  'required',
                'kota'      =>  'required',
            ]);

            Daerah::updateOrCreate(['id' => $this->daerah_id], [
                'kelurahan' =>  $this->kelurahan,
                'kecamatan' =>  $this->kecamatan,
                'kota'      =>  $this->kota,
            ]);

            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Data Daerah berhasil diperbarui."
            ]);

            $this->confirmingEdit = false;
            return redirect()->route('daerah');
        }
        
        catch(\Exception $e)
        {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Data Daerah gagal diperbarui."
            ]);

            $this->confirmingEdit = false;
            return redirect()->route('daerah');
        }
    }
}
