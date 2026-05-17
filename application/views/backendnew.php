<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?> | <?= $company['company_name'] ?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>">
    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/backend/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/backend/') ?>css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
    <!-- Custom styles for this page -->
    <link href="<?= base_url('assets/backend/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/backend/') ?>css/select2.min.css" rel="stylesheet">
</head>

<body id="page-top" class="sidebar-toggled">
    <?php if ($user['email'] == '') {
        redirect('auth/logout');
    } ?>

    <?php if ($user['role_id'] == 2) {
        $this->session->set_flashdata('error', 'Akses dilarang');
        redirect('member');
    } ?>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul style="background-color: #171414;" class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('dashboard') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-wifi"></i>
                </div>
                <div class="sidebar-brand-text mx-3">My-Wifi </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?= $title == 'Dashboard'  ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Beranda</span></a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item <?= $title == 'Customer' | $title == 'Add Customer' | $title == 'Aktif' | $title == 'Non-Aktif' | $title == 'Waiting'   ? 'active' : '' ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomer" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-sitemap"></i>
                    <span>Pelanggan</span>
                </a>
                <div id="collapseCustomer" class="collapse <?= $title == 'Aktif' | $title == 'Non-Aktif' | $title == 'Customer' | $title == 'Waiting' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?= $title == 'Aktif'  ? 'active' : '' ?>" href="<?= site_url('customer/active') ?>">Aktif</a>
                        <a class="collapse-item <?= $title == 'Non-Aktif'  ? 'active' : '' ?>" href="<?= site_url('customer/nonactive') ?>">Non-Aktif</a>
                        <a class="collapse-item <?= $title == 'Waiting'  ? 'active' : '' ?>" href="<?= site_url('customer/wait') ?>">Menunggu</a>
                        <a class="collapse-item <?= $title == 'Customer'  ? 'active' : '' ?>" href="<?= site_url('customer') ?>">Semua</a>
                    </div>
                </div>
            </li>
            <li class="nav-item <?= $title == 'Coverage Area'  ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('coverage') ?>">
                    <i class="fas fa-fw fa-map"></i>
                    <span>Coverage Area</span></a>
            </li>

            <li class="nav-item <?= $title == 'Item Package' | $title == 'Category Package'  ? 'active' : '' ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-sitemap"></i>
                    <span>Layanan</span>
                </a>
                <div id="collapseTwo" class="collapse <?= $title == 'Item Package' | $title == 'Category Package' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?= $title == 'Item Package'  ? 'active' : '' ?>" href="<?= site_url('package/item') ?>">Item</a>
                        <?php if ($this->session->userdata('role_id') == 1) { ?>
                            <a class="collapse-item <?= $title == 'Category Package'  ? 'active' : '' ?>" href="<?= site_url('package/category') ?>">Kategori</a>
                        <?php } ?>
                    </div>
                </div>
            </li>
            <li class="nav-item <?= $title == 'Belum Bayar' | $title == 'Sudah Bayar' | $title == 'Bill'  ? 'active' : '' ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tagihan" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Tagihan</span>
                </a>
                <div id="tagihan" class="collapse <?= $title == 'Belum Bayar' |  $title == 'Sudah Bayar' | $title == 'Konfirmasi Pembayaran' |  $title == 'Tunggakan' |  $title == 'Tunggakan' | $title == 'Bill Draf' | $title == 'Bill' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?= $title == 'Belum Bayar'  ? 'active' : '' ?>" href="<?= site_url('bill/unpaid') ?>">Belum Bayar</a>
                        <a class="collapse-item <?= $title == 'Sudah Bayar'  ? 'active' : '' ?>" href="<?= site_url('bill/paid') ?>">Sudah Bayar</a>
                        <?php if ($this->session->userdata('role_id') == 1) { ?>
                            <a class="collapse-item <?= $title == 'Bill'  ? 'active' : '' ?>" href="<?= site_url('bill') ?>">Semua</a>
                            <a class="collapse-item <?= $title == 'Bill Draf'  ? 'active' : '' ?>" href="<?= site_url('bill/draf') ?>">Tagihan Bulan Ini <sup style="color: red;">Draf</sup></a>
                            <a class="collapse-item <?= $title == 'Tunggakan'  ? 'active' : '' ?>" href="<?= site_url('bill/debt') ?>">Tunggakan</a>
                            <a class="collapse-item <?= $title == 'Konfirmasi Pembayaran'  ? 'active' : '' ?>" href="<?= site_url('confirm') ?>">Konfirmasi Pembayaran</a>
                        <?php } ?>
                    </div>
                </div>
            </li>
            <?php if ($this->session->userdata('role_id') == 1) { ?>
                <li class="nav-item <?= $title == 'Income' | $title == 'Expenditure' | $title == 'Report'  ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-dollar-sign"></i>
                        <span>Keuangan</span>
                    </a>
                    <div id="collapseReport" class="collapse <?= $title == 'Income' | $title == 'Expenditure' | $title == 'Report' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item <?= $title == 'Income'  ? 'active' : '' ?>" href="<?= site_url('income') ?>">Pemasukan</a>
                            <a class="collapse-item <?= $title == 'Expenditure'  ? 'active' : '' ?>" href="<?= site_url('expenditure') ?>">Pengeluaran</a>
                            <!-- <a class="collapse-item <?= $title == 'Report'  ? 'active' : '' ?>" href="<?= site_url('report') ?>">Laporan Keuangan</a> -->
                        </div>
                    </div>
                </li>


                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
                <div class="sidebar-heading">
                    Website
                </div>
                <li class="nav-item <?= $title == 'Slide'  ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= site_url('slider') ?>">
                        <i class="fa fa-fw fa-image"></i>
                        <span>Slide</span></a>
                </li>
                <li class="nav-item <?= $title == 'Product' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= site_url('product/data') ?>">
                        <i class="fa fa-fw fa-tasks"></i>
                        <span>Produk</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
                <li class="nav-item <?= $title == 'User' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= site_url('user') ?>">
                        <i class="fa fa-fw fa-users"></i>
                        <span>Pengguna</span></a>
                </li>
                <li class="nav-item <?= $title == 'Setting' | $title == 'Bot Telegram'  | $title == 'About'  ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetting" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                    <div id="collapseSetting" class="collapse <?= $title == 'Setting' | $title == 'About' | $title == 'Bot Telegram'  | $title == 'Bank' | $title == 'Email' | $title == 'SMS Gateway' | $title == 'Lainnya' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item <?= $title == 'Setting'  ? 'active' : '' ?>" href="<?= site_url('setting') ?>">Perusahaan</a>
                            <a class="collapse-item <?= $title == 'About'  ? 'active' : '' ?>" href="<?= site_url('setting/about') ?>">Tentang Perusahaan</a>
                            <a class="collapse-item <?= $title == 'Bank'  ? 'active' : '' ?>" href="<?= site_url('setting/bank') ?>">Rekening Bank</a>
                            <a class="collapse-item <?= $title == 'Email'  ? 'active' : '' ?>" href="<?= site_url('setting/email') ?>">Email</a>
                            <a class="collapse-item <?= $title == 'Bot Telegram'  ? 'active' : '' ?>" href="<?= site_url('setting/bottelegram') ?>">Bot Telegram</a>
                            <a class="collapse-item <?= $title == 'Syarat dan Ketentuan'  ? 'active' : '' ?>" href="<?= site_url('setting/terms') ?>">Syarat dan Ketentuan</a>
                            <a class="collapse-item <?= $title == 'Kebijakan Privasi'  ? 'active' : '' ?>" href="<?= site_url('setting/policy') ?>">Kebijakan Privasi</a>
                            <a class="collapse-item <?= $title == 'Lainnya'  ? 'active' : '' ?>" href="<?= site_url('setting/other') ?>">Lainnya</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item <?= $title == 'Backup'  ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= site_url('backup') ?>">
                        <i class="fa fa-fw fa-database"></i>
                        <span>Backup</span></a>
                </li>
                <li class="nav-item <?= $title == 'About My-Wifi' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= site_url('about') ?>">
                        <i class="fa fa-fw fa-tags"></i>
                        <span>Tentang My-Wifi</span></a>
                </li>
            <?php } ?>
            <!-- <li class="nav-item <?= $title == 'Donasi' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('donasi') ?>">
                    <i class="fa fa-fw fa-table"></i>
                    <span>Donasi</span></a>
            </li> -->
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" style="background-color: #171414; color:white">

                <!-- Topbar -->
                <nav style="background-color: #171414;" class="navbar navbar-expand navbar-dark  topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class=" form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search d-none d-sm-block d-md-block">
                        <h5>
                            <?= $company['company_name'] ?>
                        </h5>

                    </form>

                    <div class="d-none d-sm-block d-md-block">

                        <span id="jam"></span>
                        <span>:</span>
                        <span id="menit"></span>
                        <span>:</span>
                        <span id="detik"></span>
                    </div>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Alerts -->
                        <?php if ($this->session->userdata('role_id') == 1) { ?>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell fa-fw"></i>
                                    <!-- Counter - Alerts -->
                                    <span class="badge badge-danger badge-counter"><?= $this->db->get_where('confirm_payment', ['status' => 'Pending'])->num_rows() ?></span>
                                </a>
                                <!-- Dropdown - Alerts -->

                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                    <h6 class="dropdown-header">
                                        Menunggu Konfirmasi Pembayaran
                                    </h6>
                                    <?php $query = "SELECT *
                                    FROM `confirm_payment`
                                    WHERE `status` =  'Pending'";
                                    $pendingConfirm = $this->db->query($query)->result(); ?>
                                    <?php foreach ($pendingConfirm as $data) : ?>
                                        <a class="dropdown-item d-flex align-items-center" href="<?= site_url('confirmdetail/' . $data->invoice_id) ?>">
                                            <div>
                                                <?php $Customer = $this->db->get_where('customer', ['no_services' => $data->no_services])->row_array(); ?>
                                                <?php $bill = $this->db->get_where('invoice', ['no_services' => $data->no_services, 'invoice' => $data->invoice_id])->row_array(); ?>
                                                <span class="font-weight-bold"><?= $Customer['name'] ?> - <?= $data->no_services ?></span>
                                                <div class="small text-gray-500">#<?= $data->invoice_id ?> Periode <?= indo_month($bill['month']) ?> <?= $bill['year'] ?></div>
                                            </div>
                                        </a>
                                    <?php endforeach ?>
                                    <a class="dropdown-item text-center small text-gray-500" href="<?= site_url('confirm') ?>">Tampilkan Semua</a>
                                </div>
                            </li>
                        <?php } ?>
                        <!-- Nav Item - Messages -->
                        <?php if ($this->session->userdata('role_id') == 1) { ?>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-users fa-fw"></i>
                                    <!-- Counter - Messages -->
                                    <?php $Capel = $this->db->get_where('customer', ['c_status' => 'Menunggu']); ?>
                                    <span class="badge badge-danger badge-counter"><?= $Capel->num_rows(); ?></span>
                                </a>
                                <!-- Dropdown - Messages -->

                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                                    <h6 class="dropdown-header">
                                        Calon Pelanggan Baru
                                    </h6>
                                    <?php foreach ($Capel->result() as $capel) { ?>
                                        <a class="dropdown-item d-flex align-items-center" href="<?= site_url('customer/edit/' . $capel->customer_id) ?>">

                                            <div class="font-weight-bold">
                                                <div class="text-truncate"><?= $capel->name; ?></div>
                                                <div class="small text-gray-500"><?= date('d F Y', $capel->created); ?></div>
                                            </div>
                                        </a>
                                    <?php } ?>


                                    <a class="dropdown-item text-center small text-gray-500" href="<?= site_url('customer/wait') ?>">Tampilkan Semua</a>
                                </div>
                            </li>
                        <?php } ?>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user['name']; ?></span>
                                <img class="img-profile rounded-circle" src="<?= base_url(''); ?>assets/images/profile/<?= $user['image']; ?>" alt="">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= site_url('user/profile') ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Akun
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Keluar
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                <!-- Bootstrap core JavaScript-->
                <script src="<?= base_url('assets/backend/') ?>vendor/jquery/jquery.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.4/dist/sweetalert2.all.min.js"></script>
                <!-- Begin Page Content -->
                <div class="container-fluid" style="background-color: #171414;">
                    <style>
                        .card {
                            background-color: #171414;
                        }

                        .card-header {
                            background-color: #171414;
                        }

                        .sticky-footer {
                            background-color: #171414;
                        }
                    </style>
                    <?= $contents ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; <?= $company['company_name'] ?> <?= date('Y') ?>, Developed By <a href="https://1112-project.com/" target="blank" style="text-decoration: none; color:black">1112-Project</a></span>

                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <style>
        .scroll-to-top {
            position: fixed;
            left: 50%;
            right: 50%;
            bottom: 4rem;
            display: none;
            width: 2.75rem;
            height: 2.75rem;
            text-align: center;
            color: #fff;
            background: rgba(90, 92, 105, 0.5);
            line-height: 46px;
        }

        .scroll-to-top:focus,
        .scroll-to-top:hover {
            color: white;
        }

        .scroll-to-top:hover {
            background: #5a5c69;
        }

        .scroll-to-top i {
            font-weight: 800;
        }
    </style>
    <a class="scroll-to-top rounded" href="#page-top" title="Back To Top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin ?</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= site_url('auth/logout') ?>">Keluar</a>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-dark bg-primary navbar-expand d-md-none d-lg-none d-xl-none fixed-bottom">
        <ul class="navbar-nav nav-justified w-100">
            <li class="nav-item">
                <a href="<?= site_url('dashboard') ?>" class="nav-link <?= $title == 'Dashboard'  ? 'active' : '' ?>"> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                        <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                    </svg></a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('customer/active') ?>" title="Pelanggan" class="nav-link <?= $title == 'Aktif'  ? 'active' : '' ?>"><i class="fa fa-users"></i></a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('bill') ?>" class="nav-link <?= $title == 'Bill'  ? 'active' : '' ?>" title="tagihan"><i class="fa fa-credit-card"></i></a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('user/profile') ?>" title="Profile" class="nav-link <?= $title == 'Profile'  ? 'active' : '' ?>"><i class="fa fa-user"></i></a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('setting') ?>" class="nav-link <?= $title == 'Setting'  ? 'active' : '' ?>" title="Pengaturan"><i class="fas fa-fw fa-cog"></i></a>
            </li>
        </ul>
    </nav>
    <script src="<?= base_url('assets/backend/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="<?= base_url('assets/') ?>ajax_daerah.js"></script> -->

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/backend/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/backend/') ?>js/sb-admin-2.js"></script>
    <!-- Page level plugins -->
    <script src="<?= base_url('assets/backend/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="<?= base_url('assets/backend/') ?>js/demo/datatables-demo.js"></script>
    <script src="<?= base_url('assets/backend/') ?>js/select2.full.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tablebt').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: ['copy'],
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: ['csv'],
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: ['excel'],
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: ['pdf'],
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: ['print'],
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'colvis'
                ],
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            oTable = jQuery('#dataTableDraf').dataTable({
                "bPaginate": false,
                "bLengthChange": false,
                "aoColumns": [{
                        "bSortable": true
                    },
                    {
                        "bSortable": true
                    },
                    {
                        "bSortable": true
                    },
                    {
                        "bSortable": true
                    },
                    {
                        "bSortable": true
                    },

                    {
                        "bSortable": true
                    },
                    {
                        "bSortable": false
                    }
                ]
            });
        })
    </script>
    <script>
        window.setTimeout("waktu()", 1000);

        function waktu() {
            var waktu = new Date();
            setTimeout("waktu()", 1000);
            document.getElementById("jam").innerHTML = waktu.getHours();
            document.getElementById("menit").innerHTML = waktu.getMinutes();
            document.getElementById("detik").innerHTML = waktu.getSeconds();
        }
    </script>
    <!-- <script>
        $(window).resize(function() {
            if ($(window).width() < 767) {
                $("body").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
                if ($(".sidebar").hasClass("toggled")) {
                    $('.sidebar .collapse').collapse('hide');
                };
            };
        });
    </script> -->
    <!-- <script type="text/javascript">
        $(document).ready(function() {
            if ($(window).width() < 767) {
                $("body").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
                if ($(".sidebar").hasClass("toggled")) {
                    $('.sidebar .collapse').collapse('hide');
                };
            }
        });
    </script> -->

</body>

</html>