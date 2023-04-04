<?php

namespace App\Http\Livewire;

// use Livewire\Component;
use App\Models\Pasien;
use App\Models\Daerah;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Pasiens extends LivewireDatatable
{
    public $pasien_id, $nama, $alamat, $telepon, $rt, $rw, $kelurahan, $kecamatan, $kota, $tanggal_lahir, $tempat_lahir, $jenis_kelamin;

    // modal
    public $confirmingAdd = false;
    public $confirmingEdit = false;

    // identitas page
    public $identity = 'pasien';

    // datatable livewire
    public $exportable = true;

    public function builder()
    {
        return Pasien::latest();
    }

    public function columns()
    {
        $this->daerah = Daerah::get();

        return [
            Column::callback(['id'], function ($id) {
                return view('livewire.components.table-actions', ['id' => $id, 'identity' => 'pasien']);
            })->unsortable()
            ->alignCenter(),

            NumberColumn::name('id_pasien')
                ->label('ID Pasien')
                ->searchable()
                ->alignCenter(),

            Column::name('nama')
                ->label('Nama')
                ->alignCenter()
                ->searchable(),

            Column::name('alamat')
                ->label('Alamat')
                ->unsortable()
                ->alignCenter(),

            Column::name('telepon')
                ->label('Telepon')
                ->unsortable()
                ->alignCenter(),

            Column::name('rt')
                ->label('RT')
                ->unsortable()
                ->alignCenter(),

            Column::name('rw')
                ->label('RW')
                ->unsortable()
                ->alignCenter(),

            Column::name('kelurahan')
                ->label('Kelurahan')
                ->filterable()
                ->alignCenter(),

            Column::name('kecamatan')
                ->label('Kecamatan')
                ->filterable()
                ->alignCenter(),

            Column::name('kota')
                ->label('Kota')
                ->filterable()
                ->alignCenter(),

            DateColumn::name('tanggal_lahir')
                ->label('Tanggal Lahir')
                ->filterable()
                ->alignCenter(),

            Column::name('tempat_lahir')
                ->label('Tempat Lahir')
                ->filterable()
                ->alignCenter(),

            Column::name('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->filterable()
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
        $auth = Pasien::findOrFail($id);
        $this->pasien_id      = $id;
        $this->nama           = $auth->nama;
        $this->alamat         = $auth->alamat;
        $this->telepon        = $auth->telepon;
        $this->rt             = $auth->rt;
        $this->rw             = $auth->rw;
        $this->kelurahan      = Daerah::where('kota', '=', $auth->kota)->where('kecamatan', '=', $auth->kecamatan)->where('kelurahan', '=', $auth->kelurahan)->get('id')->max('id');
        $this->tanggal_lahir  = $auth->tanggal_lahir;
        $this->tempat_lahir   = $auth->tempat_lahir;
        $this->jenis_kelamin  = $auth->jenis_kelamin;
        $this->confirmingEdit = true;
    }

    // action print
    public function confirmPrint($id)
    {
        $auth = Pasien::findOrFail($id);

        // edit template docx
        $data = new \PhpOffice\PhpWord\TemplateProcessor('template/biodata-pasien.docx');

        $data->setValue('tanggal', Carbon::parse(Carbon::now())->translatedFormat('d F Y, H:i:s'));
        $data->setValue('id_pasien', $auth->id_pasien);
        $data->setValue('nama', $auth->nama);
        $data->setValue('tempat_lahir', $auth->tempat_lahir);
        $data->setValue('tanggal_lahir', $auth->tanggal_lahir);
        $data->setValue('jenis_kelamin', $auth->jenis_kelamin);
        $data->setValue('alamat', $auth->alamat);
        $data->setValue('rt', $auth->rt);
        $data->setValue('rw', $auth->rw);
        $data->setValue('kelurahan', $auth->kelurahan);
        $data->setValue('kecamatan', $auth->kecamatan);
        $data->setValue('kota', $auth->kota);
        $data->setValue('telepon', $auth->telepon);
        $data->setValue('created_at', $auth->created_at);
        $data->setValue('updated_at', $auth->updated_at);

        $idPasien = $auth->id_pasien;
        $saveDocPath = 'print/biodatapasien-'.$idPasien.'.docx';
        $data->saveAs($saveDocPath);

        return redirect()->route('biopasien.cetak', ['value' => $saveDocPath]);
    }

    // download docx
    public function cetak($cetak)
    {
        $path = "{$cetak}";
        return Storage::download($path);
    }

    // memastikan input kosong sebelum modal tampil
    private function resetCreateForm()
    {
        $this->pasien_id      = null;
        $this->nama           = '';
        $this->alamat         = '';
        $this->telepon        = '';
        $this->rt             = '';
        $this->rw             = '';
        $this->kelurahan      = '';
        $this->kecamatan      = '';
        $this->kota           = '';
        $this->tanggal_lahir  = '';
        $this->tempat_lahir   = '';
        $this->jenis_kelamin  = '';
    }

    // create data dan menampilkan notifikasi berhasil atau gagal membuat data
    public function store()
    {
        try
        {
            $this->validate([
                'nama'           => 'required',
                'alamat'         => 'required',
                'telepon'        => 'required',
                'rt'             => 'required',
                'rw'             => 'required',
                'tanggal_lahir'  => 'required',
                'tempat_lahir'   => 'required',
                'jenis_kelamin'  => 'required',
            ]);
            
            $daerah = Daerah::where('id', '=', $this->kelurahan)->first();

            Pasien::create([
                'id_pasien'      => Pasien::get('id_pasien')->max('id_pasien') > 0 ? (
                    Pasien::whereYear('created_at', '=', Carbon::now()->year)->whereMonth('created_at', '=', Carbon::now()->month)->get('id_pasien')->max('id_pasien') > 0 ? Pasien::whereYear('created_at', '=', Carbon::now()->year)->whereMonth('created_at', '=', Carbon::now()->month)->get('id_pasien')->max('id_pasien') + 1 : date('ym').'000001'
                    ) : date('ym').'000001',
                'nama'           => $this->nama,
                'alamat'         => $this->alamat,
                'telepon'        => $this->telepon,
                'rt'             => $this->rt,
                'rw'             => $this->rw,
                'kelurahan'      => $daerah->kelurahan,
                'kecamatan'      => $daerah->kecamatan,
                'kota'           => $daerah->kota,
                'tanggal_lahir'  => $this->tanggal_lahir,
                'tempat_lahir'   => $this->tempat_lahir,
                'jenis_kelamin'  => $this->jenis_kelamin,
                
            ]);

            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Data Pasien berhasil dibuat."
            ]);

            $this->resetCreateForm();
            $this->confirmingAdd = false;
            return redirect()->route('pasien');
        }
        
        catch(\Exception $e)
        {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Data Pasien gagal dibuat."
            ]);

            $this->resetCreateForm();
            $this->confirmingAdd = false;
            return redirect()->route('pasien');
        }
    }

    // edit data dan menampilkan notifikasi berhasil atau gagal memperbarui data
    public function update()
    {
        try
        {
            $this->validate([
                'nama'           => 'required',
                'alamat'         => 'required',
                'telepon'        => 'required',
                'rt'             => 'required',
                'rw'             => 'required',
                'tanggal_lahir'  => 'required',
                'tempat_lahir'   => 'required',
                'jenis_kelamin'  => 'required',
            ]);

            $daerah = Daerah::where('id', '=', $this->kelurahan)->first();

            Pasien::updateOrCreate(['id' => $this->pasien_id], [
                'nama'           => $this->nama,
                'alamat'         => $this->alamat,
                'telepon'        => $this->telepon,
                'rt'             => $this->rt,
                'rw'             => $this->rw,
                'kelurahan'      => $daerah->kelurahan,
                'kecamatan'      => $daerah->kecamatan,
                'kota'           => $daerah->kota,
                'tanggal_lahir'  => $this->tanggal_lahir,
                'tempat_lahir'   => $this->tempat_lahir,
                'jenis_kelamin'  => $this->jenis_kelamin,
            ]);

            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Data Pasien berhasil diperbarui."
            ]);

            $this->confirmingEdit = false;
            return redirect()->route('pasien');
        }
        
        catch(\Exception $e)
        {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Data Pasien gagal diperbarui."
            ]);

            $this->confirmingEdit = false;
            return redirect()->route('pasien');
        }
    }
}
