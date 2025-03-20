<?php
if ($this->session->flashdata('pesan') != NULL) {
    echo $this->session->flashdata('pesan');
}
?>

<!-- modal update foto -->

<!-- end modal -->
<div class="card">
    <h5 class="card-header">Data Buku</h5>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr class="text-nowrap">
                    <th>#</th>
                    <th>Judul</th>
                    <th>Tanggal Peminjaman</th>
                    <th>status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($peminjaman as $row) { ?>
                    <tr>
                        <th scope="row"> <?= $no ?> </th>
                        <td><?= $row['judul']; ?></td>
                        <td><?= $row['tanggalPeminjaman']; ?></td>
                        <td><?php if ($row['statusPeminjaman'] == 'Proses') {
                                echo "menunggu persetujuan";
                            } else {
                                echo $row['statusPeminjaman'];
                            } ?></td>
                        <td>
                            <?php if ($row['statusPeminjaman'] == 'Proses') { ?>
                                <a onclick="return confirm('Yakin ingin membatalkan peminjaman ini?')"
                                    href="<?= base_url('Peminjam/peminjaman/batal/' . $row['peminjamanID']) ?>" class="btn-sm btn-danger">Batalkan</a>
                            <?php } ?>



                        </td>
                    </tr>
                <?php $no++;
                } ?>
            </tbody>
        </table>
    </div>
</div>