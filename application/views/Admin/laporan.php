<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr class="text-nowrap">
            <th>#</th>
            <th>Judul</th>
            <th>Peminjam</th>
            <th>Tanggal Peminjaman</th>
            <th>Tanggal Pengembalian</th>
            <th>status</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($peminjaman as $row) { ?>
            <tr>
                <th scope="row"> <?= $no ?> </th>
                <td><?= $row['judul']; ?></td>
                <td><?= $row['namaLengkap']; ?></td>
                <td><?= $row['tanggalPeminjaman']; ?></td>
                <td><?= $row['tanggalPengembalian']; ?></td>
                <td><?php if ($row['statusPeminjaman'] == 'Proses') {
                        echo "menunggu persetujuan";
                    } else {
                        echo $row['statusPeminjaman'];
                    } ?></td>
            </tr>
        <?php $no++;
        } ?>
    </tbody>
</table>
<script>
    window.print();
</script>