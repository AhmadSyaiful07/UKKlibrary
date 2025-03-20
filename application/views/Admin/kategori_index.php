<?php
    if($this->session->flashdata('pesan')!=NULL){
        echo $this->session->flashdata('pesan');
    }
?>
<div class="mb-3">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
        Tambah Kategori
    </button>

    <!-- Modal -->
    <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Kategori</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('Admin/kategori/simpan') ?>" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Kategori Buku</label>
                                <input type="text" name="namaKategori" class="form-control" placeholder="Kategori Buku" required>
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
<div class="card">
    <h5 class="card-header">Data Kategori</h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr class="text-nowrap">
                    <th>#</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($kategori as $row){ ?>
                <tr>
                    <th scope="row"> <?= $no ?> </th>
                    <td><?= $row['namaKategori']; ?></td>
                    <td>
                    <a href="<?= base_url('Admin/kategori/edit/'. $row['kategoriID']) ?>" class="btn-sm btn-warning">Edit</a>
                    <a onclick="return confirm('Yakin ingin menghapus data ini?');"
                    href="<?= base_url('Admin/kategori/hapus/'. $row['kategoriID']) ?>" class="btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
                <?php $no++; } ?>
            </tbody>
        </table>
    </div>
</div>