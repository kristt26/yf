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

<body>
    <div class="container" ng-controller="detailKeluargaController" id="cetak">
        <div class="col-12">
            <table>
                <tr>
                    <td class="text-center" style="font-size:16px"><strong>YOLLEUW FAMILY <br>
                            KARTU KELUARGA</strong>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-5">
                    <table width="99%">
                        <tr style="height:10px">
                            <td width="30%" style="padding:0px !important">Nomor</td>
                            <td width="1%" style="padding:0px !important">:</td>
                            <td style="padding:0px !important">&nbsp;<strong><?= $nomor ?></strong></td>
                        </tr>
                        <tr style="height:10px">
                            <td width="30%" style="padding:0px !important">Wilayah</td>
                            <td width="1%" style="padding:0px !important">:</td>
                            <td style="padding:0px !important">&nbsp;<strong><?= $wilayah ?></strong></td>
                        </tr>
                        <tr style="height:10px">
                            <td width="30%">Kepala Keluarga</td>
                            <td width="1%">:</td>
                            <td>&nbsp<?= $anggota[0]['nama'] ?></td>
                        </tr>
                        <tr style="height:10px">
                            <td width="30%">Telp/Hp</td>
                            <td width="1%">:</td>
                            <td>&nbsp<?= $kontak ?></td>
                        </tr>
                        <tr style="height:10px">
                            <td width="30%">Alamat</td>
                            <td width="1%">:</td>
                            <td>&nbsp<?= $alamat ?></td>
                        </tr>
                        <tr style="height:10px">
                            <td class="align-top" width="30%">Status Tempat Tinggal</td>
                            <td class="align-top" width="1%">:</td>
                            <td>&nbsp<?= $status_tinggal ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-3">
                </div>
                <div class="col-4">

                </div>
            </div>
        </div>
        <div class="col-12 mb-3">
            <table class="border thick" width="99%">
                <thead>
                    <tr class="border thick">
                        <th class="text-center">No</th>
                        <th class="text-center">Jenis<br>Identitas</th>
                        <th class="text-center">Nomor Identitas</th>
                        <th class="text-center">Nama Lengkap</th>
                        <th class="text-center">Jenis Kelamin</th>
                        <th class="text-center">Tempat,<br>Tanggal Lahir</th>
                        <th class="text-center">Agama</th>
                        <th class="text-center">Hubungan Keluarga</th>
                    </tr>
                    <tr class="border thick">
                        <th class="text-center">1</th>
                        <th class="text-center">2</th>
                        <th class="text-center">3</th>
                        <th class="text-center">4</th>
                        <th class="text-center">5</th>
                        <th class="text-center">6</th>
                        <th class="text-center">7</th>
                        <th class="text-center">8</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($anggota as $key => $value) : ?>
                        <tr class="tr">
                            <td><?= $key + 1 ?></td>
                            <td><?= $value['jenis_identitas'] ?></td>
                            <td><?= $value['nomor_identitas'] ?></td>
                            <td><?= $value['nama'] ?></td>
                            <td><?= $value['gender'] ?></td>
                            <td><?= $value['tempat_lahir'] . ", " . $value['tanggal_lahir'] ?></td>
                            <td><?= $value['agama'] ?></td>
                            <td><?= $value['hubungan_keluarga'] ?></td>

                        </tr>
                    <?php endforeach;
                    for ($i = 1; $i <= (10 - count($anggota)); $i++) : ?>
                        <tr class="tr">
                            <td><?= $i + count($anggota) ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
        <div class="col-12">
            <table class="border thick" width="99%">
                <thead>
                    <tr class="border thick">
                        <th class="text-center">No</th>
                        <th class="text-center">Pendidikan<br>Terakhir</th>
                        <th class="text-center">Status<br>Perkawinan</th>
                        <th class="text-center">Golongan<br>Darah</th>
                        <th class="text-center">Pekerjaan</th>
                        <th class="text-center">Instansi</th>
                        <th class="text-center">Jabatan</th>
                        <th class="text-center">Telp/Hp</th>
                    </tr>
                    <tr class="border thick">
                        <th class="text-center">9</th>
                        <th class="text-center">10</th>
                        <th class="text-center">11</th>
                        <th class="text-center">12</th>
                        <th class="text-center">13</th>
                        <th class="text-center">14</th>
                        <th class="text-center">15</th>
                        <th class="text-center">16</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($anggota as $key => $value) : ?>
                        <tr class="tr">
                            <td><?= $key + 1 ?></td>
                            <td><?= $value['pendidikan_terakhir'] ?></td>
                            <td><?= $value['status_perkawinan'] == "1" ? "Kawin" : "Belum Kawin" ?></td>
                            <td><?= $value['golongan_darah'] ?></td>
                            <td><?= $value['pekerjaan'] ?></td>
                            <td><?= $value['instansi'] ?></td>
                            <td><?= $value['jabatan'] ?></td>
                            <td><?= $value['hp'] ?></td>
                        <?php endforeach;
                    for ($i = 1; $i <= (10 - count($anggota)); $i++) : ?>
                        <tr class="tr">
                            <td><?= $i + count($anggota) ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script>
        printJS({
            printable: 'cetak',
            type: 'html',
            css: ["<?= base_url('temp') ?>/assets/css/style.css",
                "<?= base_url('temp') ?>/assets/css/report.css"
            ]
        })
        window.onfocus = function() {
            // window.close();
        }
    </script>
</body>

</html>