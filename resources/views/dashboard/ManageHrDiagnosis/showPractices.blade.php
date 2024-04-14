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
                            <h3 class="card-title">{{ __('Function Practices') }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('ManageHrDiagnosis.index') }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                {{-- button to add new practice --}}
                                <a href="{{ route('ManageHrDiagnosis.createPractice',$function->id) }}"
                                    class="btn btn-secondary btn-sm">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        {{-- card body --}}
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Practice Title') }}</th>
                                            <th>{{ __('Question') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($function->practices)>0)
                                        @foreach($function->practices as $practice)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $practice->title }}</td>
                                            <td>
                                                {{-- button to view questions --}}
                                                <a href="{{ route('ManageHrDiagnosis.showQuestions',$practice->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> {{ __('View Questions') }}</a>

                                            </td>
                                            <td>
                                                <div class="row">
                                                    {{-- button to edit practice --}}
                                                    <a href="{{ route('ManageHrDiagnosis.editPractice',$practice->id) }}"
                                                        class="btn btn-warning btn-sm m-1">
                                                        <i class="fa fa-edit text-xs"></i>
                                                    </a>
                                                    {{-- button to show sweetalert to confirm delete practice --}}
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="deletePractice({{ $practice->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    {{-- button to delete practice --}}
                                                    <form
                                                        action="{{ route('ManageHrDiagnosis.destroyPractice',$practice->id)}}"
                                                        method="POST" id="destroyPractice{{ $practice->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr class="text-center">
                                            <td colspan="4">{{ __('No Practices Found') }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        //deletePractice
        function deletePractice(id) {
            //show sweetalert to confirm delete
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this practice!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    //submit form
                    document.getElementById('destroyPractice' + id).submit();
                }
            })
        }
    </script>
@endsection
