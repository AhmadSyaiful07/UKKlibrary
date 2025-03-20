<?php
if ($this->session->flashdata('pesan') != NULL) {
    echo $this->session->flashdata('pesan');
}
?>

<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#smallModal">
    Laporan Peminjaman
</button>

<!-- modal update foto -->

<!-- end modal -->
<div class="card">
    <h5 class="card-header">Daftar Pengajuan Peminjaman Buku</h5>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr class="text-nowrap">
                    <th>#</th>
                    <th>Judul</th>
                    <th>Peminjam</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
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
                        <td><?= $row['namaLengkap']; ?></td>
                        <td><?= $row['tanggalPeminjaman']; ?></td>
                        <td><?= $row['tanggalPengembalian']; ?></td>
                        <td><?php if ($row['statusPeminjaman'] == 'Proses') {
                                echo "menunggu persetujuan";
                            } else {
                                echo $row['statusPeminjaman'];
                            } ?></td>
                        <td>
                            <?php if ($row['statusPeminjaman'] == 'Proses') { ?>
                                <a onclick="return confirm('Yakin ingin menerima peminjaman ini?')"
                                    href="<?= base_url('Admin/peminjaman/terima/' . $row['peminjamanID'] . '/' . $row['bukuID']) ?>" class="btn-sm btn-success">Terima</a>
                                <a onclick="return confirm('Yakin ingin menolak peminjaman ini?')"
                                    href="<?= base_url('Admin/peminjaman/tolak/' . $row['peminjamanID']) ?>" class="btn-sm btn-danger">Tolak</a>
                            <?php } ?>
                            <?php if ($row['statusPeminjaman'] == 'Diterima') { ?>
                                <a onclick="return confirm('apakah peminjam sudah mengembalikan buku ini?')"
                                    href="<?= base_url('Admin/peminjaman/kembali/' . $row['peminjamanID'] . '/' . $row['bukuID']) ?>" class="btn-sm btn-success">Kembalikan</a>
                            <?php } ?>

                        </td>
                    </tr>
                <?php $no++;
                } ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="smallModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <form action="<?= base_url('Admin//peminjaman/laporan') ?>" method="get" target="_blank">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Laporan Peminjaman</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label" >Tanggal Awal</label>
                            <input type="date" class="form-control" name="tanggal1" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Tanggal Berakhir</label>
                            <input type="date" class="form-control" name="tanggal2" required/>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label class="form-label" for="emailSmall">Status</label>
                            <select name="status" class="form-control">
                                <option value="-">Semua</option>
                                <option value="Diterima">Diterima</option>
                                <option value="DiBatalkan">Di Batalkan</option>
                                <option value="Ditolak">Ditolak</option>
                                <option value="DiKembalikan">Di Kembalikan</option>
                                <option value="Proses">menunggu persetujuan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Lihat Laporan</button>
                </div>
            </div>
        </form>
    </div>
</div>  