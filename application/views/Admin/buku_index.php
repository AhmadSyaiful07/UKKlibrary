<?php
if ($this->session->flashdata('pesan') != NULL) {
    echo $this->session->flashdata('pesan');
}
?>

<div class="mb-3">

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
        Tambah Buku
    </button>

    <!-- Modal -->
    <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('Admin/buku/simpan') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" name="judul" class="form-control" placeholder="Judul" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Penulis</label>
                                <input type="text" name="penulis" class="form-control" placeholder="Penulis" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Penerbit</label>
                                <input type="text" name="penerbit" class="form-control" placeholder="Penerbit" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="text" name="tahunTerbit" class="form-control" placeholder="Tahun Terbit" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategoriID" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($kategori as $row) { ?>
                                        <option value="<?= $row['kategoriID'] ?>"><?= $row['namaKategori'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Foto</label>
                                <input type="file" name="foto" class="form-control" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- modal update foto -->
<!-- Modal -->

<form action="<?= base_url('Admin/buku/updateFoto') ?>" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="modal-foto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Ganti Sampul </h5>
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
    <div class="table-responsive text-nowrap">
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
                        <td class="td-vertical">
                            <a href="<?= base_url('Admin/buku/edit/' . $row['bukuID']) ?>" class="btn-sm btn-warning">Edit</a>
                            <a onclick="return confirm('Yakin ingin menghapus data ini?');"
                                href="<?= base_url('Admin/buku/hapus/' . $row['bukuID']) ?>" class="btn-sm btn-danger">Delete</a>
                            <a href="<?= base_url('Admin/buku/ulasan/' . $row['bukuID']) ?>" class="btn-sm btn-primary">Ulasan</a>
                        </td>

                    </tr>
                <?php $no++;
                } ?>
            </tbody>
        </table>
    </div>
</div>