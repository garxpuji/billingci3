<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
        <?= $title ?> | Pelanggan</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>">
    <link rel="icon" href="" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
    <script src="<?= base_url('assets/backend/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/weather-icons/css/weather-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>dist/css/theme.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/owl.carousel/dist/assets/owl.theme.default.min.css">
    <script src="<?= base_url('assets/member/') ?>src/js/vendor/modernizr-2.8.3.min.js"></script>
    <!-- bootstrap datepicker -->
    <link href="<?= base_url('assets/backend/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <?php if ($user['role_id'] != 2) {
        redirect('auth/logout');
    } ?>
    <?php $role = $this->db->get_where('role_management', ['role_id' => 2])->row_array() ?>
    <?= $this->session->flashdata('message') ?>
    <?php $rolepelanggan = $this->db->get_where('role_management', ['role_id' => 2])->row_array() ?>
    <div class="wrapper">
        <header class="header-top" header-theme="light">
            <div class="container-fluid">
                <div class="d-flex justify-content-between">
                    <div class="top-menu d-flex align-items-center">
                        <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                        <!-- <div class="header-search">
                            <div class="input-group">
                                <span class="input-group-addon search-close"><i class="ik ik-x"></i></span>
                                <input type="text" class="form-control">
                                <span class="input-group-addon search-btn"><i class="ik ik-search"></i></span>
                            </div>
                        </div> -->
                        <!-- <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button> -->
                    </div>
                    <div class="top-menu d-flex align-items-center">
                        <div class="dropdown">
                            <!-- <a class="nav-link dropdown-toggle" href="#" id="notiDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-bell"></i><span class="badge bg-danger">3</span></a> -->
                            <!-- <div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="notiDropdown">
                                <h4 class="header">Notifications</h4>
                                <div class="notifications-wrap">
                                    <a href="#" class="media">
                                        <span class="d-flex">
                                            <i class="ik ik-check"></i>
                                        </span>
                                        <span class="media-body">
                                            <span class="heading-font-family media-heading">Invitation accepted</span>
                                            <span class="media-content">Your have been Invited ...</span>
                                        </span>
                                    </a>
                                    <a href="#" class="media">
                                        <span class="d-flex">
                                            <img src="<?= base_url('assets/member/') ?>/img/users/1.jpg" class="rounded-circle" alt="">
                                        </span>
                                        <span class="media-body">
                                            <span class="heading-font-family media-heading">Steve Smith</span>
                                            <span class="media-content">I slowly updated projects</span>
                                        </span>
                                    </a>
                                    <a href="#" class="media">
                                        <span class="d-flex">
                                            <i class="ik ik-calendar"></i>
                                        </span>
                                        <span class="media-body">
                                            <span class="heading-font-family media-heading">To Do</span>
                                            <span class="media-content">Meeting with Nathan on Friday 8 AM ...</span>
                                        </span>
                                    </a>
                                </div>
                                <div class="footer"><a href="javascript:void(0);">See all activity</a></div>
                            </div> -->
                        </div>
                        <!-- <button type="button" class="nav-link ml-10 right-sidebar-toggle"><i class="ik ik-message-square"></i><span class="badge bg-success">3</span></button> -->
                        <!-- <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="menuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-plus"></i></a>
                            <div class="dropdown-menu dropdown-menu-right menu-grid" aria-labelledby="menuDropdown">
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Dashboard"><i class="ik ik-bar-chart-2"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Message"><i class="ik ik-mail"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Accounts"><i class="ik ik-users"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Sales"><i class="ik ik-shopping-cart"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Purchase"><i class="ik ik-briefcase"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Pages"><i class="ik ik-clipboard"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Chats"><i class="ik ik-message-square"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Contacts"><i class="ik ik-map-pin"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Blocks"><i class="ik ik-inbox"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Events"><i class="ik ik-calendar"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Notifications"><i class="ik ik-bell"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="More"><i class="ik ik-more-horizontal"></i></a>
                            </div>
                        </div> -->
                        <!-- <button type="button" class="nav-link ml-10" id="apps_modal_btn" data-toggle="modal" data-target="#appsModal"><i class="ik ik-grid"></i></button> -->
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false""><?= $user['name'] ?></span>
                            <div class=" dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= site_url('member/profile') ?>"><i class="ik ik-user dropdown-icon"></i> Profile</a>
                                <a class="dropdown-item" href="<?= site_url('auth/logout') ?>"><i class="ik ik-power dropdown-icon"></i> Logout</a>
                        </div>
                    </div>
                    <div class=" dropdown">
                        <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="<?= base_url(''); ?>assets/images/profile/<?= $user['image']; ?>" alt=""></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="<?= site_url('member/profile') ?>"><i class="ik ik-user dropdown-icon"></i> Profile</a>
                            <a class="dropdown-item" href="<?= site_url('auth/logout') ?>"><i class="ik ik-power dropdown-icon"></i> Logout</a>
                        </div>
                    </div>

                </div>
            </div>
    </div>
    </header>

    <div class="page-wrap">
        <div class="app-sidebar colored">
            <div class="sidebar-header">
                <a class="header-brand" href="<?= base_url('member') ?>">
                    <div class="logo-img">
                        <i class="fa fa-wifi"> </i>
                    </div>
                    <span class="text"><?= $company['apps_name']; ?></span>
                </a>
                <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
                <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
            </div>

            <div class="sidebar-content">
                <div class="nav-container">
                    <nav id="main-menu-navigation" class="navigation-main">

                        <div class="nav-item <?= $title == 'Dashboard'  ? 'active' : '' ?>">
                            <a href="<?= base_url('member') ?>"><i class="ik ik-bar-chart-2"></i><span>Beranda</span></a>
                        </div>
                        <div class="nav-item <?= $title == 'Status'  ? 'active' : '' ?>">
                            <a href="<?= base_url('member/status') ?>"><i class="ik ik-menu"></i><span>Informasi Layanan</span> </a>
                        </div>
                        <?php if ($role['show_history'] == 1) { ?>
                            <div class="nav-item <?= $title == 'History'  ? 'active' : '' ?>">
                                <a href="<?= base_url('member/history') ?>"><i class="ik ik-dollar-sign"></i><span>Riwayat Tagihan</span> </a>
                            </div>
                        <?php } ?>
                        <?php if ($role['show_help'] == 1) { ?>
                            <div class="nav-item <?= $title == 'Lapor Gangguan'  ? 'active' : '' ?>">
                                <a href="<?= base_url('help') ?>"><i class="fas fa-wrench"></i><span>Open Tiket</span> </a>
                            </div>
                            <div class="nav-item <?= $title == 'Help'  ? 'active' : '' ?>">
                                <a href="<?= base_url('member/help') ?>"><i class="fa fa-question"></i><span>Bantuan</span> </a>
                            </div>
                        <?php } ?>
                        <?php if ($role['show_log'] == 1) { ?>
                            <div class="nav-item <?= $title == 'Logs'  ? 'active' : '' ?>">
                                <a href="<?= base_url('member/logs') ?>"><i class="ik ik-clock"></i><span>Logs</span> </a>
                            </div>
                        <?php } ?>
                        <?php $customer = $this->db->get_where('customer', ['email' => $this->session->userdata('email')])->row_array(); ?>
                        <?php $modem = $this->member_m->getmodem($customer['customer_id'])->num_rows() ?>
                        <?php if ($modem > 0) { ?>
                            <div class="nav-item <?= $title == 'Modem'  ? 'active' : '' ?>">
                                <a href="<?= base_url('member/modem') ?>"><i class="ik ik-rss"></i><span>Modem</span> </a>
                            </div>
                        <?php } ?>
                        <?php if ($modem == 0) { ?>
                            <div class="nav-item <?= $title == 'Modem'  ? 'active' : '' ?>">
                                <!-- <a href="<?= base_url('member/modem') ?>"><i class="ik ik-rss"></i><span>Ganti Password Modem</span> </a> -->
                            </div>
                        <?php } ?>

                        <?php if ($role['show_speedtest'] == 1) { ?>
                            <div class="nav-item <?= $title == 'Speedtest'  ? 'active' : '' ?>">
                                <a href="<?= base_url('member/speedtest') ?>"><i class="ik ik-rss"></i><span>Speedtest</span> </a>
                            </div>
                        <?php } ?>

                        <div class="nav-lavel">Pengaturan</div>
                        <div class="nav-item <?= $title == 'Profile' | $title == 'Account'  ? 'active' : '' ?>">
                            <a href="<?= site_url('member/profile') ?>"><i class="ik ik-user"></i><span>Profile</span></a>
                        </div>
                        <div class="nav-item <?= $title == 'Ganti Password'  ? 'active' : '' ?>">
                            <a href="<?= site_url('member/changepassword') ?>"><i class="fa fa-key"></i><span>Ganti Password</span></a>
                        </div>

                        <div class="nav-item <?= $title == 'Tentang'  ? 'active' : '' ?>">
                            <a href="<?= site_url('member/about') ?>"><i class="fa fa-info"></i><span>Tentang</span></a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.4/dist/sweetalert2.all.min.js"></script>
        <div class="main-content">
            <div class="container-fluid">
                <?= $contents ?>
            </div>
        </div>
        <aside class="right-sidebar">
            <div class="sidebar-chat" data-plugin="chat-sidebar">
                <div class="sidebar-chat-info">
                    <h6>Chat List</h6>
                    <form class="mr-t-10">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search for friends ...">
                            <i class="ik ik-search"></i>
                        </div>
                    </form>
                </div>

            </div>
        </aside>

        <div class="chat-panel" hidden>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <a href="javascript:void(0);"><i class="ik ik-message-square text-success"></i></a>
                    <span class="user-name">John Doe</span>
                    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="card-body">
                    <div class="widget-chat-activity flex-1">
                        <div class="messages">
                            <div class="message media reply">

                                <div class="message-body media-body">
                                    <p>Epic Cheeseburgers come in all kind of styles.</p>
                                </div>
                            </div>
                            <div class="message media">

                                <div class="message-body media-body">
                                    <p>Cheeseburgers make your knees weak.</p>
                                </div>
                            </div>
                            <div class="message media reply">

                                <div class="message-body media-body">
                                    <p>Cheeseburgers will never let you down.</p>
                                    <p>They'll also never run around or desert you.</p>
                                </div>
                            </div>
                            <div class="message media">

                                <div class="message-body media-body">
                                    <p>A great cheeseburger is a gastronomical event.</p>
                                </div>
                            </div>
                            <div class="message media reply">

                                <div class="message-body media-body">
                                    <p>There's a cheesy incarnation waiting for you no matter what you palete preferences are.</p>
                                </div>
                            </div>
                            <div class="message media">

                                <div class="message-body media-body">
                                    <p>If you are a vegan, we are sorry for you loss.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="javascript:void(0)" class="card-footer" method="post">
                    <div class="d-flex justify-content-end">
                        <textarea class="border-0 flex-1" rows="1" placeholder="Type your message here"></textarea>
                        <button class="btn btn-icon" type="submit"><i class="ik ik-arrow-right text-success"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <footer class="footer">
            <div class="w-100 clearfix">
                <span class="text-center text-sm-left d-md-inline-block">Copyright © <?= date('Y') ?> <?= $company['company_name'] ?> All Rights Reserved.</span>

            </div>
        </footer>
    </div>
    </div>
    <div class="modal fade apps-modal" id="appsModal" tabindex="-1" role="dialog" aria-labelledby="appsModalLabel" aria-hidden="true" data-backdrop="false">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ik ik-x-circle"></i></button>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="quick-search">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 ml-auto mr-auto">
                                <div class="input-wrap">
                                    <input type="text" id="quick-search" class="form-control" placeholder="Search." />
                                    <i class="ik ik-search"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="container">
                        <div class="apps-wrap">
                            <div class="app-item">
                                <a href="#"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-mail"></i><span>Message</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-users"></i><span>Accounts</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-shopping-cart"></i><span>Sales</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-briefcase"></i><span>Purchase</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-server"></i><span>Menus</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-clipboard"></i><span>Pages</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-message-square"></i><span>Chats</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-map-pin"></i><span>Contacts</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-box"></i><span>Blocks</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-calendar"></i><span>Events</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-bell"></i><span>Notifications</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-pie-chart"></i><span>Reports</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-layers"></i><span>Tasks</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-edit"></i><span>Blogs</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-settings"></i><span>Settings</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-more-horizontal"></i><span>More</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <nav class="navbar navbar-dark bg-dark navbar-expand d-md-none d-lg-none d-xl-none fixed-bottom">
        <ul class="navbar-nav nav-justified w-100">
            <li class="nav-item">
                <a href="<?= site_url('dashboard') ?>" class="nav-link <?= $title == 'Dashboard'  ? 'active' : '' ?>"> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                        <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                    </svg></a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('member/status') ?>" title="Status" class="nav-link <?= $title == 'Status'  ? 'active' : '' ?>"><i class="ik ik-menu"></i></a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('member/history') ?>" class="nav-link <?= $title == 'History'  ? 'active' : '' ?>" title="tagihan"><i class="fa fa-credit-card"></i></a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('member/profile') ?>" title="Profile" class="nav-link <?= $title == 'Profile'  ? 'active' : '' ?>"><i class="fa fa-user"></i></a>
            </li>
           
        </ul>
    </nav> -->

    <script>
        window.jQuery || document.write('<script src="<?= base_url('assets/member/') ?>/src/js/vendor/jquery-3.3.1.min.js"><\/script>')
    </script>
    <!-- Page level plugins -->
    <script src="<?= base_url('assets/backend/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="<?= base_url('assets/backend/') ?>js/demo/datatables-demo.js"></script>
    <script src="<?= base_url('assets/member/') ?>plugins/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?= base_url('assets/member/') ?>plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/member/') ?>plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>

    <script src="<?= base_url('assets/member/') ?>dist/js/theme.min.js"></script>
    <script src="<?= base_url('assets/member/') ?>plugins/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="<?= base_url('assets/member/') ?>js/carousel.js"></script>
    <!-- Google Analytics: change UA-XXXXX-X to be y
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
        (function(b, o, i, l, e, r) {
            b.GoogleAnalyticsObject = l;
            b[l] || (b[l] =
                function() {
                    (b[l].q = b[l].q || []).push(arguments)
                });
            b[l].l = +new Date;
            e = o.createElement(i);
            r = o.getElementsByTagName(i)[0];
            e.src = 'https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e, r)
        }(window, document, 'script', 'ga'));
        ga('create', 'UA-XXXXX-X', 'auto');
        ga('send', 'pageview');
    </script>
    <!-- bootstrap datepicker -->
    <script src="<?= base_url('assets/backend') ?>/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>js/demo/datatables-demo.js"></script>
    <script>
        //Date picker
        $('#tanggal').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        })
        $('#tanggal2').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        })
        $('#datepicker').datepicker({
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
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = '<?= $company['tawk']; ?>';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->
<script>
    $(document).ready(function() {
        $('#tablebt').DataTable({
            "lengthMenu": [
                [10, 25, 50, 100, 250, 500, 1000],
                [10, 25, 50, 100, 250, 500, 1000]
            ],
            dom: 'lBfrtip',
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