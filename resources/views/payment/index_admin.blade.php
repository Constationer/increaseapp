@extends('app')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Dashboard</div>
                    <div class="breadcrumb-item">Data</div>
                    <div class="breadcrumb-item">Payment</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Payment</h4>
                            </div>
                            <div class="card-body">
                                <table class="table" id="data-table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Team Name</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Stage Name</th>
                                            <th scope="col">Method</th>
                                            <th scope="col">Photo</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" style="nowrap">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('dataTable')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(function() {
                $('#data-table').DataTable({
                    "language": {
                        "search": "Cari:",
                        "lengthMenu": "Tampilkan _MENU_ data per halaman",
                        "zeroRecords": "Tidak Ada Data yang Cocok",
                        "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                        "infoEmpty": "Tidak Ada Data yang Tersedia",
                        "infoFiltered": "(disaring dari _MAX_ jumlah data)"
                    },
                    "pageLength": 10,
                    scrollX: true,
                    processing: true,
                    serverSide: true,
                    dom: 'Blfrtip',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    ajax: '{{ route('payment.getData') }}',
                    columns: [{
                            data: 'null',
                            name: 'rowIndex',
                            searchable: false,
                            orderable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'user_id',
                            name: 'user_id',
                            render: function(data, type, row) {
                                return row.user.team
                            }
                        },
                        {
                            data: 'category',
                            name: 'category'
                        },
                        {
                            data: 'stage',
                            name: 'stage'
                        },
                        {
                            data: 'method',
                            name: 'method'
                        },
                        {
                            data: 'photo',
                            name: 'photo'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        }
                    ],
                    order: []
                });
            });
        </script>
        <script>
            function approvePayment(paymentId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, approve it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/payment/${paymentId}/approve`, {
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            }).then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Redirect to the member index page after successful deletion
                                    Swal.fire('Approved!', data.message, 'success').then(() => {
                                        window.location = '{{ route('payment.index') }}';
                                    });
                                } else {
                                    // Handle server-side error
                                    Swal.fire('Error', data.message, 'error');
                                }
                            }).catch(error => {
                                // Handle fetch error
                                Swal.fire('Error', 'Failed to approve payment.', 'error');
                            });
                    }
                });
            }
        </script>
        <script>
            function rejectPayment(paymentId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, reject it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/payment/${paymentId}/reject`, {
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            }).then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Redirect to the member index page after successful deletion
                                    Swal.fire('Approved!', data.message, 'success').then(() => {
                                        window.location = '{{ route('payment.index') }}';
                                    });
                                } else {
                                    // Handle server-side error
                                    Swal.fire('Error', data.message, 'error');
                                }
                            }).catch(error => {
                                // Handle fetch error
                                Swal.fire('Error', 'Failed to reject payment.', 'error');
                            });
                    }
                });
            }
        </script>
    @endpush
@endsection
