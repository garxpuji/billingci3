<?php $this->view('messages') ?>

<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Role Management</h6>
        </div>
        <?php $roleoperator = $this->db->get_where('role_management', ['role_id' => 3])->row_array() ?>

        <div class="row">
            <div class="col-lg-6">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr colspan="5">Operator</tr>
                        </thead>
                    </table>


                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Menu</th>
                                <th scope="col">Tampil</th>
                                <th scope="col">Tambah</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $show_saldo = $roleoperator['show_saldo'];
                            $show_customer = $roleoperator['show_customer'];
                            $add_customer = $roleoperator['add_customer'];
                            $edit_customer = $roleoperator['edit_customer'];
                            $del_customer = $roleoperator['del_customer'];
                            $show_item = $roleoperator['show_item'];
                            $add_item = $roleoperator['add_item'];
                            $edit_item = $roleoperator['edit_item'];
                            $del_item = $roleoperator['del_item'];
                            $show_bill = $roleoperator['show_bill'];
                            $add_bill = $roleoperator['add_bill'];
                            $del_bill = $roleoperator['del_bill'];
                            $show_income = $roleoperator['show_income'];
                            $edit_income = $roleoperator['edit_income'];
                            $del_income = $roleoperator['del_income'];
                            $add_income = $roleoperator['add_income'];
                            $show_router = $roleoperator['show_router'];
                            $add_router = $roleoperator['add_router'];
                            $edit_router = $roleoperator['edit_router'];
                            $del_router = $roleoperator['del_router'];
                            $show_coverage = $roleoperator['show_coverage'];
                            $add_coverage = $roleoperator['add_coverage'];
                            $edit_coverage = $roleoperator['edit_coverage'];
                            $del_coverage = $roleoperator['del_coverage'];
                            $show_slide = $roleoperator['show_slide'];
                            $add_slide = $roleoperator['add_slide'];
                            $edit_slide = $roleoperator['edit_slide'];
                            $del_slide = $roleoperator['del_slide'];
                            $show_product = $roleoperator['show_product'];
                            $add_product = $roleoperator['add_product'];
                            $edit_product = $roleoperator['edit_product'];
                            $del_product = $roleoperator['del_product'];
                            $show_user = $roleoperator['show_user'];
                            $add_user = $roleoperator['add_user'];
                            $edit_user = $roleoperator['edit_user'];
                            $del_user = $roleoperator['del_user'];
                            $show_help = $roleoperator['show_help'];
                            $add_help = $roleoperator['add_help'];
                            $edit_help = $roleoperator['edit_help'];
                            $del_help = $roleoperator['del_help'];
                            ?>
                            <tr>

                                <th scope="row">Saldo Kas</th>
                                <td>
                                    <?php if ($roleoperator['show_saldo'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=0&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                    <?php if ($roleoperator['show_saldo'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=1&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">Pelanggan</th>
                                <td>
                                    <?php if ($roleoperator['show_customer'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=0&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                    <?php if ($roleoperator['show_customer'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=1&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['add_customer'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=0&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                    <?php if ($roleoperator['add_customer'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=1&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">

                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['edit_customer'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=0&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                    <?php if ($roleoperator['edit_customer'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=1&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['del_customer'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=0&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>


                                    <?php if ($roleoperator['del_customer'] == 0) { ?>

                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=1&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">

                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Layanan Item</th>
                                <td>
                                    <?php if ($roleoperator['show_item'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=0&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                    <?php if ($roleoperator['show_item'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=1&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['add_item'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=0&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['add_item'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=1&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['edit_item'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=0&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                    <?php if ($roleoperator['edit_item'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=1&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['del_item'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=0&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['del_item'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=1&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Tagihan</th>
                                <td>
                                    <?php if ($roleoperator['show_bill'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=0&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['show_bill'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=1&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['add_bill'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=0&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['add_bill'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=1&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td></td>
                                <td> <?php if ($roleoperator['del_bill'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=0&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['del_bill'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=1&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Keuangan</th>
                                <td>
                                    <?php if ($roleoperator['show_income'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=0&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['show_income'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=1&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['add_income'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=0&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['add_income'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=1&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['edit_income'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=0&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['edit_income'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=1&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['del_income'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=0&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['del_income'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=1&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>

                            </tr>
                            <tr>
                                <th scope="row">Coverage</th>
                                <td>
                                    <?php if ($roleoperator['show_coverage'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=0&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['show_coverage'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=1&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['add_coverage'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=0&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['add_coverage'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=1&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['edit_coverage'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=0&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['edit_coverage'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=1&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['del_coverage'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=0&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['del_coverage'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=1&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Slide</th>
                                <td>
                                    <?php if ($roleoperator['show_slide'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=0&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['show_slide'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=1&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['add_slide'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=0&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['add_slide'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=1&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['edit_slide'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=0&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['edit_slide'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=1&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['del_slide'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=0&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['del_slide'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=1&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>

                            </tr>
                            <tr>
                                <th scope="row">Produk</th>
                                <td>
                                    <?php if ($roleoperator['show_product'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=0&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['show_product'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=1&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['add_product'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=0&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['add_product'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=1&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['edit_product'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=0&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['edit_product'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=1&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['del_product'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=0&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['del_product'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=1&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Router</th>
                                <td>
                                    <?php if ($roleoperator['show_router'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=0&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['show_router'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=1&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['add_router'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=0&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['add_router'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=1&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['edit_router'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=0&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['edit_router'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=1&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['del_router'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=0&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['del_router'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=1&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                            <tr>
                                <th scope="row">Pengguna</th>
                                <td>
                                    <?php if ($roleoperator['show_user'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=0&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['show_user'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=1&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['add_user'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=0&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['add_user'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=1&edit_user=' . $edit_user . '&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['edit_user'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=0&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['edit_user'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=1&del_user=' . $del_user . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['del_user'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=0') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['del_user'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdate?show_saldo=' . $show_saldo . '&show_customer=' . $show_customer . '&add_customer=' . $add_customer . '&edit_customer=' . $edit_customer . '&del_customer=' . $del_customer . '&show_item=' . $show_item . '&add_item=' . $add_item . '&edit_item=' . $edit_item . '&del_item=' . $del_item . '&show_bill=' . $show_bill . '&add_bill=' . $add_bill . '&del_bill=' . $del_bill . '&show_income=' . $show_income . '&add_income=' . $add_income . '&edit_income=' . $edit_income . '&del_income=' . $del_income . '&show_coverage=' . $show_coverage . '&add_coverage=' . $add_coverage . '&edit_coverage=' . $edit_coverage . '&del_coverage=' . $del_coverage . '&show_slide=' . $show_slide . '&add_slide=' . $add_slide . '&edit_slide=' . $edit_slide . '&del_slide=' . $del_slide . '&show_product=' . $show_product . '&add_product=' . $add_product . '&edit_product=' . $edit_product . '&del_product=' . $del_product . '&show_router=' . $show_router . '&add_router=' . $add_router . '&edit_router=' . $edit_router . '&del_router=' . $del_router . '&show_user=' . $show_user . '&add_user=' . $add_user . '&edit_user=' . $edit_user . '&del_user=1') ?>'">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Bantaun</th>
                                <td>
                                    <?php if ($roleoperator['show_help'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdateoperatorhelp?show_help=0&add_help=' . $add_help . '&edit_help=' . $edit_help . '&del_help=' . $del_help . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['show_help'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdateoperatorhelp?show_help=1&add_help=' . $add_help . '&edit_help=' . $edit_help . '&del_help=' . $del_help . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['add_help'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdateoperatorhelp?show_help=' . $show_help . '&add_help=0&edit_help=' . $edit_help . '&del_help=' . $del_help . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['add_help'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdateoperatorhelp?show_help=' . $show_help . '&add_help=1&edit_help=' . $edit_help . '&del_help=' . $del_help . '') ?>'">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['edit_help'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdateoperatorhelp?show_help=' . $show_help . '&add_help=' . $add_help . '&edit_help=0&del_help=' . $del_help . '') ?>'">
                                    <?php } ?>

                                    <?php if ($roleoperator['edit_help'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdateoperatorhelp?show_help=' . $show_help . '&add_help=' . $add_help . '&edit_help=1&del_help=' . $del_help . '') ?>'">

                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($roleoperator['del_help'] == 1) { ?>
                                        <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('user/roleupdateoperatorhelp?show_help=' . $show_help . '&add_help=' . $add_help . '&edit_help=' . $edit_help . '&del_help=0') ?>'">

                                    <?php } ?>

                                    <?php if ($roleoperator['del_help'] == 0) { ?>
                                        <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('user/roleupdateoperatorhelp?show_help=' . $show_help . '&add_help=' . $add_help . '&edit_help=' . $edit_help . '&del_help=1') ?>'">
                                    <?php } ?>
                                </td>
                            </tr>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6">
                <?php $rolepelanggan = $this->db->get_where('role_management', ['role_id' => 2])->row_array() ?>
                <div class="card-body">
                    <form action="<?= site_url('user/updaterolepelanggan') ?>" method="post">
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