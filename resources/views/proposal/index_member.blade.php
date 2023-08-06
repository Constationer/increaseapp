@extends('app')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Proposal</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Dashboard</div>
                    <div class="breadcrumb-item">Data</div>
                    <div class="breadcrumb-item">Proposal</div>
                </div>
            </div>

            <div class="section-body">
                @if ($success == 1)
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success">
                                Proposal sudah berhasil diterima oleh Admin.
                            </div>
                        </div>
                    </div>
                @endif
                @if ($success != 1)
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="card">
                                <form action="{{ route('proposal.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-header">
                                        <h4>Data Proposal</h4>
                                    </div>
                                    <div class="card-body">
                                        @csrf
                                        <div class="form-group">
                                            <label>File Proposal</label>
                                            <input type="file" class="form-control" name="proposal"
                                                accept="application/pdf">
                                            @error('proposal')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
