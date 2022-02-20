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
                            <th>Size</th>
                            <th>Status</th>
                            <th>Pickup Date</th>
                            <th>Ordered By</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                            @if(Auth::user()->user_type !== 0 && $row->status === 'Cancelled')

                            @else
                                <tr>
                                    <td>{{$row->reference_id}}</td>
                                    <td>{{$row->product_sale->product_name}}</td>
                                    <td><label style="color: {{$row->product_sale->type == 'Rent' ? 'blue' : 'green'}}">{{$row->product_sale->type}}</label></td>
                                    <td>{{$row->size}}</td>
                                    <td><label style="color: {{$row->status == 'Pending' || $row->status == 'Cancelled' ? 'orange' : 'blue'}};">{{$row->status}}</label></td>
                                    <td>{{ $row->pickup_date ? date_format(date_create($row->pickup_date), 'M d, Y') : 'Not Indicated' }}</td>
                                    <td>{{$row->user->last_name}}, {{$row->user->first_name}}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary view-order" data-details='<?php echo $row; ?>'><i class="fa fa-eye"></i>&nbsp;&nbsp;View</button>
                                        @if($row->status === 'Pending')
                                            <button class="btn btn-sm btn-danger delete-order" data-ref='<?php echo $row->reference_id; ?>' data-id='<?php echo $row->order_id; ?>'><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
                                        @endif
                                        @if(($row->status === 'Pending' || $row->status === 'Active') && Auth::user()->user_type === 0)
                                            <button class="btn btn-sm btn-success pay-order" data-details='<?php echo $row; ?>'><i class="fa fa-credit-card"></i>&nbsp;&nbsp;Pay Now</button>
                                        @endif
                                    </td>
                                </tr>
                            @endif
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
                                        <form method="post" id="submit-order-edit" data-type="{{Auth::user()->user_type}}">
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
                                                <div class="form-group row" {{Auth::user()->user_type === 0 ? 'hidden' : '' }}>
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
                                                        <input type="date" {{Auth::user()->user_type === 0 ? 'disabled' : '' }}  class="form-control" id="return-date">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="quantity">Penalty Amount</label>
                                                        <input type="number" {{Auth::user()->user_type === 0 ? 'disabled' : '' }} class="form-control" id="additional_fee" placeholder="Penalty Fee">
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
                                                <button type="button" class="btn btn-danger pull-right cancel-order-btn">Cancel</button>
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
                    <h4 class="modal-title">Cancel Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this order?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light" id="proceed-delete-order">Proceed</button>
                </div>
            </div>
        </div>
    </div>

    {{-- CANCEL modal--}}
    <div class="modal fade" id="cancel-order-modal">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Cancel Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this order?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light" id="proceed-cancel-order">Proceed</button>
                </div>
            </div>
        </div>
    </div>

    {{-- payment modal--}}
    <div class="modal fade" id="pay-order-modal">
        <div class="modal-dialog">
            <div class="modal-content bg-success">
                <div class="modal-header">
                    <h4 class="modal-title">Pay Order</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Item Price</label>
                            <input type="number" disabled class="form-control" id="item-price">
                        </div>
                        <div class="col-md-6">
                            <label>Amount to Pay</label>
                            <input type="number"  class="form-control" id="amount-to-pay">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div id="paypal-button-container" hidden></div>
                            <div id="show-error" hidden>
                                <div class="alert alert-danger alert-dismissible">
                                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                    Your payment is morethan the Item price!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="/orders" class="btn btn-outline-light">Close</a>
                    {{-- <button type="button" class="btn btn-outline-light" id="proceed-payment-order">Proceed Payment</button> --}}
                </div>
            </div>
        </div>
    </div>
{{-- Receipt --}}
    <div class="modal fade" id="pay-receipt-modal" >
        <div class="modal-dialog modal-lg" >
            <div class="modal-content bg-success" style="max-height: 600px; overflow: auto;">
                <div class="modal-header">
                    <h4 class="modal-title">Order Reciept</h4>
                </div>
                <div class="modal-body" style="color: black;">
                    <section class="invoice" style="padding: 5% !important;">
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="page-header">
                                    <i class="fa fa-globe"></i> D&J Tailoring Shop
                                </h2>
                            </div>
                        </div>
                        <hr>
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <strong>D&J Tailoring Shop.</strong><br>
                                    Gaongan Shop<br>
                                    Sitio Sabang, Gaongan Sipocot Camarines Sur<br>
                                    Phone: 09273733612<br>
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <strong id="payee"></strong><br>
                                    <b>Payer ID: </b> <i id="payer-id"></i>
                                    <b>Merchant ID: </b> <i id="merchant-id"></i>
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <b>Transaction ID:</b> <i id="transaction-id"></i><br>
                                <br>
                                <b>Order ID:</b> <i id="order-id"></i><br>
                                <b>Payment Date:</b> <i id="payment-date"></i><br>
                                <b>Status:</b> <i id="status"></i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Product</th>
                                            <th>Product Code</th>
                                            <th>Description</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td id="product-name"></td>
                                            <td id="product-code"></td>
                                            <td id="product-desc"></td>
                                            <td class="subtotal"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <p class="lead">Payment Method:</p>
                                    <img src="{{ asset('assets/dist/img/credit/paypal2.png') }}" alt="Paypal">
                                </p>
                            </div>
                            <div class="col-md-6 pull-right">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Total:</th>
                                            <td class="subtotal"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="/orders" class="btn btn-outline-light">Close</a>
                    {{-- <button type="button" class="btn btn-outline-light" id="proceed-payment-order">Proceed Payment</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
        