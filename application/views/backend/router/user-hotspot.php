<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <a href="" id="#addModal" data-toggle="modal" data-target="#addModal" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add User</a>


</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Hotspot Users</h6>

    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px"><?= count($hotspotuser) ?></th>
                        <th>Name</th>
                        <th>Profile</th>
                        <th>Uptime</th>
                        <th>Bytes In</th>
                        <th>Bytes Out</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    foreach ($hotspotuser as $key => $data) { ?>
                        <tr style="font-size:12; font-weight: 200;">
                            <th>
                                <?php $id = str_replace('*', '', $data['.id']) ?>
                                <?php if ($data['disabled'] == 'true') { ?>
                                    <a href="<?= site_url('router/enablehotspotuser/' . $id) ?>" data-username="<?= $data['name'] ?>" style="color: grey;"> <i class="fa fa-lock" title="Enable User <?= $data['name']; ?>"></i></a> <?php } ?>
                                <?php if ($data['disabled'] != 'true') { ?> <a href="<?= site_url('router/disablehotspotuser/' . $id) ?>" data-username="<?= $data['name'] ?>" style="color: grey;"> <i class="fa fa-unlock" title="Disable User <?= $data['name']; ?>"></i></a> <?php } ?>
                                <a href="<?= site_url('router/delHotspotUser/' . $id) ?>" id="username" data-username="<?= $data['name'] ?>" style="color: red;"><i class="fa fa-trash"></i></a>
                            </th>
                            <th><?= $data['name']; ?></th>
                            <?php if ($data['profile'] != null) { ?>
                                <th><?= $data['profile']; ?></th>
                            <?php } ?>
                            <?php if ($data['profile'] == null) { ?>
                                <th></th>
                            <?php } ?>
                            <th><?= formattimemikro($data['uptime']); ?></th>
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
<div class="modal fade" id="addModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title">Add User Hotspot</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= site_url('router/addHotspotUser') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="server">Server</label>
                        <select name="server" id="server" class="form-control">
                            <option>all</option>
                            <?php $TotalReg = count($server);
                            for ($i = 0; $i < $TotalReg; $i++) {
                                echo "<option>" . $server[$i]['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user">User</label>
                        <input type="text" class="form-control" autocomplete="off" name="user" id="user">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label for="profile">Profile</label>
                        <select name="profile" id="profile" class="form-control">
                            <?php $TotalReg = count($profile);
                            for ($i = 0; $i < $TotalReg; $i++) {
                                echo "<option>" . $profile[$i]['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="timelimit">Time Limit</label>
                        <input type="text" class="form-control" name="timelimit" autocomplete="off" id="timelimit">
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <input type="text" class="form-control" name="comment" autocomplete="off" id="comment">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script type="text/javascript">
    $(document).on('click', '#username', function() {
        var user = $(this).data('username');
        var x = confirm("Are you sure you want to delete username " + user + " ?");
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