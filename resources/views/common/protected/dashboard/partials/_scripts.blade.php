{{-- jQuery --}}

@yield('jquery')

<script src="{{ asset('js/lodash/lodash.min.js') }}"></script>

{{-- Bootstrap --}}
<script src="{{ commonAsset('dashboard/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
{{-- FastClick --}}
<script src="{{ commonAsset('dashboard/vendors/fastclick/lib/fastclick.js') }}"></script>
{{-- NProgress --}}
<script src="{{ commonAsset('dashboard/vendors/nprogress/nprogress.js') }}"></script>
{{-- iCheck --}}
<script src="{{ commonAsset('dashboard/vendors/iCheck/icheck.min.js') }}"></script>

<script src="{{ commonAsset('dashboard/vendors/select2/dist/js/select2.full.min.js') }}"></script>

{{-- jQuery Confirm --}}
<script src="{{ commonAsset('dashboard/vendors/jquery-confirm-master/dist/jquery-confirm.min.js') }}"></script>

@yield('js')

{{-- Custom Theme Scripts --}}
<script src="{{ commonAsset('dashboard/build/js/custom.min.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>	
@include('common.protected.dashboard.partials._gscripts')

@yield('once_scripts')

@yield('scripts')

@yield('b2b_scripts')
