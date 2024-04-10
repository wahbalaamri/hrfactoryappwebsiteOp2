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
                    <div class="card card-outline card-success">
                        {{-- card header --}}
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Add New Function') }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('ManageHrDiagnosis.index') }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                        {{-- card body --}}
                        <div class="card-body">
                            {{-- form --}}
                            <form action="{{ route('ManageHrDiagnosis.storeFunction') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="title">{{ __('Function Title') }}</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="Enter Function Title">
                                        {{-- validation --}}
                                        @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- title_ar --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="title_ar">{{ __('Function Title (Arabic)') }}</label>
                                        <input type="text" name="title_ar" id="title_ar" class="form-control"
                                            placeholder="Enter Function Title in Arabic">
                                        {{-- validation --}}
                                        @error('title_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- description --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="description">{{ __('Function Description') }}</label>
                                        <textarea name="description" id="description" class="form-control summernote"
                                            placeholder="Enter Function Description"></textarea>
                                        {{-- validation --}}
                                        @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- description_ar --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="description_ar">{{ __('Function Description (Arabic)') }}</label>
                                        <textarea name="description_ar" id="description_ar"
                                            class="form-control summernote"
                                            placeholder="Enter Function Description in Arabic"></textarea>
                                        {{-- validation --}}
                                        @error('description_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- select respondent --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="respondent">{{ __('Select Respondent') }}</label>
                                        <select name="respondent" id="respondent" class="form-control">
                                            <option value="">{{ __('Select Respondent') }}</option>
                                            <option value="1">{{ __('Only HR Employees') }}</option>
                                            <option value="2">{{ __('Only Employees') }}</option>
                                            <option value="3">{{ __('Only Managers') }}</option>
                                            <option value="4">{{ __('HR Employees & Employees') }}</option>
                                            <option value="5">{{ __('Managers & Employees') }}</option>
                                            <option value="6">{{ __('Managers & HR Employees') }}</option>
                                            <option value="7">{{ __('All Employees') }}</option>
                                            <option value="8">{{ __('Public') }}</option>
                                        </select>
                                        {{-- validation --}}
                                        @error('respondent')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- switch for status --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="status">{{ __('Status') }}</label>
                                        <br>
                                        <input type="checkbox" name="status" checked data-bootstrap-switch
                                            data-off-color="danger" data-on-color="success">
                                    </div>
                                    {{-- submit button --}}
                                    <div @class([ 'form-group col-md-12 col-sm-12' , 'text-right'=>
                                        App()->isLocale('en'),
                                        'text-left'=>App()->isLocale('ar')
                                        ])>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> {{ __('Save') }}
                                        </button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('scripts')
<script>
    $("[name='status']").bootstrapSwitch();
         $('.summernote').summernote();
</script>
@endsection
