@extends('dashboard.layouts.main')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Services</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Service</li>
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
                {{-- show all services --}}
                @foreach ($services as $service)
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $service->name }}</h3>
                        </div>
                        <div class="card-body">
                            <p>{!! $service->description !!}</p>
                            <a href="{{ route('services.show', $service->id) }}" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
                @endforeach
                {{-- add new service button --}}
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add New Service</h3>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <a href="{{ route('services.create') }}" class="btn btn-primary">
                                {{-- plus icon large --}}
                                <i class="fas fa-plus fa-2x"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
