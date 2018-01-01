@extends('backend.protected.dashboard.main')

@section('content')
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <a href="{{ url('admin/manage/users/') }}" class="btn btn-primary btn-block">Back</a>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 m-top-10">
      <div class="x_panel">
        <div class="x_content">
          <div class="row">
            @if (!is_null($user))
              <div class="clearfix"></div>
              <div class="col-md-12 col-sm-12 col-xs-12 profile_details">
                <div class="well col-md-12 col-sm-12 col-xs-12 profile_view">
                  <div class="col-md-12 col-sm-12">
                    
                    <div class="left col-md-9 col-sm-9 col-xs-9 nopadding">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <h4 class="brief"><i>{{ $user->title }}</i></h4>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <h1>{{ $user->fullname }}</h1>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <hr>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <p class="padding-tb-10">
                          <strong>About: </strong> 
                          {{ $user->about }}
                        </p>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <p class="padding-tb-10">
                          <strong>Address: </strong> 
                          {{ $user->address }}
                        </p>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <p><i class="fa fa-phone"></i> {{ $user->mobile }}</p>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <p class="padding-tb-10"><i class="fa fa-envelope"></i> {{ $user->email }}</p>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 m-tb-10px">
                        <a href="{{ url('dashboard/profile/password') }}" class="btn-link cursor-pointer">Change password</a>
                      </div>
                    </div>
                    <div class="left col-md-1 col-sm-1 col-xs-1"></div>
    
                    <div class="right col-md-2 col-sm-2 col-xs-2 text-center nopadding">
                      <img src="{{ $user->profile_pic }}" alt="" class="img-circle img-responsive">
                    </div>
                    
                  </div>
                  <div class="col-xs-12 bottom text-center">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <a href="{{ url('admin/manage/users/'.$user->email.'/edit') }}" class="btn btn-success btn-block"><i class="fa fa-edit"></i> Update Profile</a>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs- pull-right">
                      <div class="col-xs-12 col-sm-12 emphasis">
                        <div class="col-sm-3 col-xs-12">
                            <a href="{{ $user->facebook }}" target="_blank"><i class="fa fa-facebook-square font-size-30"></i></a>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <a href="{{ $user->googleplus }}" target="_blank"><i class="fa fa-google-plus font-size-30"></i></a>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <a href="{{ $user->linkedin }}" target="_blank"><i class="fa fa-linkedin font-size-30"></i></a>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <a href="{{ $user->twitter }}" target="_blank"><i class="fa fa-twitter-square font-size-30"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @else
              <p>Sorry... there is no contact</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

