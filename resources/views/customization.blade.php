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
                            <h3 class="card-title">List of <label style="color: blue;" >Custimized Orders</label></h3>
                        </div>
                        <div class="col-md-6 col-md-offset-5">
                            <button class="btn btn-sm btn-primary" {{Auth::user()->user_type === 0 ? '' : 'hidden' }} style="margin-left: 76%;" data-toggle="modal" data-target="#customize">Customize Order</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="header-color">
                        <tr>
                            <th>Reference ID</th>
                            <th>Garment Type</th>
                            <th>Pickup Date</th>
                            <th>Status</th>
                            <th>Downpayment</th>
                            <th>Ordered By</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                            <tr>
                                <td>{{$row->reference_id}}</td>
                                <td>{{$row->garment_type}}</td>
                                <td>{{ $row->pickup_date ? date_format(date_create($row->pickup_date), 'M d, Y') : 'Not Indicated' }}</td>
                                <td><label style="color: {{$row->c_status == 'Pending' || $row->c_status == 'Cancelled' ? 'orange' : 'blue'}};">{{$row->c_status}}</label></td>
                                <td><label>{{number_format($row->downpayment, 2)}}</label></td>
                                <td>{{$row->last_name}}, {{$row->first_name}}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary view-custom" data-details='<?php echo json_encode($row); ?>'  data-usertype="{{Auth::user()->user_type}}"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</button>
                                    @if($row->c_status === 'Pending')
                                        <button class="btn btn-sm btn-danger delete-custom" data-ref='<?php echo $row->reference_id; ?>' data-id='<?php echo $row->custom_id; ?>'><i class="fa fa-trash"></i>&nbsp;&nbsp;Cancel</button>
                                    @endif    
                                    @if(($row->c_status === 'Active') && Auth::user()->user_type === 0 && ($row->downpayment == 0 || $row->downpayment == NULL))
                                        <button class="btn btn-sm btn-success pay-custom" data-details='<?php echo json_encode($row); ?>'><i class="fa fa-credit-card"></i>&nbsp;&nbsp;Pay Now</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- customize order --}}
    <div class="modal fade" id="customize">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Customize Order</h3>
                        </div>
                        <form method="post" id="submit-custom" style="background-color: #d3d3d3">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="product-code">Garment Type</label>
                                        <select required id="garment-type" class="form-control garment-type-cls">
                                            <option value="">Select Garment Type</option>
                                            <option value="Jersey">Jersey</option>
                                            <option value="School Uniform">School Uniform</option>
                                            <option value="PE Uniform">PE Uniform</option>
                                            <option value="Office Employee Uniform">Office Employee Uniform</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="product-name">Pickup Date</label>
                                        <input type="date" required class="form-control" id="custom-pickup-date">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{-- <div class="col-md-6">
                                        <label for="amount">Downpayment Amount</label>
                                        <input type="number" class="form-control" id="custom-downpayment" placeholder="Downpayment Amount">
                                    </div> --}}
                                    <div class="col-md-6">
                                        <label for="image">Upload Design</label>
                                    <input type="file" required class="form-control" id="design">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <input type="radio" name="classification" value="Upper Cloth" class="classification"> &nbsp;&nbsp;<b>Upper Cloth</b>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" name="classification" value="Lower Cloth" class="classification"> &nbsp;&nbsp;<b>Lower Cloth</b>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" name="classification" value="Both" class="classification"> &nbsp;&nbsp;<b>Both</b>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="for-jersey" hidden>
                                        <label for="description">Description:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="/view-measurement-guide" target="_blank" class="btn btn-sm btn-primary">View Measurement Guide</a> </label>
                                        <textarea class="form-control summernote" rows="5">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td><b>Quantity per Size:</b> </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Color:</b> </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Measurement:</b> </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </textarea>
                                    </div>
                                    <div class="not-jersey" hidden>
                                        <h3>Size Description:</h3>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label for="item-name">Shoulder Length (in)</label>
                                                <input type="number" step=".01"  class="form-control" id="shoulder" placeholder="Shoulder Length">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="item-name">Sleeve Length (in)</label>
                                                <input type="number" step=".01" class="form-control" id="sleeve" placeholder="Sleeve Length">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="item-name">Bust/Chest (in)</label>
                                                <input type="number" step=".01" class="form-control" id="bust-chest" placeholder="Bust/Chest">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="item-name">Waist (in)</label>
                                                <input type="number" step=".01" class="form-control" id="waist" placeholder="Waist">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="amount">Skirt Length (in)</label>
                                                <input type="number" step=".01"  class="form-control" id="skirt" placeholder="Skirt Length">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label for="amount">Slacks Length (in)</label>
                                                <input type="number" step=".01"  class="form-control" id="slacks-length" placeholder="Slacks Length">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="amount">Slacks Front Rise (in)</label>
                                                <input type="number" step=".01"  class="form-control" id="slacks-front-rise" placeholder="Slacks Front Rise">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="amount">Fit (Seat) (in)</label>
                                                <input type="number" step=".01" class="form-control"  id="fit-seat" placeholder="Fit (Seat)">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="amount">Fit (Thigh) (in)</label>
                                                <input type="number" step=".01" class="form-control"  id="fit-thigh" placeholder="Fit (Thigh)">
                                            </div>
                                        </div>
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
    <style>
         input[type='radio']:after {
            width: 15px;
            height: 15px;
            border-radius: 15px;
            top: -2px;
            left: -1px;
            position: relative;
            background-color: #fffdfd;
            content: '';
            display: inline-block;
            visibility: visible;
            border: 2px solid white;
        }

        input[type='radio']:checked:after {
            width: 15px;
            height: 15px;
            border-radius: 15px;
            top: -2px;
            left: -1px;
            position: relative;
            background-color: #ffa500;
            content: '';
            display: inline-block;
            visibility: visible;
            border: 2px solid white;
        }
    </style>
    <!-- edit modal -->
    <div class="modal fade" id="view-custom">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header header-color">
                            <h3 class="card-title">Order Details&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;<b id="ref-no"></b></h3>
                        </div>
                        <div class="container">
                            <br>
                            <div class="row justify-content-left">
                                <div class="col-md-4">
                                    <img class="card-img-top" id="custom-image" alt="..." />
                                </div>
                                <div class="col-md-8">
                                    <div class="card card-primary" style="background-color: #00adad;">
                                        <form method="post" id="submit-custom-edit">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="product-code">Garment Type</label>
                                                        <select required id="garment-type-edit" class="form-control garment-type-cls" {{Auth::user()->user_type === 0 ? '' : 'disabled' }}>
                                                            <option value="">Select Garment Type</option>
                                                            <option value="Jersey">Jersey</option>
                                                            <option value="School Uniform">School Uniform</option>
                                                            <option value="PE Uniform">PE Uniform</option>
                                                            <option value="Office Employee Uniform">Office Employee Uniform</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="product-name">Pickup Date</label>
                                                        <input type="date" required class="form-control" id="custom-pickup-date-edit" {{Auth::user()->user_type === 0 ? '' : 'disabled' }}>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="amount">Downpayment Amount</label>
                                                        <input type="number" class="form-control" id="custom-downpayment-edit" data-usertype= "{{Auth::user()->user_type}}" placeholder="Downpayment Amount" {{Auth::user()->user_type === 0 ? '' : 'disabled' }}>
                                                    </div>
                                                    <div class="col-md-6" {{Auth::user()->user_type === 0 ? '' : 'hidden' }}>
                                                        <label for="image">Upload Payment</label>
                                                        <input type="file" class="form-control" id="proof-edit" >
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12" {{Auth::user()->user_type === 0 ? '' : 'hidden' }}>
                                                        <label>Upload Design</label>
                                                        <input type="file" class="form-control" id="design-edit" >
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <input type="radio" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} name="classification-edit"  value="Upper Cloth" id="upper"> <b>Upper Cloth</b>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="radio" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} name="classification-edit" value="Lower Cloth" id="lower"> <b> Lower Cloth </b>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="radio" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} name="classification-edit" value="Both" id="both"> <b> Both </b>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="product-code">Status</label>
                                                        <select required id="status-edit" class="form-control" {{Auth::user()->user_type === 0 ? 'disabled' : '' }}>
                                                            <option value="">Select Status</option>
                                                            <option value="Pending">Pending</option>
                                                            <option value="Active">Active</option>
                                                            <option value="Picked Up">Picked Up</option>
                                                            <option value="Closed">Closed</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="product-code">Full Payment</label>
                                                        <input type="text" class="form-control" id="fullpayment-edit" {{Auth::user()->user_type === 0 ? 'disabled' : '' }} value="0">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="amount">Price</label>
                                                        <input type="number" required class="form-control" id="custom-price-edit" placeholder="Price" {{Auth::user()->user_type === 0 ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="image">Proof of Payment &nbsp;&nbsp; | &nbsp;&nbsp; <i id="download-file-custom"></i></label>
                                                    </div>
                                                </div>
                                                <div class="form-group row" {{Auth::user()->user_type === 0 ? 'hidden' : '' }}>
                                                    <div class="col-md-6">
                                                        <label for="amount">Tailor</label>
                                                        <select id="tailor" class="form-control">
                                                            <option value="1000">--Select Tailor--</option>
                                                            @foreach(App\Models\User::where('user_type', 2)->where('status', 'Active')->get() as $row)
                                                                <option value="{{$row->id}}">{{$row->first_name}} {{$row->last_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="for-jersey" hidden>
                                                    <div class="form-group">
                                                        <label for="description">Description: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="/view-measurement-guide" target="_blank" class="btn btn-sm btn-primary">View Measurement Guide</a> </label>
                                                        <textarea class="form-control summernote desc-edit" rows="5">
                                                        </textarea>
                                                    </div>
                                                </div>
                                                <div class="not-jersey" hidden>
                                                    <h3>Size Description:</h3>
                                                    <hr>
                                                    <div class="form-group row">
                                                        <div class="col-md-3">
                                                            <label for="item-name">Shoulder Length (in)</label>
                                                            <input type="number" step=".01"  class="form-control" id="edit-shoulder" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Shoulder Length">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="item-name">Sleeve Length (in)</label>
                                                            <input type="number" step=".01" class="form-control" id="edit-sleeve" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Sleeve Length">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="item-name">Bust/Chest (in)</label>
                                                            <input type="number" step=".01" class="form-control" id="edit-bust-chest" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Bust/Chest">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="item-name">Waist (in)</label>
                                                            <input type="number" step=".01" class="form-control" id="edit-waist" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Waist">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="amount">Skirt Length (in)</label>
                                                            <input type="number" step=".01"  class="form-control" id="edit-skirt" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Skirt Length">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                        <div class="col-md-3">
                                                            <label for="amount">Slacks Length (in)</label>
                                                            <input type="number" step=".01"  class="form-control" id="edit-slacks-length" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Slacks Length">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="amount">Slacks Front Rise (in)</label>
                                                            <input type="number" step=".01"  class="form-control" id="edit-slacks-front-rise" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Slacks Front Rise">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="amount">Fit (Seat) (in)</label>
                                                            <input type="number" step=".01" class="form-control"  id="edit-fit-seat" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Fit (Seat)">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="amount">Fit (Thigh) (in)</label>
                                                            <input type="number" step=".01" class="form-control"  id="edit-fit-thigh" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Fit (Thigh)">
                                                        </div>
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
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- delete modal--}}
    <div class="modal fade" id="delete-custom">
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
                    <button type="button" class="btn btn-outline-light" id="proceed-delete-custom">Proceed</button>
                </div>
            </div>
        </div>
    </div>

    {{-- payment modal--}}
    <div class="modal fade" id="pay-custom-modal">
        <div class="modal-dialog">
            <div class="modal-content bg-success">
                <div class="modal-header">
                    <h4 class="modal-title">Pay Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Item Price</label>
                            <input type="number" disabled class="form-control" id="item-price-custom">
                        </div>
                        <div class="col-md-6">
                            <label>Amount to Pay</label>
                            <input type="number"  class="form-control" id="amount-to-pay-custom">
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
                    <a href="/customization" class="btn btn-outline-light">Close</a>
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
                                <p style="color: rgb(219, 6, 6)">Note! Do not share this receipt with others! This will serve as your proof of payment.</p>
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
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td id="product-name"></td>
                                            <td id="product-code"></td>
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
                    <a href="/customization" class="btn btn-outline-light">Close</a>
                    {{-- <button type="button" class="btn btn-outline-light" id="proceed-payment-order">Proceed Payment</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
        