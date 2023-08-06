@extends('app')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            @role('Admin')
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-3 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="far fa-user"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Member</h4>
                                </div>
                                <div class="card-body">
                                    {{ $totalMember }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="far fa-credit-card"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Payment Pending</h4>
                                </div>
                                <div class="card-body">
                                    {{ $totalPayment }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="far fa-file"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total File</h4>
                                </div>
                                <div class="card-body">
                                    {{ $totalProposal }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-circle"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Announcement</h4>
                                </div>
                                <div class="card-body">
                                    {{ $totalAnnouncement }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endrole
            <h2 class="section-title">Announcement</h2>
            <p class="section-lead">
                This is announcement for you all.
            </p>
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="card card-primary">
                        @foreach ($announcement as $key)
                            <div class="card-header">
                                <h2>{{ $key->judul }}</h2>
                            </div>
                            <div class="card-body">
                                {!! Str::limit($key->isi, 350) !!}
                            </div>
                            <div class="card-footer">
                                <a href="#" class="btn btn-primary read-more-btn" data-toggle="modal"
                                    data-target="#announcementModal" data-content="{!! htmlspecialchars($key->isi) !!}">
                                    Read More
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="announcementModal" tabindex="-1" role="dialog" aria-labelledby="announcementModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="announcementModalLabel">Announcement Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="announcementContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            // Attach a click event to the "Read More" button
            $('.read-more-btn').on('click', function() {
                // Get the content from the data attribute of the clicked button
                var content = $(this).data('content');

                // Set the content inside the modal
                $('#announcementContent').html(content);
            });
        </script>
    @endpush
@endsection
