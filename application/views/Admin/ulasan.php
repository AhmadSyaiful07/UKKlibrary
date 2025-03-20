<?php
if ($this->session->flashdata('pesan') != NULL) {
    echo $this->session->flashdata('pesan');
}
?>

<div class="row">
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
        <?php } 
        if($ulasan==NULL){ echo"Belum Ada Ulasan";}?>
    </div>
</div>
