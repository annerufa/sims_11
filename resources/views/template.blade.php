<!doctype html>

<html lang="en" class="layout-menu-fixed layout-compact" dir="ltr" data-skin="default" data-assets-path="../assets/"
  data-template="vertical-menu-template" data-bs-theme="light">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Demo: Tables - Basic Tables | Sneat - Bootstrap Dashboard FREE</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="../assets/vendor/fonts/iconify-icons.css" />

  <!-- Core CSS -->
  <!-- build:css assets/vendor/css/theme.css  -->

  <link rel="stylesheet" href="../assets/vendor/libs/pickr/pickr-themes.css" />

  <link rel="stylesheet" href="../assets/vendor/css/core.css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- endbuild -->
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/flatpickr/flatpickr.css" />


  <!-- Row Group CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
  <!-- Form Validation -->
  <link rel="stylesheet" href="../assets/vendor/libs/@form-validation/form-validation.css" />


  <!-- Page CSS -->

  <!-- Helpers, Konfigurasi, dan Template Customizer -->
  <script src="../assets/vendor/js/helpers.js"></script>
  <script src="../assets/vendor/js/template-customizer.js"></script>
  <script src="../assets/js/config.js"></script>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->

      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
              <img src="../assets/img/logo kecil.png" style="width: 80%;padding-left: 20%;">
            </span>
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
          </a>
        </div>

        <div class="menu-divider mt-0"></div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">
          <!-- Dashboards -->
          <li class="menu-item">
            <a href="" class="menu-link">
              <i class="menu-icon tf-icons bx bx-home-smile"></i>
              <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
              <!-- <span class="badge rounded-pill bg-danger ms-auto">5</span> -->
            </a>
          </li>

          <!-- Apps & Pages -->
          <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Managemen Surat Masuk</span>
          </li>
          <li class="menu-item">
            <a href="" target="_blank" class="menu-link">
              <i class="menu-icon tf-icons bx bx-envelope"></i>
              <div class="text-truncate" data-i18n="Email">Surat Masuk</div>
              <span class="badge rounded-pill bg-danger ms-auto">5</span>
              <!-- <div class="badge rounded-pill bg-label-primary text-uppercase fs-tiny ms-auto">Pro</div> -->
            </a>
          </li>
          <li class="menu-item">
            <a href="icons-boxicons.html" class="menu-link">
              <i class="menu-icon tf-icons bx bx-book-open"></i>
              <div class="text-truncate" data-i18n="Boxicons">Agenda</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="icons-boxicons.html" class="menu-link">
              <i class="menu-icon tf-icons bx bx-run"></i>
              <div class="text-truncate" data-i18n="Boxicons">Disposisi</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="icons-boxicons.html" class="menu-link">
              <i class="menu-icon tf-icons bx bxs-buildings"></i>
              <div class="text-truncate" data-i18n="Boxicons">Data Instansi</div>
            </a>
          </li>
          <!-- Apps & Pages -->
          <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Profil</span>
          </li>
          <li class="menu-item">
            <a href="icons-boxicons.html" class="menu-link">
              <i class="menu-icon tf-icons bx bx-bxs-face"></i>
              <div class="text-truncate" data-i18n="Boxicons">Profil</div>
            </a>
          </li>

        </ul>
      </aside>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->

        <nav
          class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
          id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
              <i class="icon-base bx bx-menu icon-md"></i>
            </a>
          </div>

          <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
            <!-- Search -->
            <div class="navbar-nav align-items-center me-auto">
              <div class="nav-item d-flex align-items-center">
                <!-- <span class="w-px-22 h-px-22"><i class="icon-base bx bx-search icon-md"></i></span> -->
                <!-- <span class="w-px-22 h-px-22"></span> -->
                <b><span>Surat Masuk</span></b>
              </div>
            </div>
            <!-- /Search -->
            <ul class="navbar-nav flex-row align-items-center ms-md-auto">

              <!-- Notification -->
              <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                  data-bs-auto-close="outside" aria-expanded="false">
                  <span class="position-relative">
                    <i class="icon-base bx bx-bell icon-md"></i>
                    <span class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
                  </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-0">
                  <li class="dropdown-menu-header border-bottom">
                    <div class="dropdown-header d-flex align-items-center py-3">
                      <h6 class="mb-0 me-auto">Notification</h6>
                      <div class="d-flex align-items-center h6 mb-0">
                        <span class="badge bg-label-primary me-2">8 New</span>
                        <a href="javascript:void(0)" class="dropdown-notifications-all p-2" data-bs-toggle="tooltip"
                          data-bs-placement="top" aria-label="Mark all as read"
                          data-bs-original-title="Mark all as read"><i
                            class="icon-base bx bx-envelope-open text-heading"></i></a>
                      </div>
                    </div>
                  </li>
                  <li class="dropdown-notifications-list scrollable-container ps ps--active-y">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item list-group-item-action dropdown-notifications-item">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar">
                              <img src="../assets/img/avatars/1.png" alt="" class="rounded-circle">
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="small mb-0">Congratulation Lettie 🎉</h6>
                            <small class="mb-1 d-block text-body">Won the monthly best seller gold badge</small>
                            <small class="text-body-secondary">1h ago</small>
                          </div>
                          <div class="flex-shrink-0 dropdown-notifications-actions">
                            <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                class="badge badge-dot"></span></a>
                            <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                class="icon-base bx bx-x"></span></a>
                          </div>
                        </div>
                      </li>
                      <li class="list-group-item list-group-item-action dropdown-notifications-item">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar">
                              <span class="avatar-initial rounded-circle bg-label-danger">CF</span>
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="small mb-0">Charles Franklin</h6>
                            <small class="mb-1 d-block text-body">Accepted your connection</small>
                            <small class="text-body-secondary">12hr ago</small>
                          </div>
                          <div class="flex-shrink-0 dropdown-notifications-actions">
                            <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                class="badge badge-dot"></span></a>
                            <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                class="icon-base bx bx-x"></span></a>
                          </div>
                        </div>
                      </li>
                      <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar">
                              <img src="../assets/img/avatars/2.png" alt="" class="rounded-circle">
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="small mb-0">New Message ✉️</h6>
                            <small class="mb-1 d-block text-body">You have new message from Natalie</small>
                            <small class="text-body-secondary">1h ago</small>
                          </div>
                          <div class="flex-shrink-0 dropdown-notifications-actions">
                            <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                class="badge badge-dot"></span></a>
                            <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                class="icon-base bx bx-x"></span></a>
                          </div>
                        </div>
                      </li>
                      <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar">
                              <img src="../assets/img/avatars/1.png" alt="" class="rounded-circle">
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="small mb-0">Application has been approved 🚀</h6>
                            <small class="mb-1 d-block text-body">Your ABC project application has been
                              approved.</small>
                            <small class="text-body-secondary">2 days ago</small>
                          </div>
                          <div class="flex-shrink-0 dropdown-notifications-actions">
                            <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                class="badge badge-dot"></span></a>
                            <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                class="icon-base bx bx-x"></span></a>
                          </div>
                        </div>
                      </li>
                    </ul>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                      <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; right: 0px; height: 480px;">
                      <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 254px;"></div>
                    </div>
                  </li>
                  <li class="border-top">
                    <div class="d-grid p-4">
                      <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                        <small class="align-middle">View all notifications</small>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>
              <!--/ Notification -->

              <!-- User -->
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar avatar-online">
                    <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="#">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar avatar-online">
                            <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <h6 class="mb-0">John Doe</h6>
                          <small class="text-body-secondary">Admin</small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider my-1"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <i class="icon-base bx bx-user icon-md me-3"></i><span>My Profile</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <i class="icon-base bx bx-cog icon-md me-3"></i><span>Settings</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <span class="d-flex align-items-center align-middle">
                        <i class="flex-shrink-0 icon-base bx bx-credit-card icon-md me-3"></i><span
                          class="flex-grow-1 align-middle">Billing Plan</span>
                        <span class="flex-shrink-0 badge rounded-pill bg-danger">4</span>
                      </span>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider my-1"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Log Out</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!--/ User -->
            </ul>
          </div>
        </nav>

        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Hoverable Table rows -->
            <div class="card">
              <h5 class="card-header">Hoverable rows</h5>
              <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Tgl Masuk Surat</th>
                      <th>Agenda</th>
                      <th>Hal</th>
                      <th>Pengirim</th>
                      <th>Status Berkas</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                    <tr>
                      <td>
                        <i class="icon-base bx bxl-angular icon-md text-danger me-4"></i> <span>Angular Project</span>
                      </td>
                      <td>Albert Cook</td>
                      <td>
                        <ul class="list-unstyled m-0 avatar-group d-flex align-items-center">
                          <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up" title="Lilian Fuller">
                            <img src="../assets/img/avatars/2.png" alt="Avatar" class="rounded-circle" />
                          </li>
                          <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                            <img src="../assets/img/avatars/3.png" alt="Avatar" class="rounded-circle" />
                          </li>
                          <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up" title="Christina Parker">
                            <a href="home.html">
                              <img src="../assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                            </a>
                          </li>
                        </ul>
                      </td>
                      <td><span class="badge bg-label-primary me-1">Active</span></td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="icon-base bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0);"><i
                                class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                            <a class="dropdown-item" href="javascript:void(0);"><i
                                class="icon-base bx bx-trash me-1"></i> Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <i class="icon-base bx bxl-react icon-md text-info me-4"></i> <span>React Project</span>
                      </td>
                      <td>Barry Hunter</td>
                      <td>
                        <ul class="list-unstyled m-0 avatar-group d-flex align-items-center">
                          <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up" title="Lilian Fuller">
                            <img src="../assets/img/avatars/2.png" alt="Avatar" class="rounded-circle" />
                          </li>
                          <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                            <img src="../assets/img/avatars/3.png" alt="Avatar" class="rounded-circle" />
                          </li>
                          <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up" title="Christina Parker">
                            <img src="../assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                          </li>
                        </ul>
                      </td>
                      <td><span class="badge bg-label-success me-1">Completed</span></td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="icon-base bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0);"><i
                                class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                            <a class="dropdown-item" href="javascript:void(0);"><i
                                class="icon-base bx bx-trash me-1"></i> Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <i class="icon-base bx bxl-vuejs icon-md text-success me-4"></i> <span>VueJs Project</span>
                      </td>
                      <td>Trevor Baker</td>
                      <td>
                        <ul class="list-unstyled m-0 avatar-group d-flex align-items-center">
                          <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up" title="Lilian Fuller">
                            <img src="../assets/img/avatars/2.png" alt="Avatar" class="rounded-circle" />
                          </li>
                          <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                            <img src="../assets/img/avatars/3.png" alt="Avatar" class="rounded-circle" />
                          </li>
                          <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up" title="Christina Parker">
                            <img src="../assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                          </li>
                        </ul>
                      </td>
                      <td><span class="badge bg-label-info me-1">Scheduled</span></td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="icon-base bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0);"><i
                                class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                            <a class="dropdown-item" href="javascript:void(0);"><i
                                class="icon-base bx bx-trash me-1"></i> Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <i class="icon-base bx bxl-bootstrap icon-md text-primary me-4"></i>
                        <span>Bootstrap Project</span>
                      </td>
                      <td>Jerry Milton</td>
                      <td>
                        <ul class="list-unstyled m-0 avatar-group d-flex align-items-center">
                          <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up" title="Lilian Fuller">
                            <img src="../assets/img/avatars/2.png" alt="Avatar" class="rounded-circle" />
                          </li>
                          <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                            <img src="../assets/img/avatars/3.png" alt="Avatar" class="rounded-circle" />
                          </li>
                          <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up" title="Christina Parker">
                            <img src="../assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                          </li>
                        </ul>
                      </td>
                      <td><span class="badge bg-label-warning me-1">Pending</span></td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="icon-base bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0);"><i
                                class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                            <a class="dropdown-item" href="javascript:void(0);"><i
                                class="icon-base bx bx-trash me-1"></i> Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!--/ Hoverable Table rows -->
          </div>

        </div>
        <!-- / Layout wrapper -->


        <!-- Core JS -->

        <script src="../assets/vendor/libs/jquery/jquery.js"></script>

        <script src="../assets/vendor/libs/popper/popper.js"></script>
        <script src="../assets/vendor/js/bootstrap.js"></script>
        <script src="../assets/vendor/libs/@algolia/autocomplete-js.js"></script>



        <script src="../assets/vendor/libs/pickr/pickr.js"></script>



        <script src="../assets/vendor/libs/hammer/hammer.js"></script>


        <script src="../assets/vendor/js/menu.js"></script>

        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
        <!-- Flat Picker -->
        <script src="../assets/vendor/libs/moment/moment.js"></script>
        <script src="../assets/vendor/libs/flatpickr/flatpickr.js"></script>

        <!-- Form Validation -->
        <script src="../assets/vendor/libs/@form-validation/popular.js"></script>
        <script src="../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
        <script src="../assets/vendor/libs/@form-validation/auto-focus.js"></script>
        <!-- Main JS -->


        <!-- i18next dan Http Backend untuk multi bahasa -->
        <script src="../assets/vendor/libs/i18n/i18n.js"></script>

        <!-- Vendor tambahan yang dibutuhkan -->
        <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
        <!-- <script src="../assets/vendor/libs/node-waves/waves.js"></script> -->


        <!-- Main JavaScript utama -->
        <script src="../assets/mainn.js"></script>
        <script src="../assets/js/dt.js"></script>

        <!-- Page JS -->
        <!-- <script src="../assets/tables-datatables-basic.js"></script> -->

        <!-- Place this tag before closing body tag for github widget button. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>