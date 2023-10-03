<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url('temp') ?>/assets/images/favicon.ico" />
    <title>Document</title>
    <link href="https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet" />
    <link href="<?= base_url('temp') ?>/assets/css/style.css" rel="stylesheet" />
    <link href="<?= base_url('temp') ?>/assets/css/report.css" rel="stylesheet" />
</head>

<body style="margin: 0px !important;">
    <div class="" ng-controller="detailKeluargaController" id="cetak">
        <div class="col-12">
            <table>
                <tr>
                    <td class="text-center" style="font-size:16px"><strong>YOLLEUW FAMILY <br> DAFTAR ANGGOTA <?= $judul == 'pekerjaan' ? 'BERDASARKAN PEKERJAAN SEBAGAI ' . $anggota[0]['pekerjaan'] : ($judul == 'darah' ? "BERDASARKAN GOLONGAN DARAH " . (!is_null($darah)  ? "'" . $darah . "'" : '') : "BERDASARKAN TANGGAL LAHIR DARI $dari s/d $sampai") ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-12 mb-3">
            <table class="border thick" width="99%">
                <thead>
                    <tr class="border thick">
                        <?php if ($judul == 'ultah') : ?>
                            <th class="text-center">No</th>
                            <th class="text-center">Jenis<br>Identitas</th>
                            <th class="text-center">Nomor<br>Identitas</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Jenis<br>Kelamin</th>
                            <th class="text-center">TTL</th>
                            <th class="text-center">Hub. Keluarga</th>
                            <th class="text-center">Kepala<br>Keluarga</th>
                            <th class="text-center">Telp/Hp</th>
                        <?php endif; ?>
                        <?php if ($judul !== 'ultah') : ?>
                            <th class="text-center">No</th>
                            <th class="text-center">Jenis<br>Identitas</th>
                            <th class="text-center">Nomor<br>Identitas</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Jenis Kelamin</th>
                            <th class="text-center">TTL</th>
                            <?php if ($judul !== 'darah' || is_null($darah)) : ?>
                                <th class="text-center">Gol. Darah</th>
                            <?php endif ?>
                            <th class="text-center">Status Perkawinan</th>
                            <th class="text-center">Agama</th>
                            <th class="text-center">Hub. Keluarga</th>
                            <th class="text-center">Pendidikan<br>Terakhir</th>
                            <th class="text-center">Pekerjaan</th>
                            <th class="text-center">Telp/Hp</th>

                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($anggota as $key => $value) : ?>
                        <tr>
                            <?php if ($judul == 'ultah') : ?>
                                <td><?= $key + 1 ?></td>
                                <td><?= $value['jenis_identitas'] ?></td>
                                <td><?= $value['nomor_identitas'] ?></td>
                                <td><?= $value['nama'] ?></td>
                                <td><?= $value['gender'] ?></td>
                                <td><?= $value['tempat_lahir'] . ", " . $value['tanggal_lahir'] ?></td>
                                <td><?= $value['hubungan_keluarga'] ?></td>
                                <td><?= $value['kepala_keluarga'] ?></td>
                                <td><?= $value['hp'] ?></td>
                            <?php endif; ?>
                            <?php if ($judul !== 'ultah') : ?>
                                <td><?= $key + 1 ?></td>
                                <td><?= $value['jenis_identitas'] ?></td>
                                <td><?= $value['nomor_identitas'] ?></td>
                                <td><?= $value['nama'] ?></td>
                                <td><?= $value['gender'] ?></td>
                                <td><?= $value['tempat_lahir'] . ", " . $value['tanggal_lahir'] ?></td>
                                <?php if ($judul !== 'darah'  || is_null($darah)) : ?>
                                    <td><?= $value['golongan_darah'] ?></td>
                                <?php endif ?>
                                <td><?= $value['status_perkawinan'] == "1" ? "Kawin" : "Belum Kawin" ?></td>
                                <td><?= $value['agama'] ?></td>
                                <td><?= $value['hubungan_keluarga'] ?></td>
                                <td><?= $value['pendidikan_terakhir'] ?></td>
                                <td><?= $value['pekerjaan'] ?></td>
                                <td><?= $value['hp'] ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script>
        function fnBrowserDetect() {
            let userAgent = navigator.userAgent;
            let browserName;
            if (userAgent.match(/chrome|chromium|crios/i)) {
                browserName = "chrome";
            } else if (userAgent.match(/firefox|fxios/i)) {
                browserName = "firefox";
            } else if (userAgent.match(/safari/i)) {
                browserName = "safari";
            } else if (userAgent.match(/opr\//i)) {
                browserName = "opera";
            } else if (userAgent.match(/edg/i)) {
                browserName = "edge";
            } else {
                browserName = "No browser detection";
            }
            return browserName;
        }
        printJS({
            printable: 'cetak',
            type: 'html',
            css: ["<?= base_url('temp') ?>/assets/css/style.css",
                "<?= base_url('temp') ?>/assets/css/report.css"
            ]
        })
        if (navigator.userAgent.toLowerCase().indexOf(fnBrowserDetect()) > -1) { // Chrome Browser Detected?
            window.PPClose = false; // Clear Close Flag
            window.PPClose = true; // Set Close Flag to OK.
        }
        window.onfocus = function() {
            window.close();
        }
        window.onfocusin = function() {
            window.close();
        }
        window.onfocusout = function() {
            window.close();
        }
        window.onblur = function() {
            window.close();
        }
    </script>
</body>

</html>