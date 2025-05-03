@extends('layout.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row g-6">
                <!-- Card Border Shadow -->
                <div class="col-lg-4 col-sm-6">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="icon-base bx bxs-envelope icon-lg"></i></span>
                                </div>
                                <h4 class="mb-0">12</h4>
                            </div>
                            <p class="mb-2">Surat Masuk</p>
                            {{-- <p class="mb-0">
                            <span class="text-heading fw-medium me-2">+18.2%</span>
                            <span class="text-body-secondary">than last week</span>
                        </p> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card card-border-shadow-warning h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded bg-label-warning"><i
                                            class="icon-base bx bx-receipt icon-lg"></i></span>
                                </div>
                                <h4 class="mb-0">8</h4>
                            </div>
                            <p class="mb-2">Pengajuan Surat</p>
                            {{-- <p class="mb-0">
                            <span class="text-heading fw-medium me-2">-8.7%</span>
                            <span class="text-body-secondary">than last week</span>
                        </p> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card card-border-shadow-danger h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded bg-label-danger"><i
                                            class="icon-base bx bx-mail-send icon-lg"></i></span>
                                </div>
                                <h4 class="mb-0">17</h4>
                            </div>
                            <p class="mb-2">Surat Keluar</p>
                            {{-- <p class="mb-0">
                            <span class="text-heading fw-medium me-2">+4.3%</span>
                            <span class="text-body-secondary">than last week</span>
                        </p> --}}
                        </div>
                    </div>
                </div>
                <!--/ Card Border Shadow -->

                <!--/ Reasons for delivery exceptions -->
                <!-- Orders by Countries -->
                <div class="col-xxl-4 col-lg-12">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title mb-0">
                                <h5 class="mb-1">Data Surat Bulan ini</h5>
                                {{-- <p class="card-subtitle">62 deliveries in progress</p> --}}
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="nav-align-top">
                                <ul class="nav nav-tabs nav-fill rounded-0 timeline-indicator-advanced" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-new" aria-controls="navs-justified-new"
                                            aria-selected="true">Surat Masuk</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-link-preparing"
                                            aria-controls="navs-justified-link-preparing" aria-selected="false"
                                            tabindex="-1">Draft Pengajuan</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-link-shipping"
                                            aria-controls="navs-justified-link-shipping" aria-selected="false"
                                            tabindex="-1">Surat Keluar</button>
                                    </li>
                                </ul>
                                <div class="tab-content border-0  mx-1">
                                    <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
                                        <ul class="timeline mb-0">
                                            <li class="timeline-item ps-6 border-left-dashed">
                                                <span
                                                    class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                    <i class="icon-base bx bx-map"></i>
                                                </span>
                                                <div class="timeline-event ps-1">
                                                    <div class="timeline-header">
                                                        <small class="text-success text-uppercase">Pengirim</small>
                                                    </div>
                                                    <h6 class="my-50">Dinas Pendidikan Kota Blitar</h6>
                                                    <p class="text-body mb-0">Surat Undangan</p>
                                                </div>
                                            </li>
                                            <li class="timeline-item ps-6 border-transparent">
                                                <span
                                                    class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                    <i class="icon-base bx bx-check-circle"></i>
                                                </span>
                                                <div class="timeline-event ps-1">
                                                    <div class="timeline-header">
                                                        <small class="text-primary text-uppercase">Telah diterima</small>
                                                    </div>
                                                    <h6 class="my-50">Kepala Sekolah</h6>
                                                    <p class="text-body mb-0">12/03/2025</p>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="border-1 border-light border-dashed my-4"></div>
                                        <ul class="timeline mb-0">
                                            <li class="timeline-item ps-6 border-left-dashed">
                                                <span
                                                    class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                    <i class="icon-base bx bx-map"></i>
                                                </span>
                                                <div class="timeline-event ps-1">
                                                    <div class="timeline-header">
                                                        <small class="text-success text-uppercase">Pengirim</small>
                                                    </div>
                                                    <h6 class="my-50">Veronica Herman</h6>
                                                    <p class="text-body mb-0">162 Windsor, California(CA), 95492</p>
                                                </div>
                                            </li>
                                            <li class="timeline-item ps-6 border-transparent">
                                                <span
                                                    class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                    <i class="icon-base bx bx-map"></i>
                                                </span>
                                                <div class="timeline-event ps-1">
                                                    <div class="timeline-header">
                                                        <small class="text-primary text-uppercase">Receiver</small>
                                                    </div>
                                                    <h6 class="my-50">Helen Jacobs</h6>
                                                    <p class="text-body mb-0">487 Sunset, California(CA), 94043</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="navs-justified-link-preparing" role="tabpanel">
                                        <ul class="timeline mb-0">
                                            <li class="timeline-item ps-6 border-left-dashed">
                                                <span
                                                    class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                    <i class="icon-base bx bx-check-circle"></i>
                                                </span>
                                                <div class="timeline-event ps-1">
                                                    <div class="timeline-header">
                                                        <small class="text-success text-uppercase">sender</small>
                                                    </div>
                                                    <h6 class="my-50">Barry Schowalter</h6>
                                                    <p class="text-body mb-0">939 Orange, California(CA), 92118</p>
                                                </div>
                                            </li>
                                            <li class="timeline-item ps-6 border-transparent border-left-dashed">
                                                <span
                                                    class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                    <i class="icon-base bx bx-map"></i>
                                                </span>
                                                <div class="timeline-event ps-1">
                                                    <div class="timeline-header">
                                                        <small class="text-primary text-uppercase">Receiver</small>
                                                    </div>
                                                    <h6 class="my-50">Myrtle Ullrich</h6>
                                                    <p class="text-body mb-0">101 Boulder, California(CA), 95959</p>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="border-1 border-light border-dashed my-4"></div>
                                        <ul class="timeline mb-0">
                                            <li class="timeline-item ps-6 border-left-dashed">
                                                <span
                                                    class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                    <i class="icon-base bx bx-check-circle"></i>
                                                </span>
                                                <div class="timeline-event ps-1">
                                                    <div class="timeline-header">
                                                        <small class="text-success text-uppercase">sender</small>
                                                    </div>
                                                    <h6 class="my-50">Veronica Herman</h6>
                                                    <p class="text-body mb-0">162 Windsor, California(CA), 95492</p>
                                                </div>
                                            </li>
                                            <li class="timeline-item ps-6 border-transparent">
                                                <span
                                                    class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                    <i class="icon-base bx bx-map"></i>
                                                </span>
                                                <div class="timeline-event ps-1">
                                                    <div class="timeline-header">
                                                        <small class="text-primary text-uppercase">Receiver</small>
                                                    </div>
                                                    <h6 class="my-50">Helen Jacobs</h6>
                                                    <p class="text-body mb-0">487 Sunset, California(CA), 94043</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="navs-justified-link-shipping" role="tabpanel">
                                        <ul class="timeline mb-0">
                                            <li class="timeline-item ps-6 border-left-dashed">
                                                <span
                                                    class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                    <i class="icon-base bx bx-check-circle"></i>
                                                </span>
                                                <div class="timeline-event ps-1">
                                                    <div class="timeline-header">
                                                        <small class="text-success text-uppercase">sender</small>
                                                    </div>
                                                    <h6 class="my-50">Veronica Herman</h6>
                                                    <p class="text-body mb-0">101 Boulder, California(CA), 95959</p>
                                                </div>
                                            </li>
                                            <li class="timeline-item ps-6 border-transparent">
                                                <span
                                                    class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                    <i class="icon-base bx bx-map"></i>
                                                </span>
                                                <div class="timeline-event ps-1">
                                                    <div class="timeline-header">
                                                        <small class="text-primary text-uppercase">Receiver</small>
                                                    </div>
                                                    <h6 class="my-50">Barry Schowalter</h6>
                                                    <p class="text-body mb-0">939 Orange, California(CA), 92118</p>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="border-1 border-light border-dashed my-4"></div>
                                        <ul class="timeline mb-0">
                                            <li class="timeline-item ps-6 border-left-dashed">
                                                <span
                                                    class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                    <i class="icon-base bx bx-check-circle"></i>
                                                </span>
                                                <div class="timeline-event ps-1">
                                                    <div class="timeline-header">
                                                        <small class="text-success text-uppercase">sender</small>
                                                    </div>
                                                    <h6 class="my-50">Myrtle Ullrich</h6>
                                                    <p class="text-body mb-0">162 Windsor, California(CA), 95492</p>
                                                </div>
                                            </li>
                                            <li class="timeline-item ps-6 border-transparent">
                                                <span
                                                    class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                    <i class="icon-base bx bx-map"></i>
                                                </span>
                                                <div class="timeline-event ps-1">
                                                    <div class="timeline-header">
                                                        <small class="text-primary text-uppercase">Receiver</small>
                                                    </div>
                                                    <h6 class="my-50">Helen Jacobs</h6>
                                                    <p class="text-body mb-0">487 Sunset, California(CA), 94043</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Orders by Countries -->
                <!--/ On route vehicles Table -->
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush
