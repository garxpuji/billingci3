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
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">

</head>

<body id="page-top">
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
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('dashboard') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-wifi"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><?= $company['apps_name']; ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?= $title == 'Dashboard'  ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('dashboard') ?>">
                    <i class="fa fa-credit-card"></i>
                    <span>Dashboard Billing</span></a>
            </li>
            <li class="nav-item <?= $title == 'Dashboard'  ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('mikrotik') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard Mikrotik</span></a>
            </li>
            <li class="nav-item <?= $title == 'Customer'  ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('mikrotik/customer') ?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Customer</span></a>
            </li>
            <li class="nav-item <?= $title == 'Interface'  ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('mikrotik/interface') ?>">
                    <i class="fas fa-fw fa-sitemap"></i>
                    <span>Interface</span></a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item <?= $title == 'Users' | $title == 'Active' | $title == 'Profile' | $title == 'Binding' | $title == 'Non-Aktif' | $title == 'Waiting'   ? 'active' : '' ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomer" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-sitemap"></i>
                    <span>Hotspot</span>
                </a>
                <div id="collapseCustomer" class="collapse <?= $title == 'Users' | $title == 'Active' | $title == 'Binding' | $title == 'Profile' | $title == 'Users' | $title == 'Host' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?= $title == 'Active'  ? 'active' : '' ?>" href="<?= site_url('mikrotik/hotspotactive') ?>">Aktif</a>
                        <a class="collapse-item <?= $title == 'Users'  ? 'active' : '' ?>" href="<?= site_url('mikrotik/hotspotuser') ?>">Users</a>
                        <a class="collapse-item <?= $title == 'Profile'  ? 'active' : '' ?>" href="<?= site_url('mikrotik/hotspotprofile') ?>">Profile</a>
                        <a class="collapse-item <?= $title == 'Binding'  ? 'active' : '' ?>" href="<?= site_url('mikrotik/hotspotbinding') ?>">Binding</a>
                        <a class="collapse-item <?= $title == 'Host'  ? 'active' : '' ?>" href="<?= site_url('mikrotik/hotspothost') ?>">Host</a>
                    </div>
                </div>
            </li>
            <li class="nav-item <?= $title == 'PPPOE' | $title == 'PPP Active' | $title == 'PPP Secret' | $title == 'Profile PPP'   ? 'active' : '' ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePPP" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-sitemap"></i>
                    <span>PPP</span>
                </a>
                <div id="collapsePPP" class="collapse <?= $title == 'PPPOE' | $title == 'PPP Active' | $title == 'PPP Secret' | $title == 'Profile PPP' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?= $title == 'PPP Secret'  ? 'active' : '' ?>" href="<?= site_url('mikrotik/pppsecret') ?>">Secret</a>
                        <a class="collapse-item <?= $title == 'PPP Active'  ? 'active' : '' ?>" href="<?= site_url('mikrotik/pppoeactive') ?>">Aktif</a>
                        <a class="collapse-item <?= $title == 'PPPOE'  ? 'active' : '' ?>" href="<?= site_url('mikrotik/pppoe') ?>">PPPOE</a>
                        <a class="collapse-item <?= $title == 'Profile PPP'  ? 'active' : '' ?>" href="<?= site_url('mikrotik/profileppp') ?>">Profile</a>

                    </div>
                </div>
            </li>
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

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
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php $router = $this->db->get_where('router', ['id' => $this->session->userdata('router')])->row_array(); ?>
                                <?= $router['alias']; ?> <i class="fas fa-caret-down"></i>
                                <!-- Counter - Alerts -->

                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Pilih Router
                                </h6>
                                <?php $routerlist = $this->db->get('router')->result(); ?>
                                <?php foreach ($routerlist as $data) : ?>
                                    <a class="dropdown-item d-flex align-items-center" href="<?= site_url('mikrotik/dashboard/' . $data->id) ?>">
                                        <div>
                                            <span class="font-weight-bold"><?= $data->alias ?> </span>
                                            <div class="small text-gray-500"># <?= $data->ip_address ?></div>
                                        </div>
                                    </a>
                                <?php endforeach ?>
                                <a class="dropdown-item text-center small text-gray-500" href="<?= site_url('router') ?>">Tampilkan Semua</a>
                            </div>
                        </li>
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

                        <!-- Nav Item - Messages -->
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
                <div class="container-fluid">

                    <?= $contents ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; <?= $company['company_name'] ?> <?= date('Y') ?></span>
                        <div class="text-right">



                        </div>
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
    <!-- bootstrap datepicker -->
    <script src="<?= base_url('assets/backend') ?>/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>


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
    <script type="text/javascript">
        $(document).ready(function() {
            if ($(window).width() < 767) {
                $("body").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
                if ($(".sidebar").hasClass("toggled")) {
                    $('.sidebar .collapse').collapse('hide');
                };
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            if ($(window).width() < 767) {
                $("a.modal").attr("href", "https://secured.sirvoy.com/book.php?c_id=1602&h=ea3a7c9286f068fb6c1462fad233a5e0")
            }
        });
    </script>
    <script>
        //Date picker
        $('#datepicker').datepicker({
            maxDate: '0',
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        })
        $('#datepickerdisablefuture').datepicker({
            maxDate: '0',
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            endDate: new Date()
        });
    </script>
</body>

</html>