@extends('b2b.protected.dashboard.main')

@section('content')
  <div class="">

    <div class="page-title">
      <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12">
          <a href="{{ url('dashboard/tools/contacts/create') }}" class="btn btn-success btn-block">Add Contact</a>
        </div>
        <div class="col-md-4 col-sm-7 col-xs-12 text-center">
          <h3>Contacts List</h3>
        </div>
        <div class="col-md-5 col-sm-8 col-xs-12 form-group pull-right top_search">
          <form action="{{ url('dashboard/tools/contacts/') }}" method="head">
          <div class="input-group">
              <input type="text" class="form-control" name="s" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit">Go!</button>
              </span>
          </div>
          </form>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_content">
            <div class="row">
              {{-- Hidden  --}}
              <div class="col-md-12 col-sm-12 col-xs-12 text-center hide">
                <ul class="pagination pagination-split">
                  <li><a href="#">A</a></li>
                  <li><a href="#">B</a></li>
                  <li><a href="#">C</a></li>
                  <li><a href="#">D</a></li>
                  <li><a href="#">E</a></li>
                  <li>...</li>
                  <li><a href="#">W</a></li>
                  <li><a href="#">X</a></li>
                  <li><a href="#">Y</a></li>
                  <li><a href="#">Z</a></li>
                </ul>
              </div>
              {{-- /Hidden  --}}

              <div class="clearfix"></div>
              @forelse($contacts as $contact)
                <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                  <div class="well profile_view">
                    <div class="col-sm-12">
                      <div class="left col-xs-9 nopadding">
                        <h4 class="brief"><i>{{ $contact->title }}</i></h4>
                        <h2>{{ $contact->fullname }}</h2>
                        <p>
                          <strong>About: </strong> 
                          {{ sub_string($contact->about) }}
                        </p>
                      </div>
                      <div class="right col-xs-3 text-center nopadding">
                        <img src="{{ urlImage($contact->image_path) }}" alt="" class="img-circle img-responsive">
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                          <ul class="list-unstyled">
                            <li><i class="fa fa-building"></i> Address: {{ sub_string($contact->address, 75) }}</li>
                            <li><i class="fa fa-phone"></i> {{ $contact->phone }}</li> 
                            <li><i class="fa fa-envelope"></i> {{ $contact->email }}</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-12 bottom text-center">
                      <div class="col-xs-12 col-sm-12 emphasis">
                        <div class="col-sm-4 col-xs-12 nopadding">
                          <a href="{{ url('dashboard/tools/contacts/'.$contact->id) }}" class="btn btn-primary btn-xs" style="margin: 2px 0 0 0;">
                            <i class="icon-fgf" style="font-size: 18px;"> </i> View Profile
                          </a>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <a href="{{ $contact->facebook }}" target="_blank"><i class="fa fa-facebook-square font-size-30"></i></a>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <a href="{{ $contact->googleplus }}" target="_blank"><i class="fa fa-google-plus font-size-30"></i></a>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <a href="{{ $contact->linkedin }}" target="_blank"><i class="fa fa-linkedin font-size-30"></i></a>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <a href="{{ $contact->twitter }}" target="_blank"><i class="fa fa-twitter-square font-size-30"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @empty
                <p>Sorry... there is no contact</p>
              @endforelse
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <span class="pull-right">
                  {{ $contacts->links() }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
@endsection