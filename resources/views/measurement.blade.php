<?php 
    $shoulder = '';
    $sleeve = '';
    $bust_chest = '';
    $waist = '';
    $skirt_length = '';
    $slack_length = '';
    $slack_front_rise = '';
    $slack_fit_seat = '';
    $slack_fit_thigh = '';
    foreach($data as $row){
        $shoulder = $row->shoulder_length;
        $sleeve = $row->sleeve_length;
        $bust_chest = $row->bust_chest;
        $waist = $row->waist;
        $skirt_length = $row->skirt_length;
        $slack_length = $row->slack_length;
        $slack_front_rise = $row->slack_front_rise;
        $slack_fit_seat = $row->slack_fit_seat;
        $slack_fit_thigh = $row->slack_fit_thigh;
    }
?>
@extends('layouts.base')
@section('title', 'Measurement')
@section('content')
    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
        <div class="card">
            <div class="card-header">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Measurements</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header  header-color">
                            <h3 class="card-title">Add Measurement</h3>
                        </div>
                        <form method="post" id="submit-measurement">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label for="item-name">Shoulder Length</label>
                                        <input type="number" value="{{$shoulder}}"  class="form-control" id="shoulder" placeholder="Shoulder Length">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="item-name">Sleeve Length</label>
                                        <input type="number" value="{{$sleeve}}" class="form-control" id="sleeve" placeholder="Sleeve Length">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="item-name">Bust/Chest</label>
                                        <input type="number" value="{{$bust_chest}}" class="form-control" id="bust-chest" placeholder="Bust/Chest">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="item-name">Waist</label>
                                        <input type="number" value="{{$waist}}" class="form-control" id="waist" placeholder="Waist">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="amount">Skirt Length</label>
                                        <input type="number" value="{{$skirt_length}}"  class="form-control" id="skirt" placeholder="Skirt Length">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label for="amount">Slacks Length</label>
                                        <input type="number" value="{{$slack_length}}"  class="form-control" id="slacks-length" placeholder="Slacks Length">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="amount">Slacks Front Rise</label>
                                        <input type="number" value="{{$slack_front_rise}}"  class="form-control" id="slacks-front-rise" placeholder="Slacks Front Rise">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="amount">Fit (Seat)</label>
                                        <input type="number" class="form-control" value="{{$slack_fit_seat}}"  id="fit-seat" placeholder="Fit (Seat)">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="amount">Fit (Thigh)</label>
                                        <input type="number" class="form-control" value="{{$slack_fit_thigh}}"  id="fit-thigh" placeholder="Fit (Thigh)">
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
                                        <input type="number" required class="form-control" id="item-name" placeholder="Item Name">
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
        