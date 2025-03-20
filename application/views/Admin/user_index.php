<?php
    if($this->session->flashdata('pesan')!=NULL){
        echo $this->session->flashdata('pesan');
    }
?>
<div class="mb-3">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
        Tambah User
    </button>

    <!-- Modal -->
    <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah User</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('Admin/user/simpan') ?>" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-control">
                                    <option value="Admin">Admin</option>
                                    <option value="Petugas">Petugas</option>
                                    <option value="Peminjam">Peminjam</option>
                                </select>
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
    <h5 class="card-header">Data User</h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr class="text-nowrap">
                    <th>#</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($user as $row){ ?>
                <tr>
                    <th scope="row"> <?= $no ?> </th>
                    <td><?= $row['username']; ?></td>
                    <td><?= $row['namaLengkap']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['alamat']; ?></td>
                    <td><?= $row['role']; ?></td>
                    <td>
                    <a href="<?= base_url('Admin/user/edit/'. $row['userID']) ?>" class="btn-sm btn-warning">Edit</a>
                    <a onclick="return confirm('Yakin ingin menghapus data ini?');"
                    href="<?= base_url('Admin/user/hapus/'. $row['userID']) ?>" class="btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
                <?php $no++; } ?>
            </tbody>
        </table>
    </div>
</div>