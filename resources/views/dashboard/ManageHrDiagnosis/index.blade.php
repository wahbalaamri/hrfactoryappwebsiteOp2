@extends('dashboard.layouts.main')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('HR Diagnosis Tool') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">HR Diagnosis</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Functions') }}
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('ManageHrDiagnosis.createFunction') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Function Title') }}</th>
                                            <th>{{ __('Function Practices') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($functions)>0)
                                        @foreach($functions as $function)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $function->title }}</td>
                                            <td>
                                                {{-- button to view practices --}}

                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#viewPracticesModal">
                                                    <i class="fas fa-eye" data-toggle="modal"
                                                        data-target="#viewPracticesModal"></i> {{ __('View Practices')
                                                    }}</button>
                                            </td>
                                            <td>
                                                <a href=""
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                                </a>
                                                <a href=""
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> {{ __('Delete') }}
                                                </a>
                                            </td>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="4" class="text-center">{{ __('No Data Found') }}</td>
                                            </tr>
                                            @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
</div>
@endsection
