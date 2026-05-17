<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <a href="" id="#addModal" data-toggle="modal" data-target="#addModal" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add PPPOE</a>
</div>
<?php $this->view('messages') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold"><?= $title; ?></h6>
        <span style="color: red;"> <?php $router = $this->db->get_where('router', ['id' => $this->session->userdata('router')])->row_array(); ?>
            <?= $router['alias']; ?></span>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="tablebt" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px"><?= count($pppoe) ?></th>
                        <th>Status</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Profile</th>
                        <th>Local Address</th>
                        <th>Remote Address</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($pppoe as $key => $data) { ?>
                        <tr style="font-size:12; font-weight: 200;">
                            <th>
                                <?php $id = str_replace('*', '', $data['.id']) ?>
                                <?php if ($data['disabled'] == 'true') { ?>
                                    <a href="<?= site_url('mikrotik/enablepppoeuser/' . $id) ?>" data-username="<?= $data['name'] ?>" style="color: grey;"> <i class="fa fa-lock" title="Enable User <?= $data['name']; ?>"></i></a> <?php } ?>
                                <?php if ($data['disabled'] != 'true') { ?> <a href="<?= site_url('mikrotik/disablepppoeuser/' . $id) ?>" data-username="<?= $data['name'] ?>" style="color: grey;"> <i class="fa fa-unlock" title="Disable User <?= $data['name']; ?>"></i></a> <?php } ?>
                                <a href="<?= site_url('mikrotik/delPppoeUser/' . $id) ?>" id="username" data-username="<?= $data['name'] ?>" style="color: red;"><i class="fa fa-trash"></i></a>
                            </th>
                            <th>
                                <?php $customer = $this->db->get_where('customer', ['user_mikrotik' => $data['name'], 'router' => $this->session->userdata('router')])->row_array() ?>
                                <?php if ($customer > 0) { ?>
                                    <?php if ($customer['user_profie'] == '' or $customer['user_profie'] == 'EXPIRED') { ?>
                                        <?php if ($data['profile'] != 'EXPIRED') { ?>
                                            <?php
                                            $this->db->set('user_profile',  $data['profile']);
                                            $this->db->where('customer_id', $customer['customer_id']);
                                            $this->db->update('customer');
                                            ?>
                                        <?php } ?>

                                    <?php } ?>
                                    Terdaftar
                                <?php } else {
                                    echo "Tidak Terdaftar";
                                } ?>
                            </th>
                            <th><?= $data['name']; ?></th>
                            <th><?= $data['password']; ?></th>
                            <th><?= $data['profile']; ?></th>
                            <th><?= $data['local-address']; ?></th>
                            <th><?= $data['remote-address']; ?></th>
                            <th><?= $data['comment']; ?></th>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">PPPOE EXPIRED</h6>
            <span style="color: red;"> <?php $router = $this->db->get_where('router', ['id' => $this->session->userdata('router')])->row_array(); ?>
                <?= $router['alias']; ?></span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="text-align: center">
                            <th style="text-align: center; width:20px"><?= count($pppoeexpired) ?></th>
                            <th>Status</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Profile</th>
                            <th>Local Address</th>
                            <th>Remote Address</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($pppoeexpired as $key => $data) { ?>
                            <tr style="font-size:12; font-weight: 200;">
                                <th>
                                    <?php $id = str_replace('*', '', $data['.id']) ?>
                                    <?php if ($data['disabled'] == 'true') { ?>
                                        <a href="<?= site_url('mikrotik/enablepppoeuser/' . $id) ?>" data-username="<?= $data['name'] ?>" style="color: grey;"> <i class="fa fa-lock" title="Enable User <?= $data['name']; ?>"></i></a> <?php } ?>
                                    <?php if ($data['disabled'] != 'true') { ?> <a href="<?= site_url('mikrotik/disablepppoeuser/' . $id) ?>" data-username="<?= $data['name'] ?>" style="color: grey;"> <i class="fa fa-unlock" title="Disable User <?= $data['name']; ?>"></i></a> <?php } ?>
                                    <a href="<?= site_url('mikrotik/delPppoeUser/' . $id) ?>" id="username" data-username="<?= $data['name'] ?>" style="color: red;"><i class="fa fa-trash"></i></a>
                                </th>
                                <th>
                                    <?php $customer = $this->db->get_where('customer', ['user_mikrotik' => $data['name'], 'router' => $this->session->userdata('router')])->row_array() ?>
                                    <?php if ($customer > 0) { ?>
                                        <?php if ($customer['user_profie'] == '' or $customer['user_profie'] == 'EXPIRED') { ?>
                                            <?php if ($data['profile'] != 'EXPIRED') { ?>
                                                <?php
                                                $this->db->set('user_profile',  $data['profile']);
                                                $this->db->where('customer_id', $customer['customer_id']);
                                                $this->db->update('customer');
                                                ?>
                                            <?php } ?>

                                        <?php } ?>
                                        Terdaftar
                                    <?php } else {
                                        echo "Tidak Terdaftar";
                                    } ?>
                                </th>
                                <th><?= $data['name']; ?></th>
                                <th><?= $data['password']; ?></th>
                                <th><?= $data['profile']; ?></th>
                                <th><?= $data['local-address']; ?></th>
                                <th><?= $data['remote-address']; ?></th>
                                <th><?= $data['comment']; ?></th>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add PPPOE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('mikrotik/addPppoeUser') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Profile</label>
                        <select name="profile" id="select" class="form-control" required>
                            <?php
                            foreach ($profile as $key => $data) { ?>
                                <option value="<?= $data['name']; ?>"><?= $data['name']; ?></option>

                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Local Address</label>
                        <input type="text" name="localaddress" onKeyPress="return kodeScript(event,' :.0123456789',this)" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Remote Address</label>
                        <input type="text" name="remoteaddress" onKeyPress="return kodeScript(event,' :.0123456789',this)" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        <input type="text" name="comment" class="form-control" autocomplete="off">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '#username', function() {
        var user = $(this).data('username');
        var x = confirm("Are you sure you want to delete user pppoe " + user + " ?");
        if (x)
            return true;
        else
            return false;

    })
</script>
<script>
    setTimeout(function() {
        window.location.reload(1);
    }, 600000);
</script>
<script language="javascript">
    function getkey(e) {
        if (window.event)
            return window.event.keyCode;
        else if (e)
            return e.which;
        else
            return null;
    }

    function kodeScript(e, goods, field) {
        var key, keychar;
        key = getkey(e);
        if (key == null) return true;

        keychar = String.fromCharCode(key);
        keychar = keychar.toLowerCase();
        goods = goods.toLowerCase();

        // check goodkeys
        if (goods.indexOf(keychar) != -1)
            return true;
        // control keys
        if (key == null || key == 0 || key == 8 || key == 9 || key == 27)
            return true;

        if (key == 13) {
            var i;
            for (i = 0; i < field.form.elements.length; i++)
                if (field == field.form.elements[i])
                    break;
            i = (i + 1) % field.form.elements.length;
            field.form.elements[i].focus();
            return false;
        };
        // else return false
        return false;
    }
</script>
<?php ini_set('display_errors', 'off');  ?>