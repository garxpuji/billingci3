<style>
    .list-group.list-group-tree {
        padding: 0;
    }

    .list-group.list-group-tree .list-group {
        margin-bottom: 0;
    }

    .list-group.list-group-tree>.list-group>.list-group-item {
        padding-left: 30px;
    }

    .list-group.list-group-tree>.list-group>.list-group>.list-group-item {
        padding-left: 45px;
    }

    .list-group.list-group-tree>.list-group>.list-group>.list-group-item>.list-group-item {
        padding-left: 60px;
    }

    .list-group.list-group-tree>.list-group>.list-group>.list-group-item>.list-group-item>.list-group-item {
        padding-left: 75px;
    }

    .list-group.list-group-tree>.list-group>.list-group>.list-group-item>.list-group-item>.list-group-item>.list-group-item {
        padding-left: 90px;
    }






    .list-group-item .fa {
        margin-right: 5px;
    }

    .fa-chevron:before {
        content: "\f054";
        /*right*/
    }

    .in>.fa-chevron:before {
        content: "\f078";
        /*down*/
    }
</style>
<?php $this->view('messages') ?>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Role Menu</h6>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card-body">
                    <?php $menuoperator = $this->db->get_where('role_menu', ['role_id' => 3])->row_array() ?>
                    <?php $menuteknisi = $this->db->get_where('role_menu', ['role_id' => 5])->row_array() ?>
                    <?php $menumitra = $this->db->get_where('role_menu', ['role_id' => 4])->row_array() ?>
                    <div class="form-group">
                        <label for="">Level</label>
                        <select name="role_id" id="role_id" class="form-control" onChange="select_template(this);">
                            <option value="3">Operator</option>
                            <!-- <option value="4">Mitra</option> -->
                            <option value="5">Teknisi</option>
                        </select>
                    </div>
                    <div id="operator" style="display: block">
                        <?php echo form_open_multipart('role/updatemenuoperator') ?>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Pelanggan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['customer_menu'] == 1 ? 'checked' : ''; ?> name="customer_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['customer_add'] == 1 ? 'checked' : ''; ?> name="customer_add"> Tambah</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['customer_active'] == 1 ? 'checked' : ''; ?> name="customer_active"> Aktif</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['customer_non_active'] == 1 ? 'checked' : ''; ?> name="customer_non_active"> Non-Aktif</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['customer_waiting'] == 1 ? 'checked' : ''; ?> name="customer_waiting"> Menunggu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['customer_free'] == 1 ? 'checked' : ''; ?> name="customer_free"> Free</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['customer_isolir'] == 1 ? 'checked' : ''; ?> name="customer_isolir"> Isolir</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['customer'] == 1 ? 'checked' : ''; ?> name="customer"> Semua</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['customer_whatsapp'] == 1 ? 'checked' : ''; ?> name="customer_whatsapp"> Whatsapp</a>

                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['customer_maps'] == 1 ? 'checked' : ''; ?> name="customer_maps"> Maps</a>

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Coverage
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['coverage_menu'] == 1 ? 'checked' : ''; ?> name="coverage_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['coverage_add'] == 1 ? 'checked' : ''; ?> name="coverage_add"> Tambah</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['coverage'] == 1 ? 'checked' : ''; ?> name="coverage"> Daftar Coverage</a>
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['coverage_maps'] == 1 ? 'checked' : ''; ?> name="coverage_maps"> Maps Area</a> -->

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Layanan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['services_menu'] == 1 ? 'checked' : ''; ?> name="services_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['services_item'] == 1 ? 'checked' : ''; ?> name="services_item"> Paket</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['services_category'] == 1 ? 'checked' : ''; ?> name="services_category"> Kategori</a>

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Tagihan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['bill_menu'] == 1 ? 'checked' : ''; ?> name="bill_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['bill_unpaid'] == 1 ? 'checked' : ''; ?> name="bill_unpaid"> Belum Bayar</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['bill_paid'] == 1 ? 'checked' : ''; ?> name="bill_paid"> Sudah Bayar</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['bill'] == 1 ? 'checked' : ''; ?> name="bill"> Semua</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['bill_due_date'] == 1 ? 'checked' : ''; ?> name="bill_due_date"> Jatuh Tempo</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['bill_draf'] == 1 ? 'checked' : ''; ?> name="bill_draf"> Tagihan Bulan Ini</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['bill_debt'] == 1 ? 'checked' : ''; ?> name="bill_debt"> Tunggakan</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['bill_confirm'] == 1 ? 'checked' : ''; ?> name="bill_confirm"> Konfirmasi Pemabayaran</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['bill_code_coupon'] == 1 ? 'checked' : ''; ?> name="bill_code_coupon"> Kode Kupon</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['bill_history'] == 1 ? 'checked' : ''; ?> name="bill_history"> Riwayat</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['bill_send'] == 1 ? 'checked' : ''; ?> name="bill_send"> Kirim Tagihan</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['bill_delete'] == 1 ? 'checked' : ''; ?> name="bill_delete"> Hapus Tagihan</a>
                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Keuangan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['finance_menu'] == 1 ? 'checked' : ''; ?> name="finance_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['finance_income'] == 1 ? 'checked' : ''; ?> name="finance_income"> Pemasukan</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['finance_expend'] == 1 ? 'checked' : ''; ?> name="finance_expend"> Pengeluaran</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['finance_report'] == 1 ? 'checked' : ''; ?> name="finance_report"> Laporan</a>
                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Bantuan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['help_menu'] == 1 ? 'checked' : ''; ?> name="help_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['help'] == 1 ? 'checked' : ''; ?> name="help"> Bantuan</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['help_category'] == 1 ? 'checked' : ''; ?> name="help_category"> Kategory & Solusi</a>

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Router
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['router_menu'] == 1 ? 'checked' : ''; ?> name="router_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['router'] == 1 ? 'checked' : ''; ?> name="router"> Data Router</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['router_customer'] == 1 ? 'checked' : ''; ?> name="router_customer"> Customer</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['router_schedule'] == 1 ? 'checked' : ''; ?> name="router_schedule"> Schedule</a>

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Website
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['website_menu'] == 1 ? 'checked' : ''; ?> name="website_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['website_slide'] == 1 ? 'checked' : ''; ?> name="website_slide"> Slide</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['website_product'] == 1 ? 'checked' : ''; ?> name="website_product"> Produk</a>


                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Pengguna
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['user_menu'] == 1 ? 'checked' : ''; ?> name="user_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['user_add'] == 1 ? 'checked' : ''; ?> name="user_add"> Tambah</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['user_admin'] == 1 ? 'checked' : ''; ?> name="user_admin"> Administrator</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['user_customer'] == 1 ? 'checked' : ''; ?> name="user_customer"> Pelanggan</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['user_operator'] == 1 ? 'checked' : ''; ?> name="user_operator"> Operator</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['user_teknisi'] == 1 ? 'checked' : ''; ?> name="user_teknisi"> Teknisi</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['user_mitra'] == 1 ? 'checked' : ''; ?> name="user_mitra"> Mitra</a>
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['user_outlet'] == 1 ? 'checked' : ''; ?> name="user_outlet"> Outlet</a> -->
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['user'] == 1 ? 'checked' : ''; ?> name="user"> Semua</a>


                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Role Management
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['role_menu'] == 1 ? 'checked' : ''; ?> name="role_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['role_access'] == 1 ? 'checked' : ''; ?> name="role_access"> Access</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['role_sub_menu'] == 1 ? 'checked' : ''; ?> name="role_sub_menu"> Menu </a>
                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Integrasi
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['integration_menu'] == 1 ? 'checked' : ''; ?> name="integration_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['integration_whatsapp'] == 1 ? 'checked' : ''; ?> name="integration_whatsapp"> Whatsapp Gateway</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['integration_payment_gateway'] == 1 ? 'checked' : ''; ?> name="integration_payment_gateway"> Payment Gateway </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['integration_telegram'] == 1 ? 'checked' : ''; ?> name="integration_telegram"> Telegram Bot </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['integration_sms'] == 1 ? 'checked' : ''; ?> name="integration_sms"> SMS Gateway </a>

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Pengaturan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['setting_menu'] == 1 ? 'checked' : ''; ?> name="setting_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['setting_company'] == 1 ? 'checked' : ''; ?> name="setting_company"> Perusahaan</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['setting_about_company'] == 1 ? 'checked' : ''; ?> name="setting_about_company"> Tentang Perusahaan </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['setting_bank_account'] == 1 ? 'checked' : ''; ?> name="setting_bank_account"> Rekening Bank </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['setting_terms_conditions'] == 1 ? 'checked' : ''; ?> name="setting_terms_conditions"> Syarat & Ketentuan </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['setting_privacy_policy'] == 1 ? 'checked' : ''; ?> name="setting_privacy_policy"> Kebijakan Privasi </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['setting_logs'] == 1 ? 'checked' : ''; ?> name="setting_logs"> Logs </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['setting_backup'] == 1 ? 'checked' : ''; ?> name="setting_backup"> Backup </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuoperator['setting_other'] == 1 ? 'checked' : ''; ?> name="setting_other"> Lainnya </a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>

                        <?php echo form_close() ?>
                    </div>


                    <div id="teknisi" style="display: none">
                        <?php echo form_open_multipart('role/updatemenuteknisi') ?>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Pelanggan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['customer_menu'] == 1 ? 'checked' : ''; ?> name="customer_menu"> Tampil Menu</a>
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['customer_add'] == 1 ? 'checked' : ''; ?> name="customer_add"> Tambah</a> -->
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['customer_active'] == 1 ? 'checked' : ''; ?> name="customer_active"> Aktif</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['customer_non_active'] == 1 ? 'checked' : ''; ?> name="customer_non_active"> Non-Aktif</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['customer_waiting'] == 1 ? 'checked' : ''; ?> name="customer_waiting"> Menunggu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['customer'] == 1 ? 'checked' : ''; ?> name="customer"> Semua</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['customer_whatsapp'] == 1 ? 'checked' : ''; ?> name="customer_whatsapp"> Whatsapp</a>

                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['customer_maps'] == 1 ? 'checked' : ''; ?> name="customer_maps"> Maps</a>

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Coverage
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['coverage_menu'] == 1 ? 'checked' : ''; ?> name="coverage_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['coverage_add'] == 1 ? 'checked' : ''; ?> name="coverage_add"> Tambah</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['coverage'] == 1 ? 'checked' : ''; ?> name="coverage"> Daftar Coverage</a>
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['coverage_maps'] == 1 ? 'checked' : ''; ?> name="coverage_maps"> Maps Area</a> -->

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Layanan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['services_menu'] == 1 ? 'checked' : ''; ?> name="services_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['services_item'] == 1 ? 'checked' : ''; ?> name="services_item"> Paket</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['services_category'] == 1 ? 'checked' : ''; ?> name="services_category"> Kategori</a>
                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Tagihan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['bill_menu'] == 1 ? 'checked' : ''; ?> name="bill_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['bill_unpaid'] == 1 ? 'checked' : ''; ?> name="bill_unpaid"> Belum Bayar</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['bill_paid'] == 1 ? 'checked' : ''; ?> name="bill_paid"> Sudah Bayar</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['bill'] == 1 ? 'checked' : ''; ?> name="bill"> Semua</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['bill_due_date'] == 1 ? 'checked' : ''; ?> name="bill_due_date"> Jatuh Tempo</a>
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['bill_draf'] == 1 ? 'checked' : ''; ?> name="bill_draf"> Tagihan Bulan Ini</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['bill_debt'] == 1 ? 'checked' : ''; ?> name="bill_debt"> Tunggakan</a> -->
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['bill_confirm'] == 1 ? 'checked' : ''; ?> name="bill_confirm"> Konfirmasi Pemabayaran</a> -->
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['bill_code_coupon'] == 1 ? 'checked' : ''; ?> name="bill_code_coupon"> Kode Kupon</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['bill_history'] == 1 ? 'checked' : ''; ?> name="bill_history"> Riwayat</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['bill_send'] == 1 ? 'checked' : ''; ?> name="bill_send"> Kirim Tagihan</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['bill_delete'] == 1 ? 'checked' : ''; ?> name="bill_delete"> Hapus Tagihan</a>
                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Keuangan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['finance_menu'] == 1 ? 'checked' : ''; ?> name="finance_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['finance_income'] == 1 ? 'checked' : ''; ?> name="finance_income"> Pemasukan</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['finance_expend'] == 1 ? 'checked' : ''; ?> name="finance_expend"> Pengeluaran</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['finance_report'] == 1 ? 'checked' : ''; ?> name="finance_report"> Laporan</a>
                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Bantuan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['help_menu'] == 1 ? 'checked' : ''; ?> name="help_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['help'] == 1 ? 'checked' : ''; ?> name="help"> Bantuan</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['help_category'] == 1 ? 'checked' : ''; ?> name="help_category"> Kategory & Solusi</a>

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Router
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['router_menu'] == 1 ? 'checked' : ''; ?> name="router_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['router'] == 1 ? 'checked' : ''; ?> name="router"> Data Router</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['router_customer'] == 1 ? 'checked' : ''; ?> name="router_customer"> Customer</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['router_schedule'] == 1 ? 'checked' : ''; ?> name="router_schedule"> Schedule</a>

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Website
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['website_menu'] == 1 ? 'checked' : ''; ?> name="website_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['website_slide'] == 1 ? 'checked' : ''; ?> name="website_slide"> Slide</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['website_product'] == 1 ? 'checked' : ''; ?> name="website_product"> Produk</a>


                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Pengguna
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['user_menu'] == 1 ? 'checked' : ''; ?> name="user_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['user_add'] == 1 ? 'checked' : ''; ?> name="user_add"> Tambah</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['user_admin'] == 1 ? 'checked' : ''; ?> name="user_admin"> Administrator</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['user_customer'] == 1 ? 'checked' : ''; ?> name="user_customer"> Pelanggan</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['user_operator'] == 1 ? 'checked' : ''; ?> name="user_operator"> Operator</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['user_teknisi'] == 1 ? 'checked' : ''; ?> name="user_teknisi"> Teknisi</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['user_mitra'] == 1 ? 'checked' : ''; ?> name="user_mitra"> Mitra</a>
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['user_outlet'] == 1 ? 'checked' : ''; ?> name="user_outlet"> Outlet</a> -->
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['user'] == 1 ? 'checked' : ''; ?> name="user"> Semua</a>


                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Role Management
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['role_menu'] == 1 ? 'checked' : ''; ?> name="role_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['role_access'] == 1 ? 'checked' : ''; ?> name="role_access"> Access</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['role_sub_menu'] == 1 ? 'checked' : ''; ?> name="role_sub_menu"> Menu </a>
                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Integrasi
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['integration_menu'] == 1 ? 'checked' : ''; ?> name="integration_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['integration_whatsapp'] == 1 ? 'checked' : ''; ?> name="integration_whatsapp"> Whatsapp Gateway</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['integration_payment_gateway'] == 1 ? 'checked' : ''; ?> name="integration_payment_gateway"> Payment Gateway </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['integration_telegram'] == 1 ? 'checked' : ''; ?> name="integration_telegram"> Telegram Bot </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['integration_sms'] == 1 ? 'checked' : ''; ?> name="integration_sms"> SMS Gateway </a>

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Pengaturan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['setting_menu'] == 1 ? 'checked' : ''; ?> name="setting_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['setting_company'] == 1 ? 'checked' : ''; ?> name="setting_company"> Perusahaan</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['setting_about_company'] == 1 ? 'checked' : ''; ?> name="setting_about_company"> Tentang Perusahaan </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['setting_bank_account'] == 1 ? 'checked' : ''; ?> name="setting_bank_account"> Rekening Bank </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['setting_terms_conditions'] == 1 ? 'checked' : ''; ?> name="setting_terms_conditions"> Syarat & Ketentuan </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['setting_privacy_policy'] == 1 ? 'checked' : ''; ?> name="setting_privacy_policy"> Kebijakan Privasi </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['setting_logs'] == 1 ? 'checked' : ''; ?> name="setting_logs"> Logs </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['setting_backup'] == 1 ? 'checked' : ''; ?> name="setting_backup"> Backup </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menuteknisi['setting_other'] == 1 ? 'checked' : ''; ?> name="setting_other"> Lainnya </a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>

                        <?php echo form_close() ?>
                    </div>
                    <div id="mitra" style="display: none">
                        <?php echo form_open_multipart('role/updatemenumitra') ?>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Pelanggan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['customer_menu'] == 1 ? 'checked' : ''; ?> name="customer_menu"> Tampil Menu</a>
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['customer_add'] == 1 ? 'checked' : ''; ?> name="customer_add"> Tambah</a> -->
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['customer_active'] == 1 ? 'checked' : ''; ?> name="customer_active"> Aktif</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['customer_non_active'] == 1 ? 'checked' : ''; ?> name="customer_non_active"> Non-Aktif</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['customer_waiting'] == 1 ? 'checked' : ''; ?> name="customer_waiting"> Menunggu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['customer'] == 1 ? 'checked' : ''; ?> name="customer"> Semua</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['customer_whatsapp'] == 1 ? 'checked' : ''; ?> name="customer_whatsapp"> Whatsapp</a>

                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['customer_maps'] == 1 ? 'checked' : ''; ?> name="customer_maps"> Maps</a>

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Coverage
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['coverage_menu'] == 1 ? 'checked' : ''; ?> name="coverage_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['coverage_add'] == 1 ? 'checked' : ''; ?> name="coverage_add"> Tambah</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['coverage'] == 1 ? 'checked' : ''; ?> name="coverage"> Daftar Coverage</a>
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['coverage_maps'] == 1 ? 'checked' : ''; ?> name="coverage_maps"> Maps Area</a> -->

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Layanan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['services_menu'] == 1 ? 'checked' : ''; ?> name="services_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['services_item'] == 1 ? 'checked' : ''; ?> name="services_item"> Paket</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['services_category'] == 1 ? 'checked' : ''; ?> name="services_category"> Kategori</a>
                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Tagihan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['bill_menu'] == 1 ? 'checked' : ''; ?> name="bill_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['bill_unpaid'] == 1 ? 'checked' : ''; ?> name="bill_unpaid"> Belum Bayar</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['bill_paid'] == 1 ? 'checked' : ''; ?> name="bill_paid"> Sudah Bayar</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['bill'] == 1 ? 'checked' : ''; ?> name="bill"> Semua</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['bill_due_date'] == 1 ? 'checked' : ''; ?> name="bill_due_date"> Jatuh Tempo</a>
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['bill_draf'] == 1 ? 'checked' : ''; ?> name="bill_draf"> Tagihan Bulan Ini</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['bill_debt'] == 1 ? 'checked' : ''; ?> name="bill_debt"> Tunggakan</a> -->
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['bill_confirm'] == 1 ? 'checked' : ''; ?> name="bill_confirm"> Konfirmasi Pemabayaran</a> -->
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['bill_code_coupon'] == 1 ? 'checked' : ''; ?> name="bill_code_coupon"> Kode Kupon</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['bill_history'] == 1 ? 'checked' : ''; ?> name="bill_history"> Riwayat</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['bill_send'] == 1 ? 'checked' : ''; ?> name="bill_send"> Kirim Tagihan</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['bill_delete'] == 1 ? 'checked' : ''; ?> name="bill_delete"> Hapus Tagihan</a>
                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Keuangan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['finance_menu'] == 1 ? 'checked' : ''; ?> name="finance_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['finance_income'] == 1 ? 'checked' : ''; ?> name="finance_income"> Pemasukan</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['finance_expend'] == 1 ? 'checked' : ''; ?> name="finance_expend"> Pengeluaran</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['finance_report'] == 1 ? 'checked' : ''; ?> name="finance_report"> Laporan</a>
                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Bantuan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['help_menu'] == 1 ? 'checked' : ''; ?> name="help_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['help'] == 1 ? 'checked' : ''; ?> name="help"> Bantuan</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['help_category'] == 1 ? 'checked' : ''; ?> name="help_category"> Kategory & Solusi</a>

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Router
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['router_menu'] == 1 ? 'checked' : ''; ?> name="router_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['router'] == 1 ? 'checked' : ''; ?> name="router"> Data Router</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['router_customer'] == 1 ? 'checked' : ''; ?> name="router_customer"> Customer</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['router_schedule'] == 1 ? 'checked' : ''; ?> name="router_schedule"> Schedule</a>

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Website
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['website_menu'] == 1 ? 'checked' : ''; ?> name="website_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['website_slide'] == 1 ? 'checked' : ''; ?> name="website_slide"> Slide</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['website_product'] == 1 ? 'checked' : ''; ?> name="website_product"> Produk</a>


                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Pengguna
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['user_menu'] == 1 ? 'checked' : ''; ?> name="user_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['user_add'] == 1 ? 'checked' : ''; ?> name="user_add"> Tambah</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['user_admin'] == 1 ? 'checked' : ''; ?> name="user_admin"> Administrator</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['user_customer'] == 1 ? 'checked' : ''; ?> name="user_customer"> Pelanggan</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['user_operator'] == 1 ? 'checked' : ''; ?> name="user_operator"> Operator</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['user_teknisi'] == 1 ? 'checked' : ''; ?> name="user_teknisi"> Teknisi</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['user_mitra'] == 1 ? 'checked' : ''; ?> name="user_mitra"> Mitra</a>
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['user_outlet'] == 1 ? 'checked' : ''; ?> name="user_outlet"> Outlet</a> -->
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['user'] == 1 ? 'checked' : ''; ?> name="user"> Semua</a>


                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Role Management
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['role_menu'] == 1 ? 'checked' : ''; ?> name="role_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['role_access'] == 1 ? 'checked' : ''; ?> name="role_access"> Access</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['role_sub_menu'] == 1 ? 'checked' : ''; ?> name="role_sub_menu"> Menu </a>
                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Integrasi
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['integration_menu'] == 1 ? 'checked' : ''; ?> name="integration_menu"> Tampil Menu</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['integration_whatsapp'] == 1 ? 'checked' : ''; ?> name="integration_whatsapp"> Whatsapp Gateway</a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['integration_payment_gateway'] == 1 ? 'checked' : ''; ?> name="integration_payment_gateway"> Payment Gateway </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['integration_telegram'] == 1 ? 'checked' : ''; ?> name="integration_telegram"> Telegram Bot </a>
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['integration_sms'] == 1 ? 'checked' : ''; ?> name="integration_sms"> SMS Gateway </a>

                            </div>
                        </div>
                        <div class="list-group list-group-tree well">
                            <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black">
                                <i class="fa fa-chevron"></i>
                                Pengaturan
                            </a>
                            <div class="list-group collapse" style="text-decoration: none; color:black">
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['setting_menu'] == 1 ? 'checked' : ''; ?> name="setting_menu"> Tampil Menu</a>
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['setting_company'] == 1 ? 'checked' : ''; ?> name="setting_company"> Perusahaan</a> -->
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['setting_about_company'] == 1 ? 'checked' : ''; ?> name="setting_about_company"> Tentang Perusahaan </a> -->
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['setting_bank_account'] == 1 ? 'checked' : ''; ?> name="setting_bank_account"> Rekening Bank </a>
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['setting_terms_conditions'] == 1 ? 'checked' : ''; ?> name="setting_terms_conditions"> Syarat & Ketentuan </a> -->
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['setting_privacy_policy'] == 1 ? 'checked' : ''; ?> name="setting_privacy_policy"> Kebijakan Privasi </a> -->
                                <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['setting_logs'] == 1 ? 'checked' : ''; ?> name="setting_logs"> Logs </a>
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['setting_backup'] == 1 ? 'checked' : ''; ?> name="setting_backup"> Backup </a> -->
                                <!-- <a href="javascript:void(0);" class="list-group-item" style="text-decoration: none; color:black"><input type="checkbox" <?= $menumitra['setting_other'] == 1 ? 'checked' : ''; ?> name="setting_other"> Lainnya </a> -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>

                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-body">
                    <div class="form-group">
                        <h5>Catatan</h5>
                        - Setelah edit role menu setiap level pengguna harus disimpan dulu sebelum pilih level pengguna yang lain.
                    </div>

                </div>

            </div>
        </div>
    </div>
    <script>
        function select_template(sel) {
            var template = $("#role_id").val();
            if (template == 3) {

                $("#operator").show();
                $("#teknisi").hide();
                $("#mitra").hide();

            }
            if (template == 4) {
                $("#operator").hide();
                $("#mitra").show();
                $("#teknisi").hide();

            }
            if (template == 5) {
                $("#operator").hide();
                $("#mitra").hide();
                $("#teknisi").show();

            }



        }
    </script>

    <script>
        $(function() {

            // delegated handler
            $(".list-group-tree").on('click', "[data-toggle=collapse]", function() {
                $(this).toggleClass('in')
                $(this).next(".list-group.collapse").collapse('toggle');

                // next up, when you click, dynamically load contents with ajax - THEN toggle
                return false;
            })

        });
    </script>