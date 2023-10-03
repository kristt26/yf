<?= $this->extend('admin/laporan/index') ?>
<?= $this->section('laporan') ?>
<div class="row" ng-controller="anggotaUltahController" ng-init="init()">
    <div class="col-md-12">
        <div class="d-flex justify-content-start mb-3">
            <button class="btn btn-primary btn-sm" id="myButton" ng-click="cetak(tanggal)" target="_blank"><i class="mdi mdi-printer"></i> Print</button>
            <div class="col-md-4" style="margin-left: 12px;">
                <div class="input-group input-group-sm">
                    <input type="text" class="col-md-3 form-control form-control-sm" id="tanggal" ng-model="tanggal" placeholder="Tanggal" aria-describedby="textHelp" ng-change="setDate(tanggal)">
                    <span class="input-group-text" id="basic-addon1"><i class="mdi mdi-calendar-check"></i></span>
                </div>
            </div>
        </div>
        <div class="table-responsive" ng-show="datas.length>0">
            <table datatable="ng" dt-options="dtOptions" class="table table-sm table-hover table-striped table-bordered" width="99%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat<br>Tanggal Lahir</th>
                        <th>Umur</th>
                        <th>Alamat</th>
                        <th>Hubungan Keluarga</th>
                        <th>Nama<br>Kepala Keluarga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in datas">
                        <td>{{$index+1}}</td>
                        <td>{{item.nama}}</td>
                        <td>{{item.gender}}</td>
                        <td>{{item.tempat_lahir}}, {{item.tanggal_lahir | date: 'dd MMMM yyyy'}}</td>
                        <td>{{item.umur}}</td>
                        <td>{{item.alamat}}</td>
                        <td>{{item.hubungan_keluarga}}</td>
                        <td>{{item.kepala_keluarga}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/set.js') ?>"></script>
<?= $this->endSection() ?>