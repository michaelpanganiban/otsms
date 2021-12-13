@extends('layouts.base')
@section('title', 'Payment Methods')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>List of Payment Methods</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  @foreach (\App\Models\PaymentMethod::all() as $item)
                    <div class="col-sm-4">
                        <div class="position-relative p-3 bg-gray" style="height: 180px">
                        <div class="ribbon-wrapper ribbon-xl">
                            <div class="ribbon bg-primary">
                                {{$item->method_name}}
                            </div>
                        </div>
                        <b>{{$item->bank_name}}</b> <br />
                        <p><b>Account #: </b>{{$item->account_no}}</p>
                        <p><b>Account Name: </b>{{$item->account_name}}</p>
                        </div>
                    </div>
                  @endforeach
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection