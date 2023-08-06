@extends('app')

@section('content')
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Edit Data</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">Dashboard</div>
        <div class="breadcrumb-item">Data</div>
        <div class="breadcrumb-item">Edit Pegawai</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-6">
          <div class="card">
            <form action="{{ route('Pegawai.update', ['id' => $data->id]) }}" method="POST" enctype="multipart/form-data">
              @method('PUT')
              @csrf
              <div class="card-header">
                <h4>Data Pegawai</h4>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>NIP</label>
                  <input type="text" class="form-control" name="nip" value="{{ $data->nip }}">
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" name="nama" value="{{ $data->nama }}">
                </div>
                <div class="form-group">
                  <label>OPD</label>
                  <select class="form-control" name="opd_id">
                    @foreach($opd as $data_opd)
                      <option value="{{ $data_opd->id }}" {{ ($data->opd_id == $data_opd->id) ? 'selected' : '' }}>{{ $data_opd->nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Golongan</label>
                  <select class="form-control" name="golongan">
                      <option value="III/A" {{ ($data->golongan == 'III/A') ? 'selected' : ''}}>III/A</option>
                      <option value="III/B" {{ ($data->golongan == 'III/B') ? 'selected' : ''}}>III/B</option>
                      <option value="III/C" {{ ($data->golongan == 'III/C') ? 'selected' : ''}}>III/C</option>
                      <option value="III/D" {{ ($data->golongan == 'III/D') ? 'selected' : ''}}>III/D</option>
                  </select>
                </div>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-primary">Submit</button>
                <a href="{{ route('Pegawai.index') }}"
                    class="btn btn-light-secondary me-1 mb-1">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection