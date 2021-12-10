@extends('layouts.base')
@section('title', 'Inventory')
@section('content')
    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
        <div class="card">
            <div class="card-header">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">List of Items</h3>
                        </div>
                        <div class="col-md-6 col-md-offset-5">
                            <button class="btn btn-sm btn-success" style="margin-left: 76%;" data-toggle="modal" data-target="#add-item"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Item</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="header-color">
                        <tr>
                            <th>Item Name</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Inventory::all() as $row)
                            <tr class="{{ $row->status == 'Inactive' ? 'dangerBG' : '' }}">
                                <td>{{$row->item_name}}</td>
                                <td>{{$row->description}}</td>
                                <td>{{ $row->quantity }}</td>
                                <td>{{number_format($row->price, 2)}}</td>
                                <td>{{number_format($row->quantity * $row->price)}}</td>
                                <td><label>{{$row->status}}</label></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary edit-item" data-details='<?php echo $row; ?>'><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                    <button class="btn btn-sm btn-danger delete-item" data-id='<?php echo $row->item_id; ?>'><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</button>
                                    <button class="btn btn-sm btn-warning stock-in" data-quantity="<?php echo $row->quantity; ?>" data-id='<?php echo $row->item_id; ?>'><i class="fa fa-arrow-alt-circle-left"></i>&nbsp;&nbsp;Stock In</button>
                                    <button class="btn btn-sm btn-info stock-out" data-quantity="<?php echo $row->quantity; ?>" data-id='<?php echo $row->item_id; ?>'><i class="fa fa-arrow-alt-circle-right"></i>&nbsp;&nbsp;Stock Out</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- add modal -->
    <div class="modal fade" id="add-item">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Item</h3>
                        </div>
                        <form method="post" id="submit-item">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="item-name">Item Name</label>
                                        <input type="text" required class="form-control" id="item-name" placeholder="Item Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="amount">Price</label>
                                        <input type="number" required class="form-control" id="amount" placeholder="Amount">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" required class="form-control" id="quantity" placeholder="Quantity">
                                    </div>
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
    <div class="modal fade" id="edit-item">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit item</h3>
                        </div>
                        <form method="post" id="edit-item-submit">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="item-name">Item Name</label>
                                        <input type="text" required class="form-control" id="edit-item-name" placeholder="item Name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="item-name">Status</label>
                                        <select class="form-control" id="edit-status">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="amount">Price</label>
                                        <input type="number" required class="form-control" id="edit-amount" placeholder="Amount">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" readonly class="form-control" id="edit-quantity" placeholder="Quantity">
                                    </div>
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
    <div class="modal fade" id="delete-item">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this item?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light" id="proceed-delete-item">Proceed</button>
                </div>
            </div>
        </div>
    </div>

    <!-- stock in modal -->
    <div class="modal fade" id="stock-in-model">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Stock In</h3>
                        </div>
                        <form method="post" id="stock-in-submit">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="item-name">Current Quantity</label>
                                        <input type="text" disabled class="form-control" id="current-quantity" disabled placeholder="item Name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="item-name">Quantity to Stock In</label>
                                        <input type="number" class="form-control" id="stock-in-quantity" placeholder="Stock In Quantity">
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

    <!-- stock out modal -->
    <div class="modal fade" id="stock-out-model">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Stock Out</h3>
                        </div>
                        <form method="post" id="stock-out-submit">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="item-name">Current Quantity</label>
                                        <input type="text" disabled class="form-control" id="current-quantity-out" disabled placeholder="item Name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="item-name">Quantity to Stock Out</label>
                                        <input type="number" class="form-control" id="stock-out-quantity" placeholder="Stock out Quantity">
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
@endsection
        