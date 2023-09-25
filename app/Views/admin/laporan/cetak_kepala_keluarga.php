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
        <div class="col-12 mb-4">
            <table>
                <tr>
                    <td class="text-center" style="font-size:16px"><strong>IKATAN KELUARGA TORAJA (IKT) <br> KOTA JAYAPURA
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-12 mb-3">
            <table class="border thick" width="99%">
                <thead>
                    <tr class="border thick">
                        <th class="text-center">No</th>
                        <th class="text-center">Nomor Keluarga</th>
                        <th class="text-center">Kepala Keluarga</th>
                        <th class="text-center">Wilayah</th>
                        <th class="text-center">Kerukunan</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Kontak</th>
                        <th class="text-center">Status Tinggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($anggota as $key => $value) : ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $value['nomor'] ?></td>
                            <td><?= $value['nama'] ?></td>
                            <td><?= $value['wilayah'] ?></td>
                            <td><?= $value['kerukunan'] ?></td>
                            <td><?= $value['alamat'] ?></td>
                            <td><?= $value['kontak'] ?></td>
                            <td><?= $value['status_tinggal'] ?></td>
                        </tr>
                    <?php endforeach; ?>
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
        if (navigator.userAgent.toLowerCase().indexOf(fnBrowserDetect()) > -1) { // Chrome Browser Detected?
            window.PPClose = true; // Clear Close Flag
            window.onbeforeunload = function() { // Before Window Close Event
                if (window.PPClose === false) { // Close not OK?
                    console.log(window.PPClose);
                }
            }
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
    </script>
</body>
</html>