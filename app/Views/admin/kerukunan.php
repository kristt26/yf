<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <h3 class="page-title"> Kerukunan </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kerukunan</li>
        </ol>
    </nav>
</div>
<div class="row" ng-controller="kerukunanController">
    <div class="col-md-4 grid-margin ">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Kerukunan</h4>
            </div>
            <div class="card-body">
                <form class="forms-sample" ng-submit="save()">
                    <div class="form-group">
                        <label for="kerukunan">Kerukunan</label>
                        <input type="text" class="form-control" id="kerukunan" ng-model="model.kerukunan"
                            placeholder="Nama Kerukunan" required capitalize>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary btn-sm me-2">{{model.id ? 'Edit' :'Save'}}</button>
                    <button type="reset" class="btn btn-dark btn-sm">Clear</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Kerukunan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kerukunan</th>
                                <th style="width:13%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in datas">
                                <td>{{$index+1}}</td>
                                <td>{{item.kerukunan}}</td>
                                <td class="d-flex justify-content-between">
                                    <button class="btn btn-warning btn-sm btn-rounded btn-icon" ng-click="edit(item)"><i
                                            class="mdi mdi-grease-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm btn-rounded btn-icon"
                                        ng-click="delete(item)"><i class="mdi mdi-delete"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>