<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Hotspot Host</h6>
        <span style="color: red;"> <?php $router = $this->db->get_where('router', ['id' => $this->session->userdata('router')])->row_array(); ?>
            <?= $router['alias']; ?></span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px"><?= count($hotspothost) ?></th>
                        <th>MAC Address</th>
                        <th>Address</th>
                        <th>To Address</th>
                        <th>Uptime</th>
                        <th>Bytes In</th>
                        <th>Bytes Out</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    foreach ($hotspothost as $key => $data) { ?>
                        <tr style="font-size:12; font-weight: 200;">
                            <th>
                                <!-- <a href="<?= site_url('mikrotik/delhotspothost/' . $data['mac-address']) ?>" id="username" data-username="<?= $data['mac-address'] ?>" style="color: red;"><i class="fa fa-trash"></i></a> -->
                            </th>
                            <th><?= $data['mac-address']; ?></th>
                            <th><?= $data['address']; ?></th>
                            <th><?= $data['to-address']; ?></th>
                            <th><?= formattimemikro($data['uptime']); ?></th>
                            <th style="text-align: right;"><?= formatBytes($data['bytes-in'], 1); ?></th>
                            <th style="text-align: right;"><?= formatBytes($data['bytes-out'], 1); ?></th>
                            <th><?= $data['comment']; ?></th>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '#username', function() {
        var mac = $(this).data('username');
        var x = confirm("Are you sure you want to delete host " + mac + " ?");
        if (x)
            return true;
        else
            return false;

    })
</script>
<script>
    setTimeout(function() {
        window.location.reload(1);
    }, 60000);
</script>

<?php ini_set('display_errors', 'off');  ?>