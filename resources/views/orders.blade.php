<?php //print_r($data); ?>
@extends('layouts.base')
@section('title', 'Orders')
@section('content')
    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
        <div class="card">
            <div class="card-header">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">List of <label style="color: blue;" >Orders</label></h3>
                        </div>
                        <div class="col-md-6 col-md-offset-5">
                            <button class="btn btn-sm btn-success" style="margin-left: 76%;" data-toggle="modal" data-target="#add-product" {{Auth::user()->user_type === 0 ? 'hidden' : '' }}><i class="fa fa-plus"></i>&nbsp;&nbsp;Order for a Customer</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="header-color">
                        <tr>
                            <th>Reference ID</th>
                            <th>Product Name</th>
                            <th>Order Type</th>
                            <th>Status</th>
                            <th>Pickup Date</th>
                            <th>Ordered By</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                            <tr>
                                <td>{{$row->reference_id}}</td>
                                <td>{{$row->product_sale->product_name}}</td>
                                <td><label style="color: {{$row->product_sale->type == 'Rent' ? 'blue' : 'green'}}">{{$row->product_sale->type}}</label></td>
                                <td><label style="color: {{$row->status == 'Pending' ? 'orange' : 'blue'}};">{{$row->status}}</label></td>
                                <td>{{ $row->pickup_date ? date_format(date_create($row->pickup_date), 'M d, Y') : 'Not Indicated' }}</td>
                                <td>{{$row->user->last_name}}, {{$row->user->first_name}}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary view-order" data-details='<?php echo $row; ?>'><i class="fa fa-eye"></i>&nbsp;&nbsp;View</button>
                                    <button class="btn btn-sm btn-danger delete-order" data-id='<?php echo $row->order_id; ?>'><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- order modal for customer -->
    <div class="modal fade" id="add-product">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Order for a Customer</h3>
                        </div>
                        <form method="post">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="product-code">Customer Name</label>
                                        <select id="customer" class="form-control">
                                            <option value="">Select Customer</option>
                                            @foreach(\App\Models\User::where('user_type', '0')->get() as $row)
                                                <option value="{{$row->id}}">{{$row->first_name}} {{$row->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card-footer">
                                <button type="button" class="btn btn-primary pull-right" id="order-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- edit modal -->
    <div class="modal fade" id="view-order">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header header-color">
                            <h3 class="card-title">Order Details&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;<b id="ref-no"></b></h3>
                        </div>
                        <div class="container">
                            <br>
                            {{-- <center id="show-loading" hidden>
                                <div class="spinner-border" style="width: 3rem; height: 3rem; text-align: center;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <br>
                                Please wait while we're processing your request..
                                <br><br>
                            </center> --}}
                            <div class="row justify-content-left" id="show-form">
                                <div class="col-md-4">
                                    <img class="card-img-top" id="product-image" alt="..." />
                                    <hr>
                                    <h4 style="color: teal;">Description</h4><hr>
                                    <p id="product-description"></p><hr>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <p id="code"></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p id="price"></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p id="product-name-desc"></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p id="type"></p>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="/view-payment-methods" class="btn btn-sm btn-success" target="_blank">View Payment Methods</a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card card-primary" style="background-color: #00adad;">
                                        <form method="post" id="submit-order" data-type="{{Auth::user()->user_type}}">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="product-code">Pick Up Date</label>
                                                        <input type="date" required class="form-control" id="pickup-date" {{Auth::user()->user_type === 1 || Auth::user()->user_type === 2 ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="product-name-desc">Downpayment Amount</label>
                                                        <input type="number" required class="form-control" id="downpayment" placeholder="Downpayment" {{Auth::user()->user_type === 1 || Auth::user()->user_type === 2 ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="product-name-desc" >Status</label>
                                                        <select  id="order-status" class="form-control" {{Auth::user()->user_type === 0 ? 'disabled' : '' }}>
                                                            <option value="">Select Status</option>
                                                            <option value="Pending">Pending</option>
                                                            <option value="Approved">Approved</option>
                                                            <option value="Disapproved">Disapproved</option>
                                                            <option value="Picked Up">Picked Up</option>
                                                            <option value="Returned">Returned</option>
                                                            <option value="Closed">Closed</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row hideUs"  {{Auth::user()->user_type === 0 ? 'hidden' : '' }}>
                                                    <div class="col-md-6">
                                                        <label for="amount">Return Date</label>
                                                        <input type="date"  class="form-control" id="return-date">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="quantity">Penalty Amount</label>
                                                        <input type="number" class="form-control" id="additional_fee" placeholder="Penalty Fee">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="image">Proof of Payment &nbsp;&nbsp; | &nbsp;&nbsp; <i id="download-file"></i></label>
                                                    <input type="file" class="form-control" id="payment" {{Auth::user()->user_type === 1 || Auth::user()->user_type === 2 ? 'hidden' : 'required' }}>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="card-footer" id="order-footer">
                                                <button type="submit" class="btn btn-primary pull-right submit-order-btn">Submit</button>
                                                <button disabled class="btn btn-default pull-right processing">Processing</button>
                                                <a {{Auth::user()->user_type === 0 ? 'hidden' : ''}} class="btn btn-default pull-right view-measurement" target="_blank" >View Measurement</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- delete modal--}}
    <div class="modal fade" id="delete-order">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this order?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light" id="proceed-delete-order">Proceed</button>
                </div>
            </div>
        </div>
    </div>
@endsection
        