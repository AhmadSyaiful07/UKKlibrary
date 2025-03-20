<?php
if ($this->session->flashdata('pesan') != NULL) {
    echo $this->session->flashdata('pesan');
}
?>

<!-- modal update foto -->
<!-- Modal -->
<form action="<?= base_url('Admin/buku/updateFoto') ?>" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="modal-foto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Id Foto</label>
                            <input type="text" id="idFoto" name="bukuID" readonly class="form-control" placeholder="Enter Name" />
                        </div>
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Foto</label>
                            <input type="file" id="nameBasic" name="foto" class="form-control" placeholder="Enter Name" />
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- end modal -->
<div class="card">
    <h5 class="card-header">Data Buku</h5>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr class="text-nowrap">
                    <th>#</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Kategori</th>
                    <th>Foto</th>
                    <th>status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($buku as $row) { ?>
                    <tr>
                        <th scope="row"> <?= $no ?> </th>
                        <td><?= $row['judul']; ?></td>
                        <td><?= $row['penulis']; ?></td>
                        <td><?= $row['penerbit']; ?></td>
                        <td><?= $row['tahunTerbit']; ?></td>
                        <td><?= $row['namaKategori']; ?></td>
                        <td><img data-id="<?= $row['bukuID']; ?>" src="<?= base_url('uploads/' . $row['foto']); ?>" alt="Foto Buku" class="btnfoto" width="100"></td>
                        <td><?= $row['status']; ?></td>
                        <td>
                            <a onclick="return confirm('Yaakin ingin menambahkan buku ke koleksi?')"
                                    href="<?= base_url('Peminjam/buku/addKoleksi/' . $row['bukuID']) ?>" class="btn-sm btn-warning">Add Favorite</a>
                            <?php if ($row['status'] == 'Tersedia'): ?>
                                <a href="<?= base_url('Peminjam/buku/ajukan/' . $row['bukuID']) ?>" class="btn-sm btn-success">Pinjam</a>
                            <?php else: ?>
                                <button class="btn-sm btn-secondary" disabled>Pinjam</button>
                            <?php endif; ?>
                                <a onclick="return confirm('Ingin Memberi Ulasan?')"
                                    href="<?= base_url('Peminjam/buku/ulasan/' . $row['bukuID']) ?>"
                                    class="btn-sm btn-primary">Ulasan</a>

                        </td>
                    </tr>
                <?php $no++;
                } ?>
            </tbody>
        </table>
    </div>
</div>