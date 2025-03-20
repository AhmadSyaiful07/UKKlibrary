<?php
if ($this->session->flashdata('pesan') != NULL) {
    echo $this->session->flashdata('pesan');
}
?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <form action="<?= base_url('Peminjam/buku/simpan_ulasan') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control" value="<?= isset($buku->judul) ? $buku->judul : ''; ?>" readonly>
                        </div>
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">Penulis</label>
                        <input type="text" class="form-control" value="<?= isset($buku->penulis) ? $buku->penulis : ''; ?>" readonly>
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">Ulasan</label>
                        <textarea name="ulasan" class="form-control"></textarea>
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">Rating</label>
                        <input type="number" name="rating" class="form-control" required min="1" max="5" placeholder="Beri rating (1-5)">
                    </div>
                    <input type="hidden" name="bukuID" value="<?= isset($buku->bukuID) ? $buku->bukuID : ''; ?>">
                    <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <?php foreach($ulasan as $row) { ?>
        <div class="card mb-3">
            <div class="card-body">
            <h5 class="card-title text-primary"><?= $row['namaLengkap']?> (<?= $row ['rating'] ?>)</h5>
            <p class="mb-4">
            <?= $row['ulasan']?>
            </p>
            <?php if($row['userID'] == $this->session->userdata('userID')) { ?>
            <a href="<?= base_url('Peminjam/buku/ulasanHapus/'.$row['bukuID'])?>" class="btn btn-sm btn-outline-primary">Hapus</a>
            <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
