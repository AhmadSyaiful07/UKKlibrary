<div class="card">
    <form action="<?= base_url('Admin/user/update') ?>" method="post">
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= $user->username;?>" readonly>
                    <input type="hidden" name="userID"  value="<?= $user->userID;?>">
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= $user->namaLengkap; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $user->email; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" ><?= $user->alamat; ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control">
                        <option value="Admin" <?php if($user->role=="Admin"){echo "selected"; } ?>>Admin</option>
                        <option value="Petugas"<?php if($user->role=="Petugas"){echo "selected"; } ?>>Petugas</option>
                        <option value="Peminjam"<?php if($user->role=="Peminjam"){echo "selected"; } ?>>Peminjam</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>