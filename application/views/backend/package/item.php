 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
     <?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>

     <?php if ($this->session->userdata('role_id') == 1 or $role['add_item'] == 1) { ?>
         <a href="#" data-toggle="modal" data-target="#addModal" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
         <a href="<?= site_url('package/itemnonactive') ?>" class="d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-cube fa-sm text-white-50"></i> Non Aktif</a>
         <a href="" data-toggle="modal" data-target="#exampleModal" class="d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-cube fa-sm text-white-50"></i> Perbaharui Paket Pelanggan</a>
     <?php } ?>
 </div>
 <?php $this->view('messages') ?>
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="card-header py-3">
         <h6 class="m-0 font-weight-bold">Data Item Layanan</h6>
     </div>
     <div class="card-body">
         <div class="table-responsive">
             <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                 <thead>
                     <tr>
                         <th style="text-align: center; width:20px">No</th>
                         <!-- <th>ID Paket</th> -->
                         <th>Nama Layanan</th>
                         <th>Harga</th>
                         <th>Kategori</th>
                         <th>Status</th>
                         <?php if ($this->session->userdata('role_id') == 1) { ?>
                             <th>Tampil Di Register</th>
                         <?php } ?>
                         <th>Keterangan</th>

                         <th style="text-align: center">Aksi</th>

                     </tr>
                 </thead>

                 <tbody>
                     <?php $no = 1;
                        foreach ($p_item as $r => $data) { ?>
                         <tr>
                             <td style="text-align: center"><?= $no++ ?>.</td>
                             <!-- <td style="text-align: center"><?= $data->p_item_id ?></td> -->
                             <td><?= $data->nameItem ?></td>
                             <td><?= indo_currency($data->price) ?></td>
                             <td><?= $data->category_name ?></td>
                             <td style="text-align: center"><?= $data->is_active == 1 ? 'Aktif' : 'Non Aktif'; ?></td>
                             <?php if ($this->session->userdata('role_id') == 1) { ?>
                                 <td style="text-align: center"><?= $data->public == 1 ? 'Yes' : 'No'; ?></td>
                             <?php } ?>
                             <td><?= $data->descriptionItem ?></td>
                             <td style="text-align: center">
                                 <?php if ($this->session->userdata('role_id') == 1 or $role['edit_item'] == 1) { ?>
                                     <a href="" data-toggle="modal" data-target="#EditModal<?= $data->p_item_id ?>" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a>
                                 <?php } ?>
                                 <?php if ($this->session->userdata('role_id') == 1 or $role['del_item'] == 1) { ?>
                                     <a href="" data-toggle="modal" data-target="#DeleteModal<?= $data->p_item_id ?>" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>
                                 <?php } ?>
                             </td>

                         </tr>
                     <?php } ?>
                 </tbody>
             </table>
         </div>
     </div>
 </div>


 <!-- Modal Add -->
 <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Tambah Layanan</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <?php echo form_open_multipart('package/addPItem') ?>
                 <div class="form-group">
                     <label for="name">Nama Layanan</label>
                     <input type="text" id="name" name="name" class="form-control" required>
                 </div>
                 <div class="form-group">
                     <label for="price">Harga</label>
                     <input type="number" id="price" min="0" name="price" class="form-control" required>
                 </div>
                 <div class="form-group">
                     <label>Kategori *</label>
                     <select name="category" id="" class="form-control" required>
                         <option value="">- Pilih -</option>
                         <?php foreach ($p_category as $key => $data) { ?>
                             <option value="<?= $data->p_category_id ?>"><?= $data->name ?></option>
                         <?php } ?>
                     </select>
                 </div>
                 <div class="form-group">
                     <label for="is_active">Status</label>
                     <select name="is_active" class="form-control" id="is_active" required>
                         <option value="">-Pilih-</option>
                         <option value="1">Aktif</option>
                         <option value="0">Non-Aktif</option>
                     </select>
                 </div>
                 <div class="form-group">
                     <label for="public">Tampilkan di halaman Register</label>
                     <select name="public" class="form-control" id="public" required>
                         <option value="">-Pilih-</option>
                         <option value="1">Yes</option>
                         <option value="0">No</option>
                     </select>
                 </div>
                 <input type="hidden" id="picture" name="picture" class="form-control">
                 <div class="form-group">
                     <label for="description">Keterangan</label>
                     <textarea id="description" name="description" class="form-control"> </textarea>
                 </div>

                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                     <button type="submit" class="btn btn-primary">Simpan</button>
                 </div>
                 <?php echo form_close() ?>
             </div>
         </div>
     </div>
 </div>

 <!-- Modal Edit -->
 <?php
    foreach ($p_item as $r => $data) { ?>
     <div class="modal fade" id="EditModal<?= $data->p_item_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Edit Layanan</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <?php echo form_open_multipart('package/editPItem') ?>
                     <div class="form-group">
                         <label for="name">Nama Layanan</label>
                         <input type="hidden" id="name" name="p_item_id" value="<?= $data->p_item_id ?>" class="form-control" required>
                         <input type="text" id="name" name="name" value="<?= $data->nameItem ?>" class="form-control" required>
                     </div>
                     <div class="form-group">
                         <label for="price">Harga</label>
                         <input type="number" id="price" name="price" value="<?= $data->price ?>" class="form-control" required>
                     </div>

                     <div class="form-group">
                         <label for="is_active">Status</label>
                         <select name="is_active" class="form-control" id="is_active" required>
                             <option value="<?= $data->is_active; ?>"><?= $data->is_active == 1 ? 'Aktif' : 'Non-Aktif'; ?></option>
                             <option value="1">Aktif</option>
                             <option value="0">Non-Aktif</option>
                         </select>
                     </div>
                     <div class="form-group">
                         <label for="public">Tampilkan di halaman Register</label>
                         <select name="public" class="form-control" id="public" required>
                             <option value="<?= $data->public; ?>"><?= $data->public == 1 ? 'Yes' : 'No'; ?></option>
                             <option value="1">Yes</option>
                             <option value="0">No</option>
                         </select>
                     </div>
                     <div class="form-group">



                         <input type="hidden" id="picture" name="picture" class="form-control">

                     </div>
                     <div class="form-group">
                         <label for="description">Keterangan </label>
                         <textarea id="description" name="description" class="form-control"><?= $data->descriptionItem ?></textarea>
                     </div>
                     <div class="form-group">
                         <label>Kategori *</label>
                         <select name="category" id="" class="form-control" required>
                             <option value="<?= $data->p_category_id ?>"><?= $data->category_name ?></option>
                             <?php foreach ($p_category as $key => $data) { ?>
                                 <option value="<?= $data->p_category_id ?>"><?= $data->name ?></option>
                             <?php } ?>
                         </select>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                         <button type="submit" class="btn btn-primary">Simpan</button>
                     </div>
                     <?php echo form_close() ?>
                 </div>
             </div>
         </div>
     </div>
 <?php } ?>

 <!-- Modal Hapus -->
 <?php
    foreach ($p_item as $r => $data) { ?>
     <div class="modal fade" id="DeleteModal<?= $data->p_item_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Hapus Layanan</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <?php echo form_open_multipart('package/deletePItem') ?>
                     <input type="hidden" name="p_item_id" value="<?= $data->p_item_id ?>" class="form-control">
                     Apakah yakin akan hapus Layanan <?= $data->nameItem ?> ?
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                         <button type="submit" class="btn btn-danger">Hapus</button>
                     </div>
                     <?php echo form_close() ?>
                 </div>
             </div>
         </div>
     </div>
 <?php } ?>
 <!-- Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Update Paket Pelanggan</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <?php echo form_open_multipart('package/updatepackagecustomer') ?>
             <div class="modal-body">
                 <div class="form-group">
                     <label>Nama Paket *</label>
                     <select name="item" id="" class="form-control" required>
                         <option value="">- Pilih -</option>
                         <?php foreach ($p_item as $key => $data) { ?>
                             <option value="<?= $data->p_item_id ?>"><?= $data->nameItem ?> - <?= $data->price ?></option>
                         <?php } ?>
                     </select>
                 </div>
                 <span>Apakah anda yakin akan update semua pelanggan utk paket ini ? </span>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                 <button type="submit" id="click-me" class="btn btn-primary">Ya Lanjutkan</button>
             </div>
             <?php echo form_close() ?>
         </div>
     </div>
 </div>