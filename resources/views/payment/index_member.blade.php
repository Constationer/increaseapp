@extends('app')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Payment</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Dashboard</div>
                    <div class="breadcrumb-item">Data</div>
                    <div class="breadcrumb-item">Payment</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @if ($success == 1)
                            <div class="alert alert-success">
                                Pembayaranmu sudah berhasil diterima oleh Admin.
                            </div>
                        @elseif ($waiting == 1)
                            <div class="alert alert-warning">
                                Pembayaranmu sedang dicek oleh Admin.
                            </div>
                        @endif
                    </div>
                    <div class="col-12 col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Team Preview</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group text-center">
                                    <input type="text" class="form-control" name="team" id="team"
                                        value="{{ $team }}" disabled>
                                    @error('team')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-md">
                                        <tbody>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                            </tr>
                                            @foreach ($member as $key)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $key->name }}</td>
                                                    <td>{{ $key->email }}</td>
                                                    <td>{{ $key->phone }}</td>
                                                    <td>{{ $key->status }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($waiting != 1)
                        @if ($success != 1)
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="card">
                                    <form action="{{ route('payment.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-header">
                                            <h4>Form</h4>
                                        </div>
                                        <div class="card-body">
                                            @csrf
                                            <div class="form-group">
                                                <label>Method</label>
                                                <select class="form-control" name="method" id="methodSelect">
                                                    <option value="">Choose One</option>
                                                    <option value="GOPAY" {{ old('method') == 'GOPAY' ? 'selected' : '' }}>
                                                        GOPAY
                                                    </option>
                                                    <option value="MANDIRI"
                                                        {{ old('method') == 'MANDIRI' ? 'selected' : '' }}>
                                                        MANDIRI</option>
                                                    <option value="DANA" {{ old('method') == 'DANA' ? 'selected' : '' }}>
                                                        DANA
                                                    </option>
                                                </select>
                                                @error('method')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Account Number</label>
                                                <input type="text" class="form-control" name="accnumber" id="accnumber"
                                                    value="{{ old('accnumber') }}" disabled>
                                                @error('accnumber')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Account Name</label>
                                                <input type="text" class="form-control" name="accname" id="accname"
                                                    value="{{ old('accname') }}" disabled>
                                                @error('accname')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select class="form-control" name="category">
                                                    <option value="">Choose One</option>
                                                    <option value="Bussines Case Competition"
                                                        {{ old('category') == 'Bussines Case Competition' ? 'selected' : '' }}>
                                                        Bussines Case Competition
                                                    </option>
                                                </select>
                                                @error('category')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Stage Name</label>
                                                <select class="form-control" name="stage">
                                                    <option value="">Choose One</option>
                                                    <option value="Early Stage"
                                                        {{ old('stage') == 'Early Stage' ? 'selected' : '' }}>
                                                        Early Stage
                                                    </option>
                                                </select>
                                                @error('stage')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Photo</label>
                                                <input type="file" class="form-control" name="photo" accept="image/*">
                                                @error('photo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button class="btn btn-primary">Submit</button>
                                            <a href="{{ route('member.index') }}"
                                                class="btn btn-light-secondary me-1 mb-1">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </section>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {
                // Handle the change event of the method select
                $('#methodSelect').change(function() {
                    // Get the selected value
                    var selectedMethod = $(this).val();

                    // Define the mapping of method values to accnumber and accname values
                    var mapping = {
                        'GOPAY': {
                            accnumber: '0812345678',
                            accname: 'INDRI'
                        },
                        'MANDIRI': {
                            accnumber: '37283737282',
                            accname: 'YANTO'
                        },
                        'DANA': {
                            accnumber: '08123638484',
                            accname: 'SUEP'
                        }
                    };

                    // Set the accnumber and accname based on the selected method
                    if (mapping[selectedMethod]) {
                        $('#accnumber').val(mapping[selectedMethod].accnumber).prop('disabled', true);
                        $('#accname').val(mapping[selectedMethod].accname).prop('disabled', true);
                    } else {
                        $('#accnumber').val('').prop('disabled', true);
                        $('#accname').val('').prop('disabled', true);
                    }
                });
            });
        </script>
    @endpush
@endsection
