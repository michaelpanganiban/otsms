@extends('layouts.customerBase')
@section('title', 'Home')
@section('content')
        <!-- Header-->
        <header class="bg-dark py-5 image-container2" >
            <div class="container px-4 px-lg-5 my-5 " >
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder" style="color: white !important;">Shop in Style!</h1>
                    <p class="lead fw-normal text-grey-50 mb-0"><b>Daniel and Janine Tailoring Shop</b></p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Filter:</label>
                            <select id="filter" class="form-control">
                                <option value="">--Select Category--</option>
                                <option value="Sale" {{ ( isset($_GET["filter"]) == "Sale" ) ? 'selected' : ''}}>Sale</option>
                                <option value="Rent" {{ ( isset($_GET["filter"]) == "Rent" ) ? 'selected' : ''}}>Rent</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Search: </label>
                            <input type="text" class="form-control" id="search" value={{ isset($_GET["search"]) }}>
                        </div>
                        <div class="col-md-4">
                            <label for="">&nbsp;</label><br>
                            <button class="btn btn-sm btn-primary" id="search-btn">Search</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-right">
                    @foreach($data as $row)
                        <div class="col mb-5">
                            <div class="card h-100">
                                <img class="card-img-top" src="../storage/{{$row->image}}" alt="..." style="min-height: 50%; max-height: 50%;"/>
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h5 class="fw-bolder">{{$row->product_name}}</h5>
                                        For: <label class="badge {{$row->type == 'Sale' ? 'bg-primary' : 'bg-success'}}">{{$row->type}}</label><br>
                                        ₱ &nbsp; {{number_format($row->amount, 2)}}
                                        <br>
                                        @if (($row->quantity - $row->ordered_count) <= 0)
                                            Stocks: <label class="badge bg-danger">Not Available</label>
                                        @else
                                            Stocks: <b>{{($row->quantity - $row->ordered_count)}}</b>
                                        @endif
                                    </div>
                                </div><hr>
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center">
                                        @if (($row->quantity - $row->ordered_count) <= 0)
                                            <button type="button" disabled class="btn-danger btn btn-outline-dark mt-auto ">Not Available</button>
                                        @else
                                            <a href="/view-product-details/{{$row->product_id}}?id={{request()->query('id')}}" class="btn btn-outline-dark mt-auto" target="_blank">View Details</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        {{-- <div class="modal fade" id="view-product">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header header-color">
                                <h3 class="card-title">Product Details</h3>
                            </div>
                            <div class="container">
                                <br>
                                <div class="row justify-content-left">
                                    <div class="col-md-4">
                                        <img class="card-img-top" id="product-image" alt="..." />
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group row">
                                            <div class="col-md-8"> <h3>Description</h3></div>
                                            <div class="col-md-4">
                                                @guest
                                                    <a href="/login" class="btn btn-sm btn-primary">Order Now!</a>
                                                @else
                                                    <a href="#" class="btn btn-sm btn-primary add-to-order">Order Now!</a>
                                                @endguest
                                                
                                            </div>
                                        </div>
                                        <hr>
                                        <p id="product-description"></p><hr>
                                        <p id="code"></p>
                                        <p id="price"></p>
                                        <p id="quantity"></p>
                                        <p id="type"></p>
                                        <p id="customer-id" data-pk="{{request()->query('id')}}"></p>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
@endsection