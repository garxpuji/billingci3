<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <a href="<?= site_url('mikrotik/hotspotactive') ?>" style="text-decoration: none;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Hotspot Active</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $hotspotactive ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-laptop fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <a href="<?= site_url('mikrotik/hotspotuser') ?>" style="text-decoration: none;">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hotspot User</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $hotspotuser; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">PPPOE Active</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pppactive; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">PPP Secret</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pppsecret; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <a href="<?= site_url('mikrotik/hotspotuser') ?>" style="text-decoration: none;">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">CPU Load</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $resource['cpu-load']; ?> %</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: small">


                                Uptime : <?= formattimemikro($resource['uptime']); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-tasks  fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <a href="<?= site_url('mikrotik/hotspotuser') ?>" style="text-decoration: none;">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Free HDD / Memory</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatBites($resource['free-hdd-space']); ?> / <?= formatBites($resource['free-memory']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <a href="<?= site_url('mikrotik/hotspotuser') ?>" style="text-decoration: none;">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Info</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: small">

                                <?php if ($routerboard['board-name'] != '') { ?>
                                    Board Name : <?= $routerboard['board-name']; ?> <br>
                                <?php } ?>
                                Model : <?= $routerboard['model']; ?><br>OS : <?= $resource['version']; ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-info fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <a href="<?= site_url('mikrotik/hotspotuser') ?>" style="text-decoration: none;">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Income Hotspot <span style="font-size: smaller;color:red">Mikhmon</span></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 14px">
                                Today <?= $totalVcrToday; ?> Vcr : <?= indo_currency($reportToday); ?> <br>
                                This Month <?= $totalVcrMonth; ?> Vcr : <?= indo_currency($reportMonth); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- Pie Chart -->

</div>