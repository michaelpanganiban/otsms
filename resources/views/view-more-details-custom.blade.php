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

<div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
    <div class="card">
        <div class="card-body">
            <div class="container">
                <br>
                <div class="row justify-content-left">
                    <div class="col-md-4">
                        <img class="card-img-top" style="height: 370px; width: 99%;" src="../uploads/{{$data[0]->design}}" alt="..." />
                    </div>
                    <div class="col-md-8">
                        <div class="form-grow row">
                            <div class="col-md-12">
                                <h3><b>{{ucfirst($data[0]->garment_type)}}</b></h3>
                            </div>
                        </div>
                        <div class="form-grow row">
                            <div class="col-md-12">
                                <h3><b>Classification:</b> {{$data[0]->classification}}</h3>
                            </div>
                            @if($data[0]->garment_type == 'Jersey')
                                <div class="col-md-12">
                                    <textarea class="form-control summernote desc-edit" rows="5">{{$data[0]->details}}</textarea>
                                </div>
                            @else
                                <div>
                                    <h3><b>Size Description:</b></h3>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label for="item-name">Shoulder Length (in)</label>
                                            <input type="number"  class="form-control" value="{{$data[0]->shoulder_length}}" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Shoulder Length">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="item-name">Sleeve Length (in)</label>
                                            <input type="number" class="form-control" value="{{$data[0]->sleeve_length}}" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Sleeve Length">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="item-name">Bust/Chest (in)</label>
                                            <input type="number" class="form-control" value="{{$data[0]->bust_chest}}" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Bust/Chest">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="item-name">Waist (in)</label>
                                            <input type="number" class="form-control" value="{{$data[0]->waist}}" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Waist">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="amount">Skirt Length (in)</label>
                                            <input type="number"  class="form-control" value="{{$data[0]->skirt_length}}" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Skirt Length">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label for="amount">Slacks Length (in)</label>
                                            <input type="number"  class="form-control" value="{{$data[0]->slack_length}}" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Slacks Length">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="amount">Slacks Front Rise (in)</label>
                                            <input type="number"  class="form-control" value="{{$data[0]->slack_front_rise}}" {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Slacks Front Rise">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="amount">Fit (Seat) (in)</label>
                                            <input type="number" class="form-control" value="{{$data[0]->slack_fit_seat}}"  {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Fit (Seat)">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="amount">Fit (Thigh) (in)</label>
                                            <input type="number" class="form-control" value="{{$data[0]->slack_fit_thigh}}"  {{Auth::user()->user_type === 0 ? '' : 'disabled' }} placeholder="Fit (Thigh)">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection