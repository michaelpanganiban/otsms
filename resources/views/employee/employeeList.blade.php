@extends('layouts.base')
@section('title', 'Employees')
@section('content')
    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
        <div class="card">
            <div class="card-header">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">List of Employees</h3>
                        </div>
                        <div class="col-md-6 col-md-offset-5">
                            <button class="btn btn-sm btn-success" style="margin-left: 76%;" data-toggle="modal" data-target="#add-employee"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Employee</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="header-color">
                        <tr>
                            <th>FullName</th>
                            <th>Email</th>
                            <th>Contact #</th>
                            <th>Birthday</th>
                            <th>Salary</th>
                            <th>Status</th>
                            <th>User Type</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\User::whereIn('user_type', array('1', '2'))->get() as $row)
                            <tr class="{{ $row->status == 'Inactive' ? 'dangerBG' : '' }}">
                                <td>{{$row->last_name}}, {{$row->first_name}} {{$row->middle_name}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{ $row->contact_no }}</td>
                                <td>{{date_format(date_create($row->birthday), 'M d, Y')}}</td>
                                <td>{{number_format($row->salary)}}</td>
                                <td><label>{{$row->status}}</label></td>
                                <td>{{ $row->user_type == '1' ? 'Admin' : 'Tailor' }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary edit-employee" data-details='<?php echo $row; ?>'><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                                    <button class="btn btn-sm btn-danger delete-employee" data-id='<?php echo $row->id; ?>'><i class="fa fa-trash"></i>&nbsp;&nbsp;Deactivate</button>
                                    {{-- <button class="btn btn-sm btn-warning schedule-employee" data-id='<?php echo $row->id; ?>'><i class="fa fa-calendar"></i>&nbsp;&nbsp;Schedule</button> --}}
                                    <button class="btn btn-sm btn-success workload-employee" data-id='<?php echo $row->id; ?>'><i class="fa fa-cog"></i>&nbsp;&nbsp;Workload</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- add modal -->
    <div class="modal fade" id="add-employee">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Employee</h3>
                        </div>
                        <form method="POST" id="add-employee-submit">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row mb-12">
                                        <label for="first_name" class="col-md-1 col-form-label text-md-right">{{ __('First Name') }}</label>
                                        <div class="col-md-3">
                                            <input id="employee-first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" required autocomplete="first_name" autofocus>
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <label for="middle_name" class="col-md-1 col-form-label text-md-right">{{ __('Middle Name') }}</label>
                                        <div class="col-md-3">
                                            <input id="employee-middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name"  autocomplete="middle_name">
                                            @error('middle_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <label for="last_name" class="col-md-1 col-form-label text-md-right">{{ __('Last Name') }}</label>
                                        <div class="col-md-3">
                                            <input id="employee-last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" autocomplete="last_name">
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-12">
                                    <label for="email" class="col-md-1 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                    <div class="col-md-3">
                                        <input id="employee-email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email">
        
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <label for="contact_no" class="col-md-1 col-form-label text-md-right">{{ __('Contact Number') }}</label>
                                    <div class="col-md-3">
                                        <input id="employee-contact_no" type="text" class="form-control @error('contact_no') is-invalid @enderror" name="contact_no" required autocomplete="contact_no">
                                        @error('contact_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <label for="birthday" class="col-md-1 col-form-label text-md-right">{{ __('Birthday') }}</label>
                                    <div class="col-md-3">
                                        <input id="employee-birthday" type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" required autocomplete="birthday">
                                        @error('birthday')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <label for="user_type" class="col-md-1 col-form-label text-md-right">{{ __('User Type') }}</label>
                                    <div class="col-md-3">
                                        <select class="form-control" id="employee-user_type" required>
                                            <option value="">Select User Type</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Tailor</option>
                                        </select>
                                    </div>
                                    <label for="salary" class="col-md-1 col-form-label text-md-right">{{ __('Salary') }}</label>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control" id="employee-salary">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Proceed') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- edit modal -->
    <div class="modal fade" id="edit-employee">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Employee</h3>
                        </div>
                        <form method="POST" id="edit-employee-submit">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row mb-12">
                                        <label for="first_name" class="col-md-1 col-form-label text-md-right">{{ __('First Name') }}</label>
                                        <div class="col-md-3">
                                            <input id="edit-employee-first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" required autocomplete="first_name" autofocus>
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <label for="middle_name" class="col-md-1 col-form-label text-md-right">{{ __('Middle Name') }}</label>
                                        <div class="col-md-3">
                                            <input id="edit-employee-middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name"  autocomplete="middle_name">
                                            @error('middle_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <label for="last_name" class="col-md-1 col-form-label text-md-right">{{ __('Last Name') }}</label>
                                        <div class="col-md-3">
                                            <input id="edit-employee-last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" autocomplete="last_name">
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-12">
                                    <label for="email" class="col-md-1 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                    <div class="col-md-3">
                                        <input id="edit-employee-email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email">
        
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <label for="contact_no" class="col-md-1 col-form-label text-md-right">{{ __('Contact Number') }}</label>
                                    <div class="col-md-3">
                                        <input id="edit-employee-contact_no" type="text" class="form-control @error('contact_no') is-invalid @enderror" name="contact_no" required autocomplete="contact_no">
                                        @error('contact_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <label for="birthday" class="col-md-1 col-form-label text-md-right">{{ __('Birthday') }}</label>
                                    <div class="col-md-3">
                                        <input id="edit-employee-birthday" type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" required autocomplete="birthday">
                                        @error('birthday')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <label for="user_type" class="col-md-1 col-form-label text-md-right">{{ __('User Type') }}</label>
                                    <div class="col-md-3">
                                        <select class="form-control" id="edit-employee-user_type" required>
                                            <option value="">Select User Type</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Tailor</option>
                                        </select>
                                    </div>
                                    <label for="status" class="col-md-1 col-form-label text-md-right">{{ __('User Type') }}</label>
                                    <div class="col-md-3">
                                        <select class="form-control" id="edit-employee-status" required>
                                            <option value="">Select Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                    <label for="salary" class="col-md-1 col-form-label text-md-right">{{ __('Salary') }}</label>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control" id="edit-employee-salary">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Save Changes') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- delete modal--}}
    <div class="modal fade" id="delete-employee">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Deactivate Employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to deactivate this employee?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light" id="proceed-delete-employee">Proceed</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule modal -->
    <div class="modal fade" id="schedule-modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background-color: transparent; border-color: transparent; box-shadow: none !important;">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Schedule</h3>
                        </div>
                        <form method="post" id="stock-in-submit">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card bg-warning">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <b>Monday</b> &nbsp; | &nbsp;
                                                    <b>OFF DUTY?</b>&nbsp;&nbsp;<input type="checkbox" id="monday-off" value="0">
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <label for="monday-from">From</label>
                                                <input type="time" class="form-control" id="monday-from">
                                                <label for="monday-to">To</label>
                                                <input type="time" class="form-control" id="monday-to">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-warning">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <b>Tuesday</b> &nbsp; | &nbsp;
                                                    <b>OFF DUTY?</b>&nbsp;&nbsp;<input type="checkbox" id="tuesday-off" value="0">
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <label for="tuesday-from">From</label>
                                                <input type="time" class="form-control" id="tuesday-from">
                                                <label for="tuesday-to">To</label>
                                                <input type="time" class="form-control" id="tuesday-to">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-warning">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <b>Wednesday</b> &nbsp; | &nbsp;
                                                    <b>OFF DUTY?</b>&nbsp;&nbsp;<input type="checkbox" id="wednesday-off" value="0">
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <label for="wednesday-from">From</label>
                                                <input type="time" class="form-control" id="wednesday-from">
                                                <label for="wednesday-to">To</label>
                                                <input type="time" class="form-control" id="wednesday-to">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-warning">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <b>Thursday</b> &nbsp; | &nbsp;
                                                    <b>OFF DUTY?</b>&nbsp;&nbsp;<input type="checkbox" id="thursday-off" value="0">
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <label for="thursday-from">From</label>
                                                <input type="time" class="form-control" id="thursday-from">
                                                <label for="thursday-to">To</label>
                                                <input type="time" class="form-control" id="thursday-to">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-warning">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <b>Friday</b> &nbsp; | &nbsp;
                                                    <b>OFF DUTY?</b>&nbsp;&nbsp;<input type="checkbox" id="friday-off" value="0">
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <label for="friday-from">From</label>
                                                <input type="time" class="form-control" id="friday-from">
                                                <label for="friday-to">To</label>
                                                <input type="time" class="form-control" id="friday-to">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-danger">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <b>Saturday</b> &nbsp; | &nbsp;
                                                    <b>OFF DUTY?</b>&nbsp;&nbsp;<input type="checkbox" id="saturday-off" value="0">
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <label for="saturday-from">From</label>
                                                <input type="time" class="form-control" id="saturday-from">
                                                <label for="saturday-to">To</label>
                                                <input type="time" class="form-control" id="saturday-to">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-danger">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <b>Sunday</b> &nbsp; | &nbsp;
                                                    <b>OFF DUTY?</b>&nbsp;&nbsp;<input type="checkbox" id="sunday-off" value="0">
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <label for="sunday-from">From</label>
                                                <input type="time" class="form-control" id="sunday-from">
                                                <label for="sunday-to">To</label>
                                                <input type="time" class="form-control" id="sunday-to">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card-footer">
                                <button type="button" id="submit-schedule" class="btn btn-primary pull-right">Save Changes</button>
                                {{-- <button type="button" id="update-schedule" class="btn btn-primary pull-right">Save Changes</button> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Workload --}}
    <div class="modal fade" id="workload-employee">
        <div class="modal-dialog modal-lg" style="max-width: 99% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Employee Workload</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"  style="overflow: auto !important;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="header-color">
                            <tr>
                                <th>Reference ID</th>
                                <th>Garment Type</th>
                                <th>Pickup Date</th>
                                <th>Classification</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="attach-work-load">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
        