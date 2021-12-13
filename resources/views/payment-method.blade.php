@extends('layouts.base')
@section('title', 'Payment Methods')
@section('content')
    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
        <div class="card">
            <div class="card-header">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">List of <label style="color: blue;">Payment Methods</label></h3>
                        </div>
                        <div class="col-md-6 col-md-offset-5">
                            <button class="btn btn-sm btn-success" style="margin-left: 76%;" data-toggle="modal" data-target="#add-pm"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Payment Method</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="header-color">
                        <tr>
                            <th>Method Name</th>
                            <th>Bank Name</th>
                            <th>Account Number</th>
                            <th>Account Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\PaymentMethod::get() as $row)
                            <tr>
                                <td>{{$row->method_name}}</td>
                                <td>{{$row->bank_name}}</td>
                                <td>{{$row->account_no}}</td>
                                <td>{{$row->account_name}}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary edit-pm" data-details='<?php echo $row; ?>'><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                    <button class="btn btn-sm btn-danger delete-pm" data-id='<?php echo $row->method_id; ?>'><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- add modal -->
    <div class="modal fade" id="add-pm">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Payment Method</h3>
                        </div>
                        <form method="post" id="submit-pm">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="product-code">Method Name</label>
                                        <input type="text" required class="form-control" id="method-name" placeholder="Method Name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="product-name">Bank Name</label>
                                        <input type="text" required class="form-control" id="bank-name" placeholder="Bank Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="amount">Account Number</label>
                                        <input type="text" required class="form-control" id="account-number" placeholder="Account Number">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="quantity">Account Name</label>
                                        <input type="text" required class="form-control" id="account-name" placeholder="Account Name">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- edit modal -->
    <div class="modal fade" id="edit-method">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Payment Method</h3>
                        </div>
                        <form method="post" id="edit-pm-submit">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="product-code">Method Name</label>
                                        <input type="text" required class="form-control" id="edit-method-name" placeholder="Method Name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="product-name">Bank Name</label>
                                        <input type="text" required class="form-control" id="edit-bank-name" placeholder="Bank Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="amount">Account Number</label>
                                        <input type="text" required class="form-control" id="edit-account-number" placeholder="Account Number">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="quantity">Account Name</label>
                                        <input type="text" required class="form-control" id="edit-account-name" placeholder="Account Name">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary pull-right">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- delete modal--}}
    <div class="modal fade" id="delete-pm">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Payment Method</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this payment method?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light" id="proceed-delete-pm">Proceed</button>
                </div>
            </div>
        </div>
    </div>
@endsection
        