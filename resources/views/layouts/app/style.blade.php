<link rel="icon" type="image/x-icon" href="{{ asset('admin/assets/img/favicon.ico') }}"/>
<link href="{{ asset('admin/assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('admin/assets/js/loader.js') }}"></script>
<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
<link href="{{ asset('admin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
{{-- DataTable --}}
<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/table/datatable/custom_dt_custom.css') }}">

<link href="{{ asset('admin/plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/assets/css/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/assets/css/elements/breadcrumb.css') }}" rel="stylesheet" type="text/css" />
{{-- Sweetalert --}}
<link href="{{ asset('admin/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
{{-- Select2 --}}
<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/select2/select2.min.css') }}">
{{-- Date Time Picker --}}
<link href="{{ asset('admin/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
{{-- Snackbar --}}
<link href="{{ asset('admin/plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
@if(request()->routeIs('login') || request()->routeIs('password.request'))
    <link href="{{ asset('admin/assets/css/authentication/form-1.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/forms/theme-checkbox-radio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/forms/switches.css') }}">
@endif
