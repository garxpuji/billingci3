<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Hotspot Users Profile</h6>
        <span style="color: red;"> <?php $router = $this->db->get_where('router', ['id' => $this->session->userdata('router')])->row_array(); ?>
            <?= $router['alias']; ?></span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px"><?= count($hotspotprofile) ?></th>
                        <th>Name</th>
                        <th>Shared User</th>
                        <th>Rate Limit</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($hotspotprofile as $key => $data) { ?>
                        <tr style="font-size:12; font-weight: 200;">
                            <th>
                                <!-- <a href="<?= site_url('mikrotik/delprofilehotspot/' . $data['name']) ?>" id="username" data-username="<?= $data['name'] ?>" style="color: red;" title="Delete <?= $data['user'] ?>"><i class="fa fa-minus"></i></a> -->
                            </th>
                            <th><?= $data['name']; ?></th>
                            <th style="text-align: center;"><?= $data['shared-users']; ?></th>

                            <th><?= $data['rate-limit']; ?></th>
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
        var x = confirm("Are you sure you want to delete user profile " + user + "?");
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