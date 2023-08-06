@extends('app')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Dashboard</div>
                    <div class="breadcrumb-item">Data</div>
                    <div class="breadcrumb-item">Create Announcement</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-6">
                        <div class="card">
                            <form action="{{ route('announcement.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header">
                                    <h4>Data Announcement</h4>
                                </div>
                                <div class="card-body">
                                    @csrf
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" class="form-control" name="judul"
                                            value="{{ old('judul') }}">
                                        @error('judul')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Isi</label>
                                        <textarea class="form-control" name="isi" id="isi">{{ old('isi') }}</textarea>
                                        @error('isi')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">Submit</button>
                                    <a href="{{ route('announcement.index') }}"
                                        class="btn btn-light-secondary me-1 mb-1">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('script')
        <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
        <script>
            // Initialize CKEditor on the "isi" textarea
            CKEDITOR.replace('isi', {
                // Customize the editor configuration here (if needed)
            });
        </script>
    @endpush
@endsection
