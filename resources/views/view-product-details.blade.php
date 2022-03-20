@extends(Auth::check() ? 'layouts.base' : 'layouts.customerBase')
@section('title', 'Details')
@section('content')
<link href="{{ asset('assets/star-rating/css/star-rating.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/star-rating/themes/krajee-fas/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/star-rating/themes/krajee-svg/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<!--suppress JSUnresolvedLibraryURL -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/star-rating/js/star-rating.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/star-rating/themes/krajee-fas/theme.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/star-rating/themes/krajee-svg/theme.js') }}" type="text/javascript"></script>
<?php 
// rating computation
$total_rating = 0;
$ones = 0; $twos = 0; $threes = 0; $fours = 0; $fives = 0;
foreach($all_rating as $row){
    if($row->rating == 1)
        $ones++;
    else if($row->rating == 2)
        $twos++;
    else if($row->rating == 3)
        $threes++;
    else if($row->rating == 4)
        $fours++;
    else
        $fives++;
    $total_rating = (($ones*1) + ($twos*2) + ($threes*3) + ($fours*4) + ($fives*5)) / sizeof($all_rating);
}
?>
<div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
    <div class="card">
        <div class="card-body">
            <div class="container">
                <br>
                <div class="row justify-content-left">
                    <div class="col-md-4">
                        <img class="card-img-top" style="height: 370px; width: 99%;" src="../uploads/{{$data->image}}" alt="..." />
                    </div>
                    <div class="col-md-8">
                        <div class="form-grow row">
                            <div class="col-md-12">
                                <h3><b>{{ucfirst($data->product_name)}}</b></h3>
                            </div>
                        </div>
                        <div class="form-grow row">
                            <div class="col-md-5">
                                @if(Auth::check())
                                    <input id="input-21d" value="{{$rating ? $rating->rating : 0}}" type="text" class="rating" data-theme="krajee-fas" data-min=0 data-max=5 data-step=1 data-size="m" title="">
                                @else
                                    <input id="input-21d" value="{{$total_rating  ? $total_rating : 0}}" type="text" class="rating" data-theme="krajee-fas" data-min=0 data-max=5 data-step=.1 data-size="m" title="">
                                @endif
                            </div>
                            <div class="col-md-7">
                                <a href="#" style="text-decoration: none;">{{sizeof($all_rating)}} Ratings</a>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;<a href="#" style="text-decoration: none;">{{sizeof($reviews)}} Reviews</a>
                            </div>
                        </div>
                        <div class="form-grow row">
                            <div class="col-md-6"><br>
                                <h1 style="color: teal">₱&nbsp;{{number_format($data->amount,2)}}</h1>
                            </div>
                            <div class="col-md-6"><br>
                                @guest
                                    <a href="/login" class="btn btn-lg" style="background-color: teal; color: white;">Order Now!</a>
                                @else
                                    <a href="#" class="btn btn-lg"  style="background-color: teal; color: white;" data-toggle="modal" data-target="#view-sizes">Order Now!</a>
                                @endguest
                            </div>
                        </div>
                        <hr>
                        <div class="form-grow row">
                            <div class="col-md-12">
                                <h3>Product details for {{$data->product_name}}</h3>
                            </div>
                            <div class="col-md-12">
                                <p>{{$data->description}}</p><hr>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 row" style="max-height: 100px;">
                        <div class="col-md-7">
                            <input disabled value="5" type="text" class="rating input-21d" data-theme="krajee-fas" data-min=0 data-max=5 data-step=1 data-size="m" title="">
                        </div>
                        <div class="col-md-5" style=" margin-top: 8px !important;">
                            <b style="font-size: 22px; color: green">{{$fives}}</b>
                        </div>
                        <div class="col-md-7">
                            <input disabled value="4" type="text" class="rating input-21d" data-theme="krajee-fas" data-min=0 data-max=5 data-step=1 data-size="m" title="">
                        </div>
                        <div class="col-md-5" style=" margin-top: 8px !important;">
                            <b style="font-size: 22px; color: blue">{{$fours}}</b>
                        </div>
                        <div class="col-md-7">
                            <input disabled value="3" type="text" class="rating input-21d" data-theme="krajee-fas" data-min=0 data-max=5 data-step=1 data-size="m" title="">
                        </div>
                        <div class="col-md-5" style=" margin-top: 8px !important;">
                            <b style="font-size: 22px; color: teal">{{$threes}}</b>
                        </div>
                        <div class="col-md-7">
                            <input disabled value="2" type="text" class="rating input-21d" data-theme="krajee-fas" data-min=0 data-max=5 data-step=1 data-size="m" title="">
                        </div>
                        <div class="col-md-5" style=" margin-top: 8px !important;">
                            <b style="font-size: 22px; color: orange">{{$twos}}</b>
                        </div>
                        <div class="col-md-7">
                            <input disabled value="1" type="text" class="rating input-21d" data-theme="krajee-fas" data-min=0 data-max=5 data-step=1 data-size="m" title="">
                        </div>
                        <div class="col-md-5" style=" margin-top: 8px !important;">
                            <b style="font-size: 22px; color: red">{{$ones}}</b>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <i>Overall rating: </i>
                            <p style="color: teal; font-size: 90youpx;">{{number_format($total_rating, 2)}} / 5</p> 
                        </div>
                    </div>
                    <div class="col-md-8">
                        @if(Auth::check())
                            <button class="btn btn-sm" style="background-color: rgb(72, 145, 145); color: white;" data-toggle="modal" data-target="#add-review">Add Product Review</button>
                        @endif
                        <br>
                        <table id="review" class="table table-bordered table-striped">
                            <thead style="background-color:  transparent;">
                                <tr>
                                    <th>Product Reviews</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $row)
                                    <tr>
                                        <td>
                                            {{$row->review}}
                                            <hr>
                                            <i style="font-size: 10px;">{{date_format(date_create($row->created_at), 'M d, Y | H:i A')}}</i>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-review">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Review this Product</h3>
                    </div>
                    <form method="post" id="submit-review">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    {{-- <input type="hidden" required class="form-control" value={{Request::segment(2)}} id="product-id" placeholder="Item Name"> --}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="review-detail">Review Details</label>
                                <textarea autofocus id="review-detail" class="form-control" rows="5"></textarea>
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
<div class="modal fade" id="view-sizes">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header header-color">
                        <h3 class="card-title">Product Sizes</h3>
                    </div>
                    <div class="container">
                        <br>
                        <div class="row justify-content-left">
                            <div class="col-md-12 row">
                                <div class="col-md-3">
                                    <input type="radio" class="form-control size" value="S" name="size"> <label style="margin-left: 40%;">S</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="radio" class="form-control size" value="M" name="size"> <label style="margin-left: 40%;">M</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="radio" class="form-control size" value="L" name="size"> <label style="margin-left: 40%;">L</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="radio" class="form-control size" value="XL" name="size"> <label style="margin-left: 40%;">XL</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                                <button class="btn btn-sm pull-right" data-pk="{{request()->query('id')}}" data-productId="{{$data->product_id}}" style="background-color: teal; color: white;" id="submit-order">Submit Order</button>
                                <br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="login-indicator" data-id="{{$data->product_id}}" value="{{Auth::check() ? '' : 'disabled'}}">
<script>
    const product_id = $("#login-indicator").data('id')
    let disabled = ''
    disabled = $("#login-indicator").val()
    $('#input-21d').rating('refresh', {disabled, showClear:false, showCaption:true});
    $('.input-21d').rating('refresh', {showClear:false, showCaption:false});
 
    $('#input-21d').on('rating:change',function(event, value, caption, target) {
        $.post('/product-details/rate',{product_id, value}, function(r){
            console.log(r)
        })
    });

    $("#submit-review").submit(function(e){
        e.preventDefault()
        const data = {
            review: $("#review-detail").val(),
            product_id: product_id
        }
        $.post("/product-details/add-review", {data}, function(r){
            if(r == 1){
                alert('Reviews has been successfully added.')
                location.reload();
            }
            else{
                alert('Error occured while adding a review')
            }
        })
    });
</script>
@endsection