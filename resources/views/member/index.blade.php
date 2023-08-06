@extends('app')

@section('content')
    @if ($max >= 4)
        {{ $showAddButton = false }}
    @else
        {{ $showAddButton = true }}
    @endif
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Dashboard</div>
                    <div class="breadcrumb-item">Data</div>
                    <div class="breadcrumb-item">Member</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Member</h4>
                            </div>
                            <div class="card-body">
                                <table class="table" id="data-table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Team Name</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Gender</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Nationality</th>
                                            <th scope="col">University</th>
                                            <th scope="col">Major</th>
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
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
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
                    buttons: [
                        @if ($showAddButton)
                            {
                                text: '<i class="fas fa-plus"></i> Add Data',
                                className: 'btn btn-primary mb-2',
                                action: function(e, dt, node, config) {
                                    window.location.href = "{{ route('member.create') }}"
                                }
                            }
                        @else
                            {
                                text: '<i class="fas fa-plus"></i> Add Data',
                                className: 'btn btn-primary mb-2',
                                action: function(e, dt, node, config) {
                                    // Show the SweetAlert popup
                                    Swal.fire({
                                        title: 'Maximum Member',
                                        text: 'You have reach maxiumum member to add, you need to delete first.',
                                        icon: 'info',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            }
                        @endif
                    ],
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    ajax: '{{ route('member.getData') }}',
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
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'gender',
                            name: 'gender'
                        },
                        {
                            data: 'address',
                            name: 'address'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'nationality',
                            name: 'nationality'
                        },
                        {
                            data: 'university',
                            name: 'university'
                        },
                        {
                            data: 'major',
                            name: 'major'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'id',
                            render: function(data, type, row) {
                                return '<a href="/member/' + data +
                                    '/edit" class="btn btn-primary btn-edit"><i class="fas fa-edit"></i></a>' +
                                    '<button class="btn btn-danger" onclick="deleteMember(' + data +
                                    ')" ><i class="fas fa-trash"></i></button>';
                            }
                        }
                    ],
                    order: []
                });
            });
        </script>
        <script>
            function deleteMember(memberId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If user confirms, send the DELETE request to the delete route
                        fetch(`/member/${memberId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            }).then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Redirect to the member index page after successful deletion
                                    Swal.fire('Deleted!', data.message, 'success').then(() => {
                                        window.location = '{{ route('member.index') }}';
                                    });
                                } else {
                                    // Handle server-side error
                                    Swal.fire('Error', data.message, 'error');
                                }
                            }).catch(error => {
                                // Handle fetch error
                                Swal.fire('Error', 'Failed to delete member.', 'error');
                            });
                    }
                });
            }
        </script>
    @endpush
@endsection
