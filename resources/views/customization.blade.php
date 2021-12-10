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
                                <td><label style="color: {{$row->status == 'Pending' ? 'orange' : 'blue'}};">{{$row->status}}</label></td>
                                <td><label>{{number_format($row->downpayment, 2)}}</label></td>
                                <td>{{$row->user->last_name}}, {{$row->user->first_name}}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary view-custom" data-details='<?php echo $row; ?>'  data-usertype="{{Auth::user()->user_type}}"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</button>
                                    <button class="btn btn-sm btn-danger delete-custom" data-id='<?php echo $row->custom_id; ?>'><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</button>
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
                        <form method="post" id="submit-custom">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="product-code">Garment Type</label>
                                        <select required id="garment-type" class="form-control">
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
                                    <div class="col-md-6">
                                        <label for="amount">Downpayment Amount</label>
                                        <input type="number" required class="form-control" id="custom-downpayment" placeholder="Downpayment Amount">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="image">Upload Design</label>
                                    <input type="file" required class="form-control" id="design">
                                    </div>
                                </div>
                                <div class="form-group">
                                    
                                </div>
                                <div class="form-group">
                                    <label for="description">Description:</label>
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
                                        {{-- <b>Quantity per Size (S/M/L/XL): </b>
                                        <br>
                                        <b>Color:</b><br>
                                        <b>Measurement: </b><br>
                                        <b>Jersey numbers and names: </b> --}}
                                    </textarea>
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
                                                        <select required id="garment-type-edit" class="form-control" {{Auth::user()->user_type === 0 ? '' : 'disabled' }}>
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
                                                        <input type="number" required class="form-control" id="custom-downpayment-edit" placeholder="Downpayment Amount" {{Auth::user()->user_type === 0 ? '' : 'disabled' }}>
                                                    </div>
                                                    <div class="col-md-6" {{Auth::user()->user_type === 0 ? '' : 'hidden' }}>
                                                        <label for="image">Upload Design</label>
                                                        <input type="file" class="form-control" id="design-edit" >
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
                                                        <input type="text" class="form-control" id="fullpayment-edit" {{Auth::user()->user_type === 0 ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description:</label>
                                                    <textarea class="form-control summernote desc-edit" rows="5">
                                                    </textarea>
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
                    <button type="button" class="btn btn-outline-light" id="proceed-delete-custom">Proceed</button>
                </div>
            </div>
        </div>
    </div>

    
@endsection
        