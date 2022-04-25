@extends('layouts.base')
@section('title', 'Dashboard')
@section('content')
{{-- @php $order_amount = 0; @endphp
@php $custom_amount = 0; @endphp
@php $total = 0; @endphp

@if(!empty($data))
    @php $order_amount = $data[0]->amount; @endphp
@endif
@if(!empty($custom))
    @php $custom_amount = $custom[0]->amount; @endphp
@endif
@php $total = $order_amount + $custom_amount; @endphp --}}
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
                {{-- <button id="sms">Send</button> --}}
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{\App\Models\User::where('user_type', 0)->count()}}</h3>
                            <p>Registered Customers</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                                <h3>{{\App\Models\Order::where('status', 'Approved')->count() + \App\Models\Customization::where('status', 'Active')->count()}}</h3>
                            <p>Active Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{\App\Models\Order::where('status', 'Pending')->count()  + \App\Models\Customization::where('status', 'Pending')->count()}}</h3>
                            <p>Pending Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box" style="background-color: pink !important;">
                        <div class="inner">
                            <h3 id="month-sale"></h3>
                            <p>Sales of the Month</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" >
                {{-- <select name="" id="type" class="form-control" >
                    <option value="Custom">Custom</option>
                    <option value="Rent">Rent</option>
                    <option value="Sales">Sales</option>
                </select> --}}
            </div>
            <div class="col-md-6" >
                <select name="" id="year" class="form-control" >
                    @for($i = 0; $i < 5; $i++)
                        <option value="<?php echo Date('Y') - $i; ?>"><?php echo Date('Y') - $i; ?></option>
                    @endfor
                </select>
            </div>
        </div> <br>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Sales</h3>
                            {{-- <a href="javascript:void(0);">View Report</a> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg total"></span>
                                <span class="text-muted">Total Sales This Year</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-bold text-lg total-last"></span>
                                <span class="text-muted">Total Sales Last Year</span>
                            </p>
                        </div>
                        <div class="position-relative mb-4">
                            <canvas id="sales-chart" height="200"></canvas>
                        </div>
                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                            <i class="fas fa-square text-primary"></i> This year
                            </span>
        
                            <span>
                            <i class="fas fa-square text-gray"></i> Last year
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background-color: pink !important;">
                        <h3 class="card-title">Order Chart</h3>
        
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="card-title">TOP 5 <label style="color: blue;" >Orders</label></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead class="header-color">
                                <tr>
                                    <th>Product Name</th>
                                    <th>No. of orders</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($top_five as $row)
                                    <tr>
                                        <td>{{$row->product_name}}</td>
                                        <td>{{$row->P_COUNT}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</div></div>
@endsection
        