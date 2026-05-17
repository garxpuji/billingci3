<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Hotspot Users Active</h6>
        <span style="color: red;"> <?php $router = $this->db->get_where('router', ['id' => $this->session->userdata('router')])->row_array(); ?>
            <?= $router['alias']; ?></span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px"><?= count($hotspotactive) ?></th>
                        <th>Server</th>
                        <th>User</th>
                        <th>Address</th>
                        <th>Uptime</th>
                        <th>Time Left</th>
                        <th>Bytes In</th>
                        <th>Bytes Out</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($hotspotactive as $key => $data) { ?>
                        <tr style="font-size:12; font-weight: 200;">
                            <th>
                            </th>
                            <th><?= $data['server']; ?></th>
                            <th><?= $data['user']; ?></th>
                            <th><?= $data['address']; ?></th>
                            <th style="text-align: right;"><?= formattimemikro($data['uptime']); ?></th>
                            <th style="text-align: right;"><?= formattimemikro($data['session-time-left']); ?></th>
                            <th style="text-align: right;"><?= formatBytes($data['bytes-in'], 1); ?></th>
                            <th style="text-align: right;"><?= formatBytes($data['bytes-out'], 1); ?></th>
                            <?php if ($data['comment'] != null) { ?>
                                <th>
                                    <?= $data['comment']; ?>
                                </th>
                            <?php } ?>
                            <?php if ($data['comment'] == null) { ?>
                                <th></th>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '#username', function() {
        var user = $(this).data('username');
        var x = confirm("Are you sure you want to kick username " + user + " ?");
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