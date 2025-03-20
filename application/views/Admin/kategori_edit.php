<div class="card">
    <form action="<?= base_url('Admin/kategori/update') ?>" method="post">
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="namaKategori" class="form-control" value="<?= $kategori->namaKategori;?>" >
                    <input type="hidden" name="kategoriID"  value="<?= $kategori->kategoriID;?>">
                </div>
            </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>