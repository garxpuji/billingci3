<?php $customer = $this->db->get_where('customer', ['email' => $this->session->userdata('email')])->row_array() ?>
<div class="row">
    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <img src="<?= base_url(''); ?>assets/images/profile/<?= $user['image']; ?>" class="rounded-circle" width="150">
                    <h4 class="card-title mt-10"><?= $user['name'] ?></h4>
                    <!-- <p class="card-subtitle">Front End Developer</p>
                    <div class="row text-center justify-content-md-center">
                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="ik ik-user"></i>
                                <font class="font-medium">254</font>
                            </a></div>
                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="ik ik-image"></i>
                                <font class="font-medium">54</font>
                            </a></div>
                    </div> -->
                </div>
            </div>
            <hr class="mb-0">
            <div class="card-body">
                <small class="text-muted d-block">Email Address </small>
                <h6><?= $user['email']; ?></h6>
                <small class="text-muted d-block pt-10">Phone</small>
                <h6><?= $user['phone']; ?></h6>
                <small class="text-muted d-block pt-10">Address</small>
                <h6><?= $user['address']; ?></h6>

                <!-- <small class="text-muted d-block pt-30">Social Profile</small>
                <br>
                <button class="btn btn-icon btn-facebook"><i class="fab fa-facebook-f"></i></button>
                <button class="btn btn-icon btn-twitter"><i class="fab fa-twitter"></i></button>
                <button class="btn btn-icon btn-instagram"><i class="fab fa-instagram"></i></button> -->
                <a href="<?= site_url('member/account') ?>" class="btn btn-primary">Edit Profile</a>
                <a href="" data-toggle="modal" data-target="#email" title="Edit Email" class="btn btn-primary">Ganti Email</a>
                <a href="" data-toggle="modal" data-target="#idcard" title="Edit ID-Card" class="btn btn-primary">Ganti ID-Card</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="idcard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update ID Card</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('user/editidcard') ?>" method="POST">

                    <div class="form-group">
                        <label for="no_ktp">ID Card</label>
                        <div class="form-group row">
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <select name="type_id" id="type_id" class="form-control" required>
                                    <option value="<?= $customer['type_id'] ?>"><?= $customer['type_id'] ?></option>
                                    <option value="KTP">KTP</option>
                                    <option value="SIM">SIM</option>
                                    <option value="NPWP">NPWP</option>
                                    <option value="Pasport">Pasport</option>
                                </select>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" id="no_ktp" name="no_ktp" class="form-control" value="<?= $customer['no_ktp'] ?>">
                                <?= form_error('no_ktp', '<small class="text-danger pl-3 ">', '</small>') ?>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('user/editEmail') ?>" method="POST">
                    <div class="form-group">
                        <label for="cemail">Current Email</label>
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <input type="text" name="cemail" id="cemail" class="form-control" value="<?= $user['email'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">New Email</label>
                        <input type="text" name="email" id="email" class="form-control">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>