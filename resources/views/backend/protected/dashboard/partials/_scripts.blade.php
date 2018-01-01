{{-- jQuery --}}

@yield('jquery', '<script src="'.asset('admin/dashboard/vendors/jquery/dist/jquery.min.js').'"></script>')


{{--  --}}
{{-- Bootstrap --}}
<script src="{{ asset('admin/dashboard/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
{{-- FastClick --}}
<script src="{{ asset('admin/dashboard/vendors/fastclick/lib/fastclick.js') }}"></script>
{{-- NProgress --}}
<script src="{{ asset('admin/dashboard/vendors/nprogress/nprogress.js') }}"></script>
{{-- iCheck --}}
<script src="{{ asset('admin/dashboard/vendors/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('admin/dashboard/vendors/iCheck/icheck.min.js') }}"></script>


@yield('js')

{{-- Custom Theme Scripts --}}
<script src="{{ asset('admin/dashboard/build/js/custom.min.js') }}"></script>
<script src="{{ URL::asset('js/scripts.js') }}"></script>	

@yield('scripts')
