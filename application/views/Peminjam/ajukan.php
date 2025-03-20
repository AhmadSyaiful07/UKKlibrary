<div class="card">
    <form action="<?= base_url('Peminjam/buku/pinjam') ?>" method="post">
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text"  class="form-control"  value="<?= $buku->judul;?>" readonly>
                </div>
            </div>
                <div class="col mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text"  class="form-control"  value="<?= $buku->penulis;?>" readonly>
                </div>
                <div class="col mb-3">
                    <label class="form-label">Penerbit</label>
                    <input type="text"  class="form-control" value="<?= $buku->penerbit;?>" readonly>
                </div>
                <div class="col mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="text"  class="form-control"value="<?= $buku->tahunTerbit;?>" readonly>
                </div>
                <div class="col mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text"  class="form-control" value="<?= $buku->namaKategori; ?>" readonly>
                </div>
                <div class="col mb-3">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tanggalPeminjaman" class="form-control" required>
                </div>
                <input type="hidden" name="bukuID" value="<?= $buku->bukuID;?>">      
            <button type="submit" class="btn btn-primary" >Ajukan Peminjaman</button>
        </div>
    </form>
</div>