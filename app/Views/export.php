<?php 
header("Content-Type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$file_name");

?>


<html>

    <body>
        <table border="2" width="100%">
            <thead>
                <th>Nama Anak</th>
                <th>Code Anak</th>
                <th>Kelas</th>
                <th>Nama Pembimbing</th>
                <th>Absen Foto</th>
                <th>Absen Video</th>
                <th>Children Quiz</th>
                <th>Tanggal Minggu</th>
            </thead>
            <tbody>
                <?php foreach($data_semua as $data): ?>
                    <tr>
                        <td><?= $data['Nama Anak']; ?></td>
                        <td><?= $data['Code Anak']; ?></td>
                        <td><?= $data['Kelas']; ?></td>
                        <td><?= $data['Nama Pembimbing']; ?></td>
                        <td><?= $data['Absen Foto']; ?></td>
                        <td><?= $data['Absen Video']; ?></td>
                        <td><?= $data['Children Quiz']; ?></td>
                        <td><?= $data['Tanggal Minggu']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>

</html>