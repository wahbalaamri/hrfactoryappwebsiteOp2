@extends('dashboard.layouts.main')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard </li>
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

                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="connectedSortable w-100">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users mr-1"></i>
                                {{ __("Client's Tools") }}
                            </h3>
                            <div class="card-tools">
                            </div>
                        </div><!-- /.card-header -->
                        {{-- card body --}}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h4>{{ __('Manual Builder') }}</h4>
                                            <p>{{ __('HR Policy Builder') }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">
                                            {{ __('Get Started') }} <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h4>{{ __('Employee Engagment') }}</h4>
                                            <p>{{ __("Measure Your Employee Happiness") }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-happy"></i>
                                        </div>
                                        <a href="{{route('clients.ShowSurveys',[$id,3])}}" class="small-box-footer">
                                            {{ __('Get Started') }} <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h4>{{ ('HR Diagnosis') }}</h4>
                                            <p>{{ ("Insepct You HR Department") }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-business-time"></i>
                                        </div>
                                        <a href="{{route('clients.ShowSurveys',[$id,4])}}" class="small-box-footer">
                                            {{ __('Get Started') }} <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h4>{{ __('360 Leader Review') }}</h4>
                                            <p>{{ __('Assess Your Leaders From 360 Degree') }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <a href="{{route('clients.ShowSurveys',[$id,5])}}" class="small-box-footer">
                                            {{ __('Get Started') }} <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h4>{{ ('HR Templates') }}</h4>
                                            <p>{{ ("Access Most Used HR Templates") }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-folder-open"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">
                                            {{ __('Get Started') }} <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.Left col -->
            </div>
        </div>
    </section>
</div>
@endsection
