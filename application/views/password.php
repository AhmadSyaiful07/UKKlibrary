<?php
    if($this->session->flashdata('pesan')!=NULL){
        echo $this->session->flashdata('pesan');
    }
?>
<div class="card">
    <form action="<?= base_url('auth/updatepassword') ?>" method="post">
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="text" name="passwordBaru" class="form-control" placeholder="Masukkan Password Baru" required>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Ulangi Password Baru</label>
                    <input type="text" name="passwordKonf" class="form-control" placeholder="Ulangi Password Baru" required>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>