{{-- extends --}}
@extends('dashboard.layouts.main')

{{-- content --}}
{{-- show client details --}}
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
            <div class="row">
                    {{-- create funcy card to display surveys --}}
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Surveys') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table id="surveysDataTable"
                                                class="table table table-bordered data-table">
                                                <thead>
                                                    <tr>
                                                        <td colspan="14" class="">
                                                            <a href="{{-- {{ route('surveys.CreateNewSurvey',$client->id) }} --}}"
                                                                class="btn btn-sm btn-primary {{ App()->getLocale()=='ar'? 'float-start':'float-end' }}">{{
                                                                __('Create New Survey') }}</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="">#</th>
                                                        <th scope="">{{ __('Survey Name') }}</th>
                                                        <th scope="">{{ __('Plan') }}</th>
                                                        <th scope="">{{ __('Survey Status') }}</th>
                                                        <th scope="">{{ __('Survey Date') }}</th>

                                                        <th colspan="3" scope="">{{ __('Survey
                                                            Actions') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($client_survyes as $survey)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $survey->SurveyTitle }}</td>
                                                        <td>{{ app()->getLocale()=='ar'?
                                                            $survey->plan->PlanTitleAr:$survey->plan->PlanTitle
                                                            }}</td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input"
                                                                    type="checkbox" role="switch"
                                                                    id="flexSwitchCheckChecked{{ $survey->id }}"
                                                                    {{ $survey->SurveyStat?
                                                                'checked':'' }}
                                                                onchange="ChangeCheck(this,'{{
                                                                $survey->id}}')" ><label
                                                                    class="form-check-label"
                                                                    for="flexSwitchCheckChecked{{ $survey->id }}">{{
                                                                    $survey->SurveyStat?'Active':'In-Active'
                                                                    }}</label>
                                                            </div>
                                                        </td>
                                                        <td>{{ $survey->created_at->format('d-m-Y')
                                                            }}</td>

                                                        <td><a href="{{ route('surveys.edit', $survey->id)}}"
                                                                class="edit btn btn-primary btn-sm m-1"><i
                                                                    class="fa fa-edit"></i></a></td>
                                                        <td>
                                                            <form
                                                                action="{{route('surveys.destroy', $survey->id)}}"
                                                                method="POST" class="delete_form"
                                                                style="display:inline"><input
                                                                    type="hidden" name="_method"
                                                                    value="DELETE">@csrf<button
                                                                    type="submit"
                                                                    class="btn btn-danger btn-sm m-1"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
@endsection
