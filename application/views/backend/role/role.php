<?php $this->view('messages') ?>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Role Access</h6>
        </div>
        <?php $roleoperator = $this->db->get_where('role_management', ['role_id' => 3])->row_array() ?>
        <?php $roleteknisi = $this->db->get_where('role_management', ['role_id' => 5])->row_array() ?>
        <?php $rolemitra = $this->db->get_where('role_management', ['role_id' => 4])->row_array() ?>
        <?php $rolekolektor = $this->db->get_where('role_management', ['role_id' => 7])->row_array() ?>
        <?php $rolefinance = $this->db->get_where('role_management', ['role_id' => 8])->row_array() ?>
        <?php $roleoperator = $this->db->get_where('role_management', ['role_id' => 3])->row_array() ?>

        <div class="row">
            <div class="col-lg-6">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <div class="form-group">
                                <label for="">Level</label>
                                <select name="role_id" id="role_id" class="form-control" onChange="select_template(this);">
                                    <option value="3">Operator / Customer Service</option>
                                    <!-- <option value="4">Mitra</option> -->
                                    <option value="5">Teknisi</option>
                                    <!-- <option value="6">Outlet</option> -->
                                    <!-- <option value="7">Kolektor</option> -->
                                    <!-- <option value="8">Finance</option> -->
                                </select>
                            </div>
                            <div class="form-group">
                                <h5 style="color:red">Catatan</h5>
                                - Setelah edit role access setiap level pengguna harus disimpan dulu sebelum pilih level pengguna yang lain.
                            </div>
                        </thead>
                    </table>

                    <div id="operator" style="display: block">
                        <?php echo form_open_multipart('role/updateoperator') ?>
                        <?php if ($package['coverage_operator'] == 1) { ?>
                            <div class="row mb-2">
                                <div class="col">

                                    Operator By Coverage
                                </div>
                                <div class="col">
                                    <input type="checkbox" <?= $roleoperator['coverage_operator'] == 1 ? 'checked' : '' ?> name="coverage_operator">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">

                                    Tampilkan Saldo
                                </div>
                                <div class="col">
                                    <input type="checkbox" <?= $roleoperator['show_saldo'] == 1 ? 'checked' : '' ?> name="show_saldo">
                                </div>
                            </div>
                        <?php } ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Menu</th>
                                    <!-- <th scope="col">Tampil</th> -->
                                    <th scope="col">Tambah</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>


                                <tr>
                                    <th scope="row">Pelanggan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['add_customer'] == 1 ? 'checked' : '' ?> name="add_customer">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['edit_customer'] == 1 ? 'checked' : '' ?> name="edit_customer">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['del_customer'] == 1 ? 'checked' : '' ?> name="del_customer">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Layanan Item</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['add_item'] == 1 ? 'checked' : '' ?> name="add_item">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['edit_item'] == 1 ? 'checked' : '' ?> name="edit_item">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['del_item'] == 1 ? 'checked' : '' ?> name="del_item">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Tagihan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['add_bill'] == 1 ? 'checked' : '' ?> name="add_bill">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['edit_bill'] == 1 ? 'checked' : '' ?> name="edit_bill">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['del_bill'] == 1 ? 'checked' : '' ?> name="del_bill">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Keuangan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['add_income'] == 1 ? 'checked' : '' ?> name="add_income">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['edit_income'] == 1 ? 'checked' : '' ?> name="edit_income">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['del_income'] == 1 ? 'checked' : '' ?> name="del_income">
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">Coverage</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['add_coverage'] == 1 ? 'checked' : '' ?> name="add_coverage">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['edit_coverage'] == 1 ? 'checked' : '' ?> name="edit_coverage">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['del_coverage'] == 1 ? 'checked' : '' ?> name="del_coverage">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Slide</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['add_slide'] == 1 ? 'checked' : '' ?> name="add_slide">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['edit_slide'] == 1 ? 'checked' : '' ?> name="edit_slide">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['del_slide'] == 1 ? 'checked' : '' ?> name="del_slide">
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">Produk</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['add_product'] == 1 ? 'checked' : '' ?> name="add_product">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['edit_product'] == 1 ? 'checked' : '' ?> name="edit_product">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['del_product'] == 1 ? 'checked' : '' ?> name="del_product">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Router</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['add_router'] == 1 ? 'checked' : '' ?> name="add_router">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['edit_router'] == 1 ? 'checked' : '' ?> name="edit_router">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['del_router'] == 1 ? 'checked' : '' ?> name="del_router">
                                    </td>
                                <tr>
                                    <th scope="row">Pengguna</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['add_user'] == 1 ? 'checked' : '' ?> name="add_user">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['edit_user'] == 1 ? 'checked' : '' ?> name="edit_user">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['del_user'] == 1 ? 'checked' : '' ?> name="del_user">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Bantuan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['add_help'] == 1 ? 'checked' : '' ?> name="add_help">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['edit_help'] == 1 ? 'checked' : '' ?> name="edit_help">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['del_help'] == 1 ? 'checked' : '' ?> name="del_help">
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th scope="row">ODC</th>
                                    <td>

                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['add_odc'] == 1 ? 'checked' : '' ?> name="add_odc">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['edit_odc'] == 1 ? 'checked' : '' ?> name="edit_odc">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['del_odc'] == 1 ? 'checked' : '' ?> name="del_odc">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">ODP</th>
                                    <td>

                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['add_odp'] == 1 ? 'checked' : '' ?> name="add_odp">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['edit_odp'] == 1 ? 'checked' : '' ?> name="edit_odp">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleoperator['del_odp'] == 1 ? 'checked' : '' ?> name="del_odp">
                                    </td>
                                </tr> -->

                                </tr>

                            </tbody>
                        </table>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        </form>
                    </div>

                    <div id="teknisi" style="display: none">
                        <?php echo form_open_multipart('role/updateteknisi') ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Menu</th>
                                    <!-- <th scope="col">Tampil</th> -->
                                    <th scope="col">Tambah</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>


                                <tr>
                                    <th scope="row">Pelanggan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['add_customer'] == 1 ? 'checked' : '' ?> name="add_customer">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['edit_customer'] == 1 ? 'checked' : '' ?> name="edit_customer">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['del_customer'] == 1 ? 'checked' : '' ?> name="del_customer">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Layanan Item</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['add_item'] == 1 ? 'checked' : '' ?> name="add_item">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['edit_item'] == 1 ? 'checked' : '' ?> name="edit_item">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['del_item'] == 1 ? 'checked' : '' ?> name="del_item">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Tagihan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['add_bill'] == 1 ? 'checked' : '' ?> name="add_bill">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['edit_bill'] == 1 ? 'checked' : '' ?> name="edit_bill">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['del_bill'] == 1 ? 'checked' : '' ?> name="del_bill">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Keuangan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['add_income'] == 1 ? 'checked' : '' ?> name="add_income">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['edit_income'] == 1 ? 'checked' : '' ?> name="edit_income">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['del_income'] == 1 ? 'checked' : '' ?> name="del_income">
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">Coverage</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['add_coverage'] == 1 ? 'checked' : '' ?> name="add_coverage">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['edit_coverage'] == 1 ? 'checked' : '' ?> name="edit_coverage">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['del_coverage'] == 1 ? 'checked' : '' ?> name="del_coverage">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Slide</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['add_slide'] == 1 ? 'checked' : '' ?> name="add_slide">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['edit_slide'] == 1 ? 'checked' : '' ?> name="edit_slide">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['del_slide'] == 1 ? 'checked' : '' ?> name="del_slide">
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">Produk</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['add_product'] == 1 ? 'checked' : '' ?> name="add_product">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['edit_product'] == 1 ? 'checked' : '' ?> name="edit_product">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['del_product'] == 1 ? 'checked' : '' ?> name="del_product">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Router</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['add_router'] == 1 ? 'checked' : '' ?> name="add_router">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['edit_router'] == 1 ? 'checked' : '' ?> name="edit_router">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['del_router'] == 1 ? 'checked' : '' ?> name="del_router">
                                    </td>
                                <tr>
                                    <th scope="row">Pengguna</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['add_user'] == 1 ? 'checked' : '' ?> name="add_user">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['edit_user'] == 1 ? 'checked' : '' ?> name="edit_user">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['del_user'] == 1 ? 'checked' : '' ?> name="del_user">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Bantuan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['add_help'] == 1 ? 'checked' : '' ?> name="add_help">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['edit_help'] == 1 ? 'checked' : '' ?> name="edit_help">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['del_help'] == 1 ? 'checked' : '' ?> name="del_help">
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th scope="row">ODC</th>
                                    <td>

                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['add_odc'] == 1 ? 'checked' : '' ?> name="add_odc">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['edit_odc'] == 1 ? 'checked' : '' ?> name="edit_odc">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['del_odc'] == 1 ? 'checked' : '' ?> name="del_odc">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">ODP</th>
                                    <td>

                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['add_odp'] == 1 ? 'checked' : '' ?> name="add_odp">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['edit_odp'] == 1 ? 'checked' : '' ?> name="edit_odp">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $roleteknisi['del_odp'] == 1 ? 'checked' : '' ?> name="del_odp">
                                    </td>
                                </tr> -->

                                </tr>

                            </tbody>
                        </table>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        </form>
                    </div>

                    <div id="finance" style="display: none">
                        <?php echo form_open_multipart('role/updatefinance') ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Menu</th>
                                    <!-- <th scope="col">Tampil</th> -->
                                    <th scope="col">Tambah</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>


                                <tr>
                                    <th scope="row">Pelanggan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['add_customer'] == 1 ? 'checked' : '' ?> name="add_customer">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['edit_customer'] == 1 ? 'checked' : '' ?> name="edit_customer">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['del_customer'] == 1 ? 'checked' : '' ?> name="del_customer">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Layanan Item</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['add_item'] == 1 ? 'checked' : '' ?> name="add_item">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['edit_item'] == 1 ? 'checked' : '' ?> name="edit_item">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['del_item'] == 1 ? 'checked' : '' ?> name="del_item">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Tagihan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['add_bill'] == 1 ? 'checked' : '' ?> name="add_bill">
                                    </td>
                                    <td>
                                        <!-- <input type="checkbox" <?= $rolefinance['edit_bill'] == 1 ? 'checked' : '' ?> name="edit_bill"> -->
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['del_bill'] == 1 ? 'checked' : '' ?> name="del_bill">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Keuangan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['add_income'] == 1 ? 'checked' : '' ?> name="add_income">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['edit_income'] == 1 ? 'checked' : '' ?> name="edit_income">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['del_income'] == 1 ? 'checked' : '' ?> name="del_income">
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">Coverage</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['add_coverage'] == 1 ? 'checked' : '' ?> name="add_coverage">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['edit_coverage'] == 1 ? 'checked' : '' ?> name="edit_coverage">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['del_coverage'] == 1 ? 'checked' : '' ?> name="del_coverage">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Slide</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['add_slide'] == 1 ? 'checked' : '' ?> name="add_slide">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['edit_slide'] == 1 ? 'checked' : '' ?> name="edit_slide">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['del_slide'] == 1 ? 'checked' : '' ?> name="del_slide">
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">Produk</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['add_product'] == 1 ? 'checked' : '' ?> name="add_product">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['edit_product'] == 1 ? 'checked' : '' ?> name="edit_product">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['del_product'] == 1 ? 'checked' : '' ?> name="del_product">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Router</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['add_router'] == 1 ? 'checked' : '' ?> name="add_router">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['edit_router'] == 1 ? 'checked' : '' ?> name="edit_router">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['del_router'] == 1 ? 'checked' : '' ?> name="del_router">
                                    </td>
                                <tr>
                                    <th scope="row">Pengguna</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['add_user'] == 1 ? 'checked' : '' ?> name="add_user">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['edit_user'] == 1 ? 'checked' : '' ?> name="edit_user">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['del_user'] == 1 ? 'checked' : '' ?> name="del_user">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Bantuan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['add_help'] == 1 ? 'checked' : '' ?> name="add_help">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['edit_help'] == 1 ? 'checked' : '' ?> name="edit_help">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['del_help'] == 1 ? 'checked' : '' ?> name="del_help">
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th scope="row">ODC</th>
                                    <td>

                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['add_odc'] == 1 ? 'checked' : '' ?> name="add_odc">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['edit_odc'] == 1 ? 'checked' : '' ?> name="edit_odc">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['del_odc'] == 1 ? 'checked' : '' ?> name="del_odc">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">ODP</th>
                                    <td>

                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['add_odp'] == 1 ? 'checked' : '' ?> name="add_odp">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['edit_odp'] == 1 ? 'checked' : '' ?> name="edit_odp">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolefinance['del_odp'] == 1 ? 'checked' : '' ?> name="del_odp">
                                    </td>
                                </tr> -->

                                </tr>

                            </tbody>
                        </table>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        </form>
                    </div>

                    <div id="kolektor" style="display: none">
                        <?php echo form_open_multipart('role/updatekolektor') ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Menu</th>
                                    <!-- <th scope="col">Tampil</th> -->
                                    <th scope="col">Tambah</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- <tr>

                                    <th scope="row">Saldo Kas</th>
                                    <td>
                                        <?php if ($rolekolektor['show_saldo'] == 1) { ?>
                                            <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('role/roleupdate?show_saldo=0&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                        <?php } ?>
                                        <?php if ($rolekolektor['show_saldo'] == 0) { ?>
                                            <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('role/roleupdate?show_saldo=1&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                        <?php } ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr> -->
                                <tr>
                                    <th scope="row">Pelanggan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['add_customer'] == 1 ? 'checked' : '' ?> name="add_customer">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['edit_customer'] == 1 ? 'checked' : '' ?> name="edit_customer">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['del_customer'] == 1 ? 'checked' : '' ?> name="del_customer">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Layanan Item</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['add_item'] == 1 ? 'checked' : '' ?> name="add_item">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['edit_item'] == 1 ? 'checked' : '' ?> name="edit_item">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['del_item'] == 1 ? 'checked' : '' ?> name="del_item">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Tagihan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['add_bill'] == 1 ? 'checked' : '' ?> name="add_bill">
                                    </td>
                                    <td>
                                        <!-- <input type="checkbox" <?= $rolekolektor['edit_bill'] == 1 ? 'checked' : '' ?> name="edit_bill"> -->
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['del_bill'] == 1 ? 'checked' : '' ?> name="del_bill">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Keuangan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['add_income'] == 1 ? 'checked' : '' ?> name="add_income">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['edit_income'] == 1 ? 'checked' : '' ?> name="edit_income">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['del_income'] == 1 ? 'checked' : '' ?> name="del_income">
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">Coverage</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['add_coverage'] == 1 ? 'checked' : '' ?> name="add_coverage">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['edit_coverage'] == 1 ? 'checked' : '' ?> name="edit_coverage">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['del_coverage'] == 1 ? 'checked' : '' ?> name="del_coverage">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Slide</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['add_slide'] == 1 ? 'checked' : '' ?> name="add_slide">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['edit_slide'] == 1 ? 'checked' : '' ?> name="edit_slide">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['del_slide'] == 1 ? 'checked' : '' ?> name="del_slide">
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">Produk</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['add_product'] == 1 ? 'checked' : '' ?> name="add_product">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['edit_product'] == 1 ? 'checked' : '' ?> name="edit_product">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['del_product'] == 1 ? 'checked' : '' ?> name="del_product">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Router</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['add_router'] == 1 ? 'checked' : '' ?> name="add_router">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['edit_router'] == 1 ? 'checked' : '' ?> name="edit_router">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['del_router'] == 1 ? 'checked' : '' ?> name="del_router">
                                    </td>
                                <tr>
                                    <th scope="row">Pengguna</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['add_user'] == 1 ? 'checked' : '' ?> name="add_user">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['edit_user'] == 1 ? 'checked' : '' ?> name="edit_user">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['del_user'] == 1 ? 'checked' : '' ?> name="del_user">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Bantuan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['add_help'] == 1 ? 'checked' : '' ?> name="add_help">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['edit_help'] == 1 ? 'checked' : '' ?> name="edit_help">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['del_help'] == 1 ? 'checked' : '' ?> name="del_help">
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th scope="row">ODC</th>
                                    <td>

                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['add_odc'] == 1 ? 'checked' : '' ?> name="add_odc">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['edit_odc'] == 1 ? 'checked' : '' ?> name="edit_odc">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['del_odc'] == 1 ? 'checked' : '' ?> name="del_odc">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">ODP</th>
                                    <td>

                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['add_odp'] == 1 ? 'checked' : '' ?> name="add_odp">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['edit_odp'] == 1 ? 'checked' : '' ?> name="edit_odp">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolekolektor['del_odp'] == 1 ? 'checked' : '' ?> name="del_odp">
                                    </td>
                                </tr> -->

                                </tr>

                            </tbody>
                        </table>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        </form>
                    </div>
                    <div id="mitra" style="display: none">
                        <?php echo form_open_multipart('role/updatemitra') ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Menu</th>
                                    <!-- <th scope="col">Tampil</th> -->
                                    <th scope="col">Tambah</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- <tr>

                                    <th scope="row">Saldo Kas</th>
                                    <td>
                                        <?php if ($rolemitra['show_saldo'] == 1) { ?>
                                            <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('role/roleupdate?show_saldo=0&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                        <?php } ?>
                                        <?php if ($rolemitra['show_saldo'] == 0) { ?>
                                            <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('role/roleupdate?show_saldo=1&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                        <?php } ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr> -->
                                <tr>
                                    <th scope="row">Pelanggan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['add_customer'] == 1 ? 'checked' : '' ?> name="add_customer">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['edit_customer'] == 1 ? 'checked' : '' ?> name="edit_customer">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['del_customer'] == 1 ? 'checked' : '' ?> name="del_customer">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Layanan Item</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['add_item'] == 1 ? 'checked' : '' ?> name="add_item">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['edit_item'] == 1 ? 'checked' : '' ?> name="edit_item">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['del_item'] == 1 ? 'checked' : '' ?> name="del_item">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Tagihan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['add_bill'] == 1 ? 'checked' : '' ?> name="add_bill">
                                    </td>
                                    <td>
                                        <!-- <input type="checkbox" <?= $rolemitra['edit_bill'] == 1 ? 'checked' : '' ?> name="edit_bill"> -->
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['del_bill'] == 1 ? 'checked' : '' ?> name="del_bill">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Keuangan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['add_income'] == 1 ? 'checked' : '' ?> name="add_income">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['edit_income'] == 1 ? 'checked' : '' ?> name="edit_income">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['del_income'] == 1 ? 'checked' : '' ?> name="del_income">
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">Coverage</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['add_coverage'] == 1 ? 'checked' : '' ?> name="add_coverage">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['edit_coverage'] == 1 ? 'checked' : '' ?> name="edit_coverage">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['del_coverage'] == 1 ? 'checked' : '' ?> name="del_coverage">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Slide</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['add_slide'] == 1 ? 'checked' : '' ?> name="add_slide">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['edit_slide'] == 1 ? 'checked' : '' ?> name="edit_slide">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['del_slide'] == 1 ? 'checked' : '' ?> name="del_slide">
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">Produk</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['add_product'] == 1 ? 'checked' : '' ?> name="add_product">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['edit_product'] == 1 ? 'checked' : '' ?> name="edit_product">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['del_product'] == 1 ? 'checked' : '' ?> name="del_product">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Router</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['add_router'] == 1 ? 'checked' : '' ?> name="add_router">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['edit_router'] == 1 ? 'checked' : '' ?> name="edit_router">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['del_router'] == 1 ? 'checked' : '' ?> name="del_router">
                                    </td>
                                <tr>
                                    <th scope="row">Pengguna</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['add_user'] == 1 ? 'checked' : '' ?> name="add_user">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['edit_user'] == 1 ? 'checked' : '' ?> name="edit_user">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['del_user'] == 1 ? 'checked' : '' ?> name="del_user">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Bantuan</th>
                                    <!-- <td>

                                    </td> -->
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['add_help'] == 1 ? 'checked' : '' ?> name="add_help">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['edit_help'] == 1 ? 'checked' : '' ?> name="edit_help">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['del_help'] == 1 ? 'checked' : '' ?> name="del_help">
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th scope="row">ODC</th>
                                    <td>

                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['add_odc'] == 1 ? 'checked' : '' ?> name="add_odc">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['edit_odc'] == 1 ? 'checked' : '' ?> name="edit_odc">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['del_odc'] == 1 ? 'checked' : '' ?> name="del_odc">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">ODP</th>
                                    <td>

                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['add_odp'] == 1 ? 'checked' : '' ?> name="add_odp">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['edit_odp'] == 1 ? 'checked' : '' ?> name="edit_odp">
                                    </td>
                                    <td>
                                        <input type="checkbox" <?= $rolemitra['del_odp'] == 1 ? 'checked' : '' ?> name="del_odp">
                                    </td>
                                </tr> -->

                                </tr>

                            </tbody>
                        </table>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <?php $rolepelanggan = $this->db->get_where('role_management', ['role_id' => 2])->row_array() ?>
                <div class="card-body">
                    <form action="<?= site_url('role/updaterolepelanggan') ?>" method="post">
                        <table class="table">
                            <thead>
                                <tr colspan="5">Pelanggan</tr>
                            </thead>
                        </table>

                        <div class="row">

                            <div class="col">
                                <div class="form-group">
                                    <label for="">Pemakain Kuota</label>
                                    <select class="form-control" style="width:50%" id="show_usage" name="show_usage" required>
                                        <option value="<?= $rolepelanggan['show_usage']; ?>"><?= $rolepelanggan['show_usage'] == 1 ? 'Yes' : 'No' ?></option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="">Riwayat Tagihan</label>
                                    <select class="form-control" style="width:50%" id="show_history" name="show_history" required>
                                        <option value="<?= $rolepelanggan['show_history']; ?>"><?= $rolepelanggan['show_history'] == 1 ? 'Yes' : 'No' ?></option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Bantuan</label>
                                    <select class="form-control" style="width:50%" id="show_help" name="show_help" required>
                                        <option value="<?= $rolepelanggan['show_help']; ?>"><?= $rolepelanggan['show_help'] == 1 ? 'Yes' : 'No' ?></option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Cek Tagihan</label>
                                    <select class="form-control" style="width:50%" id="cek_bill" name="cek_bill" required>
                                        <option value="<?= $rolepelanggan['cek_bill']; ?>"><?= $rolepelanggan['cek_bill'] == 1 ? 'Yes' : 'No' ?></option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Cek Kuota</label>
                                    <select class="form-control" style="width:50%" id="cek_usage" name="cek_usage" required>
                                        <option value="<?= $rolepelanggan['cek_usage']; ?>"><?= $rolepelanggan['cek_usage'] == 1 ? 'Yes' : 'No' ?></option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="">Register</label>
                                    <select class="form-control" style="width:50%" id="register_show" name="register_show" required>
                                        <option value="<?= $rolepelanggan['register_show']; ?>"><?= $rolepelanggan['register_show'] == 1 ? 'Yes' : 'No' ?></option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col">
                                <div class="form-group">
                                    <label for="">Register Coverage</label>
                                    <select class="form-control" style="width:50%" id="register_coverage" name="register_coverage" required>
                                        <option value="<?= $rolepelanggan['register_coverage']; ?>"><?= $rolepelanggan['register_coverage'] == 1 ? 'Yes' : 'No' ?></option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="">Register Maps</label>
                                    <select class="form-control" style="width:50%" id="register_maps" name="register_maps" required>
                                        <option value="<?= $rolepelanggan['register_maps']; ?>"><?= $rolepelanggan['register_maps'] == 1 ? 'Yes' : 'No' ?></option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Speedtest</label>
                                    <select class="form-control" style="width:50%" id="show_speedtest" name="show_speedtest" required>
                                        <option value="<?= $rolepelanggan['show_speedtest']; ?>"><?= $rolepelanggan['show_speedtest'] == 1 ? 'Yes' : 'No' ?></option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Logs</label>
                                    <select class="form-control" style="width:50%" id="show_log" name="show_log" required>
                                        <option value="<?= $rolepelanggan['show_log']; ?>"><?= $rolepelanggan['show_log'] == 1 ? 'Yes' : 'No' ?></option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Invoice</label>
                                    <select class="form-control" style="width:50%" id="show_bill" name="show_bill" required>
                                        <option value="<?= $rolepelanggan['show_bill']; ?>"><?= $rolepelanggan['show_bill'] == 1 ? 'Yes' : 'No' ?></option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>



            </div>
        </div>
    </div>
</div>
<script>
    function select_template(sel) {
        var template = $("#role_id").val();
        if (template == 3) { // Operator
            $("#operator").show();
            $("#teknisi").hide();
            $("#mitra").hide();
            $("#outlet").hide();
            $("#finance").hide();
            $("#kolektor").hide();

        }
        if (template == 4) { // Mitra
            $("#operator").hide();
            $("#mitra").show();
            $("#teknisi").hide();
            $("#outlet").hide();
            $("#finance").hide();
            $("#kolektor").hide();

        }
        if (template == 5) { // Teknisi
            $("#operator").hide();
            $("#mitra").hide();
            $("#teknisi").show();
            $("#outlet").hide();
            $("#finance").hide();
            $("#kolektor").hide();

        }
        if (template == 6) { // Outlet
            $("#operator").hide();
            $("#mitra").hide();
            $("#teknisi").hide();
            $("#outlet").show();
            $("#finance").hide();
            $("#kolektor").hide();

        }
        if (template == 7) { // Kolektor
            $("#operator").hide();
            $("#mitra").hide();
            $("#teknisi").hide();
            $("#outlet").hide();
            $("#finance").hide();
            $("#kolektor").show();

        }
        if (template == 8) { // Finance
            $("#operator").hide();
            $("#mitra").hide();
            $("#teknisi").hide();
            $("#outlet").hide();
            $("#finance").show();
            $("#kolektor").hide();
        }



    }
</script>