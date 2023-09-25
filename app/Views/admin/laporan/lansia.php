<?= $this->extend('admin/laporan/index') ?>
<?= $this->section('laporan') ?>
<div class="col-md-12">
    <a href="<?= base_url("laporan/excel?item=") . $url ?>" class="btn btn-primary btn-sm mb-2" id="myButton" target="_blank"><i class="mdi mdi-file-excel-box"></i> Export</a>
    <!-- <a href="<?= base_url("laporan/print?item=") . $url ?>" class="btn btn-info btn-sm mb-2" id="myButton" target="_blank"><i class="mdi mdi-printer"></i> Cetak</a> -->
    <div class="table-responsive">
        <table class="table table-sm table-hover table-striped table-bordered" id="lansia">
            <thead>
                <tr>
                    <th>No</th>
                    <th>WIJK</th>
                    <th>KSP</th>
                    <th>Kode KK</th>
                    <th>Nama Jemaat</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Gol. Darah</th>
                    <th>Status Perkawinan</th>
                    <th>Hubungan Keluarga</th>
                    <th>Pendidikan</th>
                    <th>Pekerjaan</th>
                    <th>Nama Ayah</th>
                    <th>Nama Ibu</th>
                    <th>Suku</th>
                    <th>Status Domisili</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- <div id="container" style="width:100%; height:400px;"></div>
<script src="https://code.highcharts.com/highcharts.js"></script> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.20/sorting/datetime-moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/locale/id.min.js" integrity="sha512-he8U4ic6kf3kustvJfiERUpojM8barHoz0WYpAUDWQVn61efpm3aVAD8RWL8OloaDDzMZ1gZiubF9OSdYBqHfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url() ?>/assets/js/set.js"></script>
<?= $this->endSection() ?>