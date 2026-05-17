<?php if ($customer > 0) { ?>
    <?php if ($customer['mode_user'] != "") { ?> <div class="card border-danger">
            <div class="info-tagihan">

                <div class="container">

                    <div class="card border-primary mb-2 mt-1">

                        <div class="container mt-2">

                            <h5>Pemakaian Kuota Internet</h5>

                            <div class="row">

                                <div class="col-3">

                                    Pemakaian

                                </div>

                                <div class="col-8">
                                    <?php $usage = $this->mikrotik_m->usagethismonth($customer['no_services'])->result();

                                    $totalusage = 0;
                                    foreach ($usage as $c => $usage) {
                                        $totalusage += $usage->count_usage;
                                    }
                                    ?>

                                    : <?= formatBites($totalusage, 2); ?>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-3">

                                    No Layanan

                                </div>

                                <div class="col-8">

                                    : <?= $customer['no_services']; ?>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-3">

                                    Last Update

                                </div>

                                <div class="col-8">
                                    <?php $last = $this->mikrotik_m->lastusage($customer['no_services'])->row_array() ?>
                                    : <?= date('d M Y - H:i:s', $last['last_update']); ?>
                                </div>
                            </div>




                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php }  ?>
    <?php if ($customer['mode_user'] == "") { ?>
        <div class="text-center mb-3 mt-2">

            <div class="container">

                <div class="card border-danger">

                    <div class="card-body">

                        <h4 class="card-title text-danger">Belum terhubung ke server, silahkan hubungi kami</h4>

                    </div>

                </div>

            </div>

        </div>
    <?php }  ?>
<?php } ?>