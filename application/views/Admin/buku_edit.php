<div class="card">
    <form action="<?= base_url('Admin/buku/update') ?>" method="post">
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control"  value="<?= $buku->judul;?>" >
                </div>
            </div>
                <div class="col mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control"  value="<?= $buku->penulis;?>" >
                </div>
                <div class="col mb-3">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="penerbit" class="form-control" value="<?= $buku->penerbit;?>" >
                </div>
                <div class="col mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="text" name="tahunTerbit" class="form-control"value="<?= $buku->tahunTerbit;?>" >
                </div>
                <div class="col mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategoriID" class="form-control">
                        <?php foreach ($kategori as $key => $value) { ?>
                            <option value="<?= $value['kategoriID'] ?>" <?= $value['kategoriID'] == $buku->kategoriID ? 'selected' : '' ?>>
                                <?= $value['namaKategori'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-control">
        <option value="Tersedia" <?= $buku->status == 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
        <option value="Tidak Tersedia" <?= $buku->status == 'Tidak Tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
    </select>
</div>


                <input type="hidden" name="bukuID" value="<?= $buku->bukuID;?>">      
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>