@extends('admin.admin_master')
@section('admin')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Change Password Page</h4><br><br>
                            @if (count($errors))
                            @foreach ($errors->all() as $error)
                            <p class="alert alert-danger alert-dismissible fade show">{{ $error }}</p>
                            @endforeach

                            @endif
                            <form action="{{ route('update.password') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Current Password</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="current_password"
                                            id="current_password">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">New Password</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="password" name="new_password"
                                            value="" id="new_password">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Confirm Password</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="password" name="confirm_password"
                                            value="" id="confirm_password">
                                    </div>
                                </div>
                                <!-- end row -->
                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Change Password">
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>
@endsection
