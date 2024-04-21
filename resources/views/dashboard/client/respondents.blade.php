{{-- extends --}}
@extends('dashboard.layouts.main')
@section('styles')
{{-- css file --}}
<link rel="stylesheet" href="{{ asset('assets/css/treeView.css') }}">
@endsection
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
                            <h3 class="card-title">{{ __('Show Survey Details') }}</h3>
                            {{-- tool --}}
                            <div class="card-tools">
                                {{-- back --}}
                                <a href="{{ route('clients.ShowSurveys',[$id,$type]) }}"
                                    class="btn btn-sm btn-primary {{ App()->getLocale()=='ar'? 'float-start':'float-end' }}">{{
                                    __('Back') }}</a>
                                {{-- create new survey --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <ul class="tree">
                                        <li class="super-parent">
                                        <details>
                                            <summary>{{__('Client Name:')}} {{  $client->name }}</summary>
                                            <ul class="tree3">
                                                @foreach ($client->sectors as $sector)
                                                     <li class="parent">
                                                    <details>
                                                        <summary>{{__('Sector Name:')}} {{ $sector->name_en }}</summary>
                                                        <ul>
                                                            @foreach ($sector->companies as $company)
                                                                 <li @if(!$client->use_sections) ondblclick="ShowRespondents('{{ $company->id }}')" @endif>
                                                                    @if($client->use_sections && $company->departments->count()>0)
                                                                <details>
                                                                    <summary>{{__('Company Name:')}} {{ $company->name_en }}</summary>
                                                                    <ul>
                                                                        @foreach ($company->departments->where('parent_id',null) as $department)
                                                                             <li ondblclick="ShowRespondents('{{ $department->id }}')">
                                                                                @if($department->subDepartments->count()>0)

                                                                            <details>
                                                                                <summary><span class="m-1 p-1 bg-success"> {{ $department->name_en }} <i class="fa fa-user-plus"></i></span></summary>
                                                                                @include('dashboard.client.subDepartments',['subDepartments'=>$department->subDepartments])
                                                                            </details>
                                                                            @else
                                                                            <span class="m-1 p-1 bg-success"> {{ $department->name_en }} <i class="fa fa-user-plus"></i></span>
                                                                            @endif
                                                                        </li>
                                                                        @endforeach
                                                                        <li><a href="javascript:void(0)" onclick="ShowAdd('{{ $client->id }}','{{ $department->id }}','sub-dep')" class="btn btn-sm btn-info">{{ __('Add Sub-Department') }}</a></li>
                                                                    </ul>
                                                                </details>
                                                                @else
                                                                {{__('Company Name:')}} {{ $company->name_en }}
                                                                @endif
                                                            </li>
                                                            @endforeach
                                                            <li>
                                                                <div class="row">
                                                                    <div class="col-6 text-center"><a href="javascript:void(0)" onclick="ShowAdd('{{ $client->id }}','{{ $sector->id }}','comp')"  class="btn btn-sm btn-success">{{ __('Add Company') }}</a></div>
                                                                    @if($company->departments->count()==0 && $client->use_sections && $sector->companies->count()>0)
                                                                    <div class="col-6 text-center"><a href="javascript:void(0)" onclick="ShowAdd('{{ $client->id }}','{{ $company->id }}','dep')" class="btn btn-sm btn-warning">{{ __('Add Department') }}</a></div>
                                                                    @endif
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </details>
                                                </li>
                                                @endforeach
                                                <li><a href="javascript:void(0)" onclick="ShowAdd('{{ $client->id }}','{{ $sector->id }}','sector')"  class="btn btn-sm btn-primary">{{ __('Add Sector') }}</a></li>
                                            </ul>
                                        </details>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
{{-- -modal to create new sector --}}
@include('dashboard.client.modals.addSector')
{{-- -modal to create new company --}}
@endsection
@section('scripts')
{{-- js file --}}
    <script>
        function ShowRespondents(id) {
            alert(id);
        }
        function ShowAdd(client_id,sector_id,type) {
            if(type=='sector'){
                isArabic = '{{ App()->getLocale() == 'ar' }}';
                options = null;
                

                $("#AddNewSecCompDepLabel").text("{{ __('Add New Sector') }}");
                $("#AddNewSecCompDep .modal-body").html(`
                    <form action="" method="POST">
                        <input type="hidden" name="client_id" value="${client_id}">
                        <input type="hidden" name="type" value="${type}">
                        <div class="form-group col-12">
                            <label for="sector_id">{{ __('Select Sector') }}</label>
                            <select name="sector_id" id="Selector_Sector" class="form-control" required onchange="selectedSector()"></select>
                        </div>
                        <div id="addNewSector" class="d-none">
                            <div class="form-group col-12">
                            <label for="name_en">{{ __('Sector Name') }} (EN)</label>
                            <input type="text" name="name_en" class="form-control">
                        </div>
                        <div class="form-group col-12">
                            <label for="name_ar">{{ __('Sector Name') }} (AR)</label>
                            <input type="text" name="name_ar" class="form-control">
                        </div>
                        </div>
                        <div class="form-group col-12">
                            <a href="javascript:void(0)" onclick="saveSCD(this)" class="btn btn-primary">{{ __('Save') }}</a>
                        </div>
                    </form>
                `);
                //get all indusrties
                //setup url
                url = "{{ route('industries.all',':id') }}";
                url = url.replace(':id',client_id);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        option = '<option value="">{{ __('Select Sector') }}</option>';
                        options+=option;
                        data.forEach(function(industry) {
                            option = '<option value="'+industry.id+'">'+(isArabic?industry.name_ar:industry.name)+'</option>';
                            options+=option;
                        });
                        //.push other as last option to options
                        options+='<option value="other">{{ __('Other') }}</option>';
                        //append options to selector
                        $("#Selector_Sector").html(options);
                    }
                });
                $('#Selector_Sector').select2(
                );
                $('.select2-container ').css('width','100%');
            }else if(type=='comp'){
                $("#AddNewSecCompDepLabel").text("{{ __('Add New Company') }}");
                $("#AddNewSecCompDep .modal-body").html(`
                    <form action="" method="POST">
                        <input type="hidden" name="client_id" value="${client_id}">
                        <input type="hidden" name="type" value="${type}">
                        <input type="hidden" name="sector_id" value="${sector_id}">
                        <div class="form-group col-12">
                            <label for="name_en">{{ __('Company Name') }} (EN)</label>
                            <input type="text" name="name_en" class="form-control" required>
                        </div>
                        <div class="form-group col-12">
                            <label for="name_ar">{{ __('Company Name') }} (AR)</label>
                            <input type="text" name="name_ar" class="form-control" required>
                        </div>
                        <div class="form-group
                        col-12">
                            <a href="javascript:void(0)" onclick="saveSCD(this)" class="btn btn-primary">{{ __('Save') }}</a>
                        </div>
                    </form>
                `);
            }else if(type=='dep'){
                $("#AddNewSecCompDepLabel").text("{{ __('Add New Department') }}");
                $("#AddNewSecCompDep .modal-body").html(`
                    <form action="" method="POST">
                        <input type="hidden" name="client_id" value="${client_id}">
                        <input type="hidden" name="type" value="${type}">
                        <input type="hidden" name="company_id" value="${sector_id}">
                        <div class="form-group col-12">
                            <label for="name_en">{{ __('Department Name') }} (EN)</label>
                            <input type="text" name="name_en" class="form-control" required>
                        </div>
                        <div class="form-group
                        col-12">
                            <label for="name_ar">{{ __('Department Name') }} (AR)</label>
                            <input type="text" name="name_ar" class="form-control" required>
                        </div>
                        <div class="form-group col-12">
                            <a href="javascript:void(0)" onclick="saveSCD(this)" class="btn btn-primary">{{ __('Save') }}</a>
                        </div>
                    </form>
                `);
            }else if(type=='sub-dep'){
                $("#AddNewSecCompDepLabel").text("{{ __('Add New Sub-Department') }}");
                $("#AddNewSecCompDep .modal-body").html(`
                    <form action="" method="POST">
                        <input type="hidden" name="client_id" value="${client_id}">
                        <input type="hidden" name="type" value="${type}">
                        <input type="hidden" name="department_id" value="${sector_id}">
                        <div class="form-group col-12">
                            <label for="name_en">{{ __('Sub-Department Name') }} (EN)</label>
                            <input type="text" name="name_en" class="form-control" required>
                        </div>
                        <div class="form-group col-12">
                            <label for="name_ar">{{ __('Sub-Department Name') }} (AR)</label>
                            <input type="text" name="name_ar" class="form-control" required>
                        </div>
                        <div class="form-group col-12">
                            <a href="javascript:void(0)" onclick="saveSCD(this)" class="btn btn-primary">{{ __('Save') }}</a>
                        </div>
                    </form>
                `);
            }
            $('#AddNewSecCompDep').modal('show');
        }
        selectedSector=()=>{
            if($('#Selector_Sector').val()=='other'){
                $('#addNewSector').removeClass('d-none');
            }else{
                $('#addNewSector').addClass('d-none');
            }
        }
        function saveSCD(button){
            //get type
            form=button.parentElement.parentElement;
            type = form.type.value;
            PostedData=[null];
           if(type=='sector'){
                //get sector_id
                sector_id = form.sector_id.value;
                if(sector_id=='other' && (form.name_en.value=='' || form.name_ar.value=='')){
                    alert('Please enter sector name');
                    return;
                    
                }
                if(sector_id==''){
                    alert('Please select sector');
                    return;
                }
                //build data
                client_id=form.client_id.value;
                    type=form.type.value;
                    _id=sector_id;
                    name_en=form.name_en.value;
                    name_ar=form.name_ar.value;
            }
            else if(type=='comp'){
                //get sector_id
                sector_id = form.sector_id.value;
                client_id=form.client_id.value;
                    type=form.type.value;
                    _id=sector_id;
                    name_en=form.name_en.value;
                    name_ar=form.name_ar.value;
              
            }
            else if(type=='dep'){
                //get company_id
                company_id = form.company_id.value;
                //build data
                client_id=form.client_id.value;
                    type=form.type.value;
                    _id=company_id;
                    name_en=form.name_en.value;
                    name_ar=form.name_ar.value;
            }
            else if(type=='sub-dep'){
                //get department_id
                department_id = form.department_id.value;
                //build data
                client_id=form.client_id.value;
                    type=form.type.value;
                    _id=department_id;
                    name_en=form.name_en.value;
                    name_ar=form.name_ar.value;
                
            }
            //setup url
            data = {
                    '_token':"{{ csrf_token() }}",
                    'client_id':client_id,
                    'type':type,
                    '_id':_id,
                    'name_en':name_en,
                    'name_ar':name_ar
                };
            url = "{{ route('clients.saveSCD') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data:data,
                success: function(data) {
                  console.log(data);
                },
                error: function(data) {
                    console.log(data); 
                }
            });
        }
    </script>
@endsection