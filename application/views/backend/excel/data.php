<?php $this->view('messages') ?>


<h3>
    Import Data Pelanggan
</h3>
<hr>

<a href="<?= base_url("assets/backend/formatimport.xlsx"); ?>" class="btn btn-outline-primary">Download Format</a>
<br>
<br>
<div class="row">
    <div class="col-lg-6">
        <!-- Buat sebuah tag form dan arahkan action nya ke controller ini lagi -->
        <form method="post" action="<?php echo base_url('customer/import'); ?>" enctype="multipart/form-data">
            <!--
		-- Buat sebuah input type file
		-- class pull-left berfungsi agar file input berada di sebelah kiri
		-->
            <input type="file" name="file">

            <!--
		-- BUat sebuah tombol submit untuk melakukan preview terlebih dahulu data yang akan di import
		-->
            <input type="submit" name="preview" class="btn btn-primary" value="Preview">
        </form>
    </div>
    <div class="col-lg-6">
        <h3>Panduan Import Data Pelanggan</h3>
        <li>Silahkan download Format</li>
        <li>Isi data pelanggan dengan benar</li>
        <li>Format Nomor Layanan : Hanya Nomor</li>
        <li>Format Status : <span style="font-weight:bold; color:green; font-size:large">Aktif</span>, <span style="font-weight:bold; color:red; font-size:large">Non-Aktif</span>, <span style="font-weight:bold; color:gray; font-size:large">Menunggu</span></li>
        <li>Format PPN : Aktif = <span style="font-weight:bold; color:red; font-size:large">1</span>, Non-Aktif = <span style="font-weight:bold; color:red; font-size:large">0</span></li>
        <li>Format Auto Isolir : Aktif = <span style="font-weight:bold; color:red; font-size:large">1</span>, Non-Aktif = <span style="font-weight:bold; color:red; font-size:large">0</span></li>
        <li>Format Jatuh Tempo : Tanggal antara angka <span style="font-weight:bold; color:red; font-size:large">1</span> sampai <span style="font-weight:bold; color:red; font-size:large">28</span></li>
        <li>Format ID PAKET : Angka dari daftar ID PAKET dibawah</li>

        <?php $paket = $this->db->get('package_item')->result() ?>
        <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="text-align: center;">ID PAKET</th>
                    <th style="text-align: center;">Nama Paket</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paket as $paket) { ?>
                    <tr>
                        <td style="text-align: center;color:red; font-weight:bold"><?= $paket->p_item_id; ?></td>
                        <td style="text-align: center;"><?= $paket->name; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <li>Format ID ROUTER : Angka dari daftar ID ROUTER dibawah</li>
        <?php $router = $this->db->get('router')->result() ?>
        <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="text-align: center;">ID Router</th>
                    <th style="text-align: center;">Nama Router</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($router as $router) { ?>
                    <tr>
                        <td style="text-align: center;color:red; font-weight:bold"><?= $router->id; ?></td>
                        <td style="text-align: center;"><?= $router->alias; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <li>Format ID Coverage : Angka dari daftar ID Coverage dibawah</li>
        <?php $coverage = $this->db->get('coverage')->result() ?>
        <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="text-align: center;">ID Coverage</th>
                    <th style="text-align: center;">Nama Coverage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($coverage as $coverage) { ?>
                    <tr>
                        <td style="text-align: center;color:red; font-weight:bold"><?= $coverage->coverage_id; ?></td>
                        <td style="text-align: center;"><?= $coverage->c_name; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <li>Pastikan semua data sudah terisi dan tidak ada No Layanan & Email yang sama / Duplikat</li>
        <li>Upload File, kemudian klik preview</li>
        <li>Setelah data dianggap benar, silahkan klik Tombol Import dibawah tabel Preview Data</li>
        <span style="font-weight:bold; color:red; font-size:large">Catatan</span>
        <li>Sebelum menggunkan fitur ini, di <span style="font-weight:bold; color:red; font-size:large">WAJIBKAN</span> Backup Database terlebih dahulu</li>
        <li>Fitur ini <span style="font-weight:bold; color:red; font-size:large">TIDAK</span> disarankan karena ditakutkan terjadi duplikat data / error </li>
        <li>Kesalahan input / error bukan tanggung jawab kami</li>
        <li>Jika terjadi error silahkan hubungi kami</li>
    </div>
</div>


<?php
if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
    if (isset($upload_error)) { // Jika proses upload gagal
        echo "<div style='color: red;'>" . $upload_error . "</div>"; // Muncul pesan error upload
        die; // stop skrip
    }

    // Buat sebuah tag form untuk proses import data ke database
    echo "<form method='post' action='" . base_url('customer/importtodatabase') . "'>";

    // Buat sebuah div untuk alert validasi kosong
    echo "<div style='color: red;' id='kosong'>
		Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum diisi.
		</div>";
    echo "<br>";
    echo "<table border='1' cellpadding='8' id='id_table'>
    
		<tr>
			<th colspan='11' style='text-align:center'>Preview Data</th>
		</tr>
		<tr>
        
			<th>No</th>
			<th>No Layanan</th>
			<th>Nama Pelanggan</th>
			<th>Email</th>
			<th>Status</th>
			<th>No Telp.</th>
			<th>Alamat</th>
			<th>No KTP/SIM</th>
			<th>PPN</th>
			<th>Jatuh Tempo</th>
			<th>ID Paket</th>
			<th>ID Router</th>
			<th>Mode User</th>
			<th>User Pelanggan @router</th>
			<th>User Profile</th>
			<th>Auto Isolir</th>
		</tr>";

    $numrow = 1;
    $kosong = 0;
    echo "Total : " . (count($sheet) - 1);
    // Lakukan perulangan dari data yang ada di excel
    // $sheet adalah variabel yang dikirim dari controller

    foreach ($sheet as $row) {
        // Ambil data pada excel sesuai Kolom



        $ceknoservices = $this->db->get_where('customer', ['no_services' => $row['A']])->num_rows();
        $cekemail = $this->db->get_where('customer', ['email' => $row['C']])->num_rows();

        if ($ceknoservices > 0) {
            $this->session->set_flashdata('error', 'Gagal import, ada salah satu no layanan yg telah terdaftar');
            redirect('customer');
        }
        if ($cekemail > 0) {
            $this->session->set_flashdata('error', 'Gagal import, ada salah satu email yg telah terdaftar');
            redirect('customer');
        }
        $no_services = $row['A']; // Ambil data NIS
        $name = $row['B']; // Ambil data nama
        $email = $row['C']; // Ambil data jenis kelamin
        $c_status = $row['D']; // Ambil data alamat
        $no_wa = $row['E']; // Ambil data alamat
        $address = $row['F']; // Ambil data alamat
        $no_ktp = $row['G']; // Ambil data alamat
        $ppn = $row['H']; // Ambil data alamat
        $due_date = $row['I']; // Ambil data alamat
        $idpaket = $row['J']; // Ambil data alamat
        $idrouter = $row['K']; // Ambil data alamat
        $modeuser = $row['L']; // Ambil data alamat
        $usermikrotik = $row['M']; // Ambil data alamat
        $userprofile = $row['N']; // Ambil data alamat
        $auto_isolir = $row['O']; // Ambil data alamat
        // $noservices = $row['A'];
        // $count_values = array_count_values($noservices);
        $namee = $row['B'];

        // echo $email;
        // Cek jika semua data tidak diisi
        if ($no_services == "" && $name == "" && $email == "" && $c_status == "")
            continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

        // Cek $numrow apakah lebih dari 1
        // Artinya karena baris pertama adalah nama-nama kolom
        // Jadi dilewat saja, tidak usah diimport
        if ($numrow > 1) {
            // Validasi apakah semua data telah diisi
            $no_services_td = (!empty($no_services)) ? "" : " style='background: #F3F708;'"; // Jika NIS kosong, beri warna merah
            $name_td = (!empty($name)) ? "" : " style='background: #F3F708;'"; // Jika Nama kosong, beri warna merah
            $email_td = (!empty($email)) ? "" : " style='background: #F3F708;'"; // Jika Jenis Kelamin kosong, beri warna merah
            $c_status_td = (!empty($c_status)) ? "" : " style='background: #F3F708;'"; // Jika Alamat kosong, beri warna merah
            $no_wa_td = (!empty($no_wa)) ? "" : " style='background: #F3F708;'"; // Jika Alamat kosong, beri warna merah
            $address_td = (!empty($address)) ? "" : " style='background: #F3F708;'"; // Jika Alamat kosong, beri warna merah
            $no_ktp_td = (!empty($no_ktp)) ? "" : " style='background: #F3F708;'"; // Jika Alamat kosong, beri warna merah
            $ppn_td = (!empty($ppn)) ? "" : " style='background: #F3F708;'"; // Jika Alamat kosong, beri warna merah
            $due_date_td = (!empty($due_date)) ? "" : " style='background: #F3F708;'"; // Jika Alamat kosong, beri warna merah
            $getpaket = $this->db->get_where('package_item', ['p_item_id' => $idpaket])->num_rows();
            $getrouter = $this->db->get_where('router', ['id' => $idrouter])->num_rows();
            // var_dump($getpaket);
            if ($getpaket == 0) {
                $this->session->set_flashdata('error', 'Gagal import, ada ID Paket yang belum terdaftar !');
                redirect('customer');
                // echo "hsgdjfs";
            }
            if ($getrouter == 0) {
                $this->session->set_flashdata('error', 'Gagal import, ada ID Router yang belum terdaftar !');
                redirect('customer');
                // echo "hsgdjfs";
            }
            $idpaket_td = (!empty($idpaket)) ? "" : " style='background: #F3F708;'"; // Jika Alamat kosong, beri warna merah
            $idrouter_td = (!empty($idrouter)) ? "" : " style='background: #F3F708;'"; // Jika Alamat kosong, beri warna merah
            $usermode_td = (!empty($usermode)) ? "" : " style='background: #F3F708;'"; // Jika Alamat kosong, beri warna merah
            $usermikrotik_td = (!empty($usermikrotik)) ? "" : " style='background: #F3F708;'"; // Jika Alamat kosong, beri warna merah
            $userprofile_td = (!empty($userprofile)) ? "" : " style='background: #F3F708;'"; // Jika Alamat kosong, beri warna merah
            $auto_isolir_td = (!empty($auto_isolir)) ? "" : " style='background: #F3F708;'"; // Jika Alamat kosong, beri warna merah
            // Jika salah satu data ada yang kosong
            if ($no_services == "" or $name == "" or $email == "" or $no_wa == "" or $c_status == "") {
                $kosong++; // Tambah 1 variabel $kosong
            }

            echo "<tr>";
            echo "<td>" .  ($numrow - 1) . "</td>";
            echo "<td" . $no_services_td . ">" . $no_services . "</td>";
            echo "<td" . $name_td . ">" . $name . "</td>";
            if ($email) {
                # code...
            }
            echo "<td" . $email_td . ">" . $email . "</td>";
            echo "<td" . $c_status_td . ">" . $c_status . "</td>";
            echo "<td" . $no_wa_td . ">" . $no_wa . "</td>";
            echo "<td" . $address_td . ">" . $address . "</td>";
            echo "<td" . $no_ktp_td . ">" . $no_ktp . "</td>";
            echo "<td" . $ppn_td . ">" . $ppn . "</td>";
            echo "<td" . $due_date_td . ">" . $due_date . "</td>";
            $getpaket = $this->db->get_where('package_item', ['p_item_id' => $idpaket])->row_array();
            $getrouter = $this->db->get_where('router', ['id' => $idrouter])->row_array();
            if ($getpaket > 0) {
                # code...
                echo "<td" . $idpaket_td . ">" . $idpaket . "-" . $getpaket['name'] . "</td>";
            } else {
                echo "<td style='background: #CBF708;'>" . $idpaket . "-" . "PAKET TIDAK TERDAFTAR" . "</td>";
            }
            if ($getrouter > 0) {
                # code...
                echo "<td" . $idrouter_td . ">" . $idrouter . "-" . $getrouter['alias'] . "</td>";
            } else {
                echo "<td style='background: #CBF708;'>" . $idrouter . "-" . "PAKET TIDAK TERDAFTAR" . "</td>";
            }
            echo "<td" . $modeuser_td . ">" . $modeuser . "</td>";
            echo "<td" . $usermikrotik_td . ">" . $usermikrotik . "</td>";
            echo "<td" . $userprofile_td . ">" . $userprofile . "</td>";
            echo "<td" . $auto_isolir_td . ">" . $auto_isolir . "</td>";

            echo "</tr>";
        }
        $numrow++; // Tambah 1 setiap kali looping
    }

    echo "</table>";

    // Cek apakah variabel kosong lebih dari 0
    // Jika lebih dari 0, berarti ada data yang masih kosong
    if ($kosong > 0) {
?>
        <script>
            $(document).ready(function() {
                // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
                $("#jumlah_kosong").html('<?php echo $kosong; ?>');

                $("#kosong").show(); // Munculkan alert validasi kosong
            });
        </script>
<?php
    } else { // Jika semua data sudah diisi
        if ($kosong == 0) {
            echo "<hr>";
            // Buat sebuah tombol untuk mengimport data ke database
            echo "<button class='btn btn-primary' type='submit' name='import'>Import</button>";
            echo "<a href='" . base_url('customer') . "' class='btn btn-danger'> Cancel</a>";
            # code...
        }
        # code...
    }
    echo "</form>";
}
?>
</body>


</html>