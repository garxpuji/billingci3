<div class="container">
    <?php $this->view('messages') ?>
</div>
<div class="row">
    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <img src="<?= base_url('assets/images/') ?><?= $company['logo'] ?>" width="150">
                    <h4 class="card-title mt-10"><?= $company['company_name'] ?></h4>
                    <p class="card-subtitle"><?= $company['sub_name'] ?></p>

                </div>
            </div>
            <hr class="mb-0">
            <div class="card-body">
                <small class="text-muted d-block">Email address </small>
                <h6><?= $company['email'] ?></h6>
                <small class="text-muted d-block pt-10">Phone</small>
                <h6><?= $company['whatsapp'] ?></h6>
                <small class="text-muted d-block pt-10">Address</small>
                <h6><?= $company['address'] ?></h6>

                <small class="text-muted d-block pt-30">Social Profile</small>
                <br>
                <div class="header-medsos" style="font-size: 40px;">
                    <a href="https://www.instagram.com/<?= $company['instagram']; ?>" target="blank"><i class=" fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/<?= $company['facebook']; ?>" target="blank"><i class=" fab fa-facebook"></i></a>
                    <!-- <a href=""><i class="fab fa-youtube"></i></a> -->
                    <a href="https://api.whatsapp.com/send?phone=<?= indo_tlp($company['whatsapp']); ?>"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-7">
        <div class="card">
            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active show" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">Tentang</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">Maps</a>
                </li> -->
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade active show" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="card-body">
                        <p>
                            <?= $company['description'] ?>
                        </p>
                    </div>
                </div>
                <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                    <div class="card-body">
                        <iframe src="<?= $company['maps'] ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>