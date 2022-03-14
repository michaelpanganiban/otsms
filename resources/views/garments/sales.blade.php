@extends('layouts.base')
@section('title', 'Sales')
@section('content')
    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
        <div class="card">
            <div class="card-header">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">List of Products for <label style="color: orange;">Sale</label></h3>
                        </div>
                        <div class="col-md-6 col-md-offset-5">
                            <button class="btn btn-sm btn-success" style="margin-left: 76%;" data-toggle="modal" data-target="#add-product"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Product</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="header-color">
                        <tr>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Quantity</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\ProductSale::where('type', 'Sale')->where('status', 'Active')->get() as $row)
                            <tr>
                                <td>{{$row->product_code}}</td>
                                <td>{{$row->product_name}}</td>
                                <td>{{$row->description}}</td>
                                <td>{{ number_format($row->amount, 2) }}</td>
                                <td>{{$row->quantity}}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary edit-product" data-details='<?php echo json_encode($row); ?>'><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                    <button class="btn btn-sm btn-danger delete-product" data-id='<?php echo $row->product_id; ?>'><i class="fa fa-times"></i>&nbsp;&nbsp;Deactivate</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- add modal -->
    <div class="modal fade" id="add-product">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Product</h3>
                        </div>
                        <form method="post" id="submit-product">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="product-code">Product Code</label>
                                        <input type="text" required readonly value="S-{{date('mdhis')}}" class="form-control" id="product-code" placeholder="Product Code">
                                        <input type="hidden" class="form-control" id="product-type" value="Sale" placeholder="Product Code">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="product-name">Product Name</label>
                                        <input type="text" required class="form-control" id="product-name" placeholder="Product Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="amount">Amount</label>
                                        <input type="number" required class="form-control" id="amount" placeholder="Amount">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" required class="form-control" id="quantity" placeholder="Quantity">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="image">File input</label>
                                    <input type="file" required class="form-control" id="image">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" class="form-control" rows="5"></textarea>
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
    <div class="modal fade" id="edit-product">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Product</h3>
                        </div>
                        <form method="post" id="edit-product">
                            <div class="card-body">
                                <div class="form-group text-center" id="attach-image"></div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="product-code">Product Code</label>
                                        <input type="text" readonly required class="form-control" id="edit-product-code" placeholder="Product Code">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="product-name">Product Name</label>
                                        <input type="text" required class="form-control" id="edit-product-name" placeholder="Product Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="amount">Amount</label>
                                        <input type="number" required class="form-control" id="edit-amount" placeholder="Amount">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" required class="form-control" id="edit-quantity" placeholder="Quantity">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="image">Change Picture</label>
                                    <input type="file" class="form-control" id="edit-image">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="edit-description" class="form-control" rows="5"></textarea>
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
    <div class="modal fade" id="delete-product">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Deactivate Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to deactivate this product?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light" id="proceed-delete">Proceed</button>
                </div>
            </div>
        </div>
    </div>
@endsection
        