@extends('admin.protected.dashboard.main')

@section('content')
  <div class="page-title">
    <div class="row">
      <div class="col-md-3 col-sm-3 col-xs-12">
        <a href="{{ url('dashboard/settings/vendor/lead') }}" class="btn btn-success btn-block"><i class="fa fa-arrow-left"></i> Back to All Contacts</a>
      </div>
    </div>
  </div>
  <div class="x_panel">
    <div class="x_content">
      <div class="profile_details">
        <div class="well col-md-12 col-sm-12 col-xs-12 profile_view">
          <div class="left col-md-9 col-sm-9 col-xs-9">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <h4 class="brief"><i>{{ $vendor->company_name }}</i></h4>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <h1>{{ $vendor->contact_person }}</h1>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <hr>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <p class="padding-tb-10">
                <strong>Note: </strong> 
                {{ $vendor->note }}
              </p>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <p class="padding-tb-10">
                <strong>Address: </strong> 
                {{ $vendor->address }}
              </p>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <p><i class="fa fa-phone"></i> {{ $vendor->contact_number }}</p>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <p class="padding-tb-10"><i class="fa fa-envelope"></i> {{ $vendor->email_id }}</p>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <p class="padding-tb-10"><i class="fa fa-globe"></i>
                <a class="btn btn-link cursor-pointer" href="{{ $vendor->website }}" target="_blank">
                    {{ sub_string($vendor->website, 80) }}
                </a>
              </p>
            </div>
          </div>
          <div class="left col-md-1 col-sm-1 col-xs-1"></div>

          <div class="right col-md-2 col-sm-2 col-xs-2 text-center">
            <img src="{{ $vendor->image }}" alt="" class="img-circle img-responsive">
          </div>
          <div class="col-xs-12 bottom text-center">
            <div class="col-md-2 col-sm-2 col-xs-12">
              <a href="{{ url('dashboard/settings/vendor/lead/'.$vendor->id.'/edit') }}" class="btn btn-primary btn-block"><i class="fa fa-edit"></i> Update Info</a>
            </div>
            <div class="btn-group col-md-2 col-sm-2 col-xs-12">
              <button data-toggle="dropdown" class="btn btn-default btn-block dropdown-toggle" type="button" aria-expanded="false"> More <span class="caret"></span> </button>
              <ul class="dropdown-menu">
                @if ($vendor->is_active == 1)
                  <li>
                    <a class="trigger-form">Deactivate</a>
                    <form method="POST" action="{{ url('dashboard/settings/vendor/lead/'.$vendor->id.'/deactivate') }}">
                      {{ csrf_field() }}
                      {{ method_field('put') }}
                      <button type="submit" class="input-submit" hidden></button>
                    </form>
                  </li>
                @endif
                @if (in_array($vendor->is_active,[0, 2]))
                  <li>
                    <a class="trigger-form">Activate</a>
                    <form method="POST" action="{{ url('dashboard/settings/vendor/lead/'.$vendor->id.'/activate') }}">
                      {{ csrf_field() }}
                      {{ method_field('put') }}
                      <button type="submit" class="input-submit" hidden></button>
                    </form>
                  </li>
                @endif
                <li>
                  <a class="btn-delete" data-href="{{ url('dashboard/settings/vendor/lead/'.$vendor->id) }}">Delete</a>
                </li>
              </ul>
            </div>
            <span class="pull-right col-md-2 col-sm-2">
              <b>Status : </b>(<span class="{{ statusCss($vendor->is_active) }}">{{ $vendor->status }}</span>)
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('scripts')
  <script>
    {{-- for more button --}}
    $(document).on('click', '.btn-delete', function () {
      var url = $(this).attr('data-href'),
      content = 'If you delete this vendor then all related <span class="red">client will be shift to the default vendor</span> and you will never be able recover deleted data. <form action="'+url+'" method="post" class="hide">{{ csrf_field() }} {{ method_field('delete') }}<button type="Submit" id="btn_delete_jquery_confirm"><button></form>';

      $.confirm({
        title: 'Are you sure?',
        content: content,
        buttons: {
          cancel: function () {
            //close
          },
          formSubmit: {
            text: 'Submit',
            btnClass: 'btn-blue',
            action: function () {
              $('#btn_delete_jquery_confirm').trigger('click');
            }
          }
        }
      });
    });

    $(document).on('click', '.trigger-form', function () {
      $(this).closest('li').find('.input-submit').trigger('click');
    });
    {{-- /for more button --}}
  </script>
@endsection
