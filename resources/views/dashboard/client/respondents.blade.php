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
                    <h1 class="m-0">{{ __('Employees') }}</h1>
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
                            <h3 class="card-title">{{ __('Manage Your Employees') }}</h3>
                            {{-- tool --}}
                            <div class="card-tools">
                                {{-- back --}}
                                <a href="{{ route('clients.surveyDetails',[$id,$type,$survey->id])}}"
                                    class="btn btn-sm btn-tool {{ App()->getLocale()=='ar'? 'float-start':'float-end' }}">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="Employee-data"
                                    class="table table-hover table-striped table-bordered text-center text-sm">
                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>{{__('Respondents')}}</th>
                                            <th>{{__('Employee Name')}}</th>
                                            <th>{{__('Email')}}</th>
                                            <th>{{__('Phone')}}</th>
                                            <th>{{__('Position')}}</th>
                                            {{-- <th>{{__('HR Manager?')}}</th>
                                            <th>{{__('Actions')}}</th>
                                            <th>{{__('Send Survey')}}</th>
                                            <th>{{__('Send Reminder')}}</th>
                                            <th>{{__('Raters')}}</th> --}}
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <td colspan=""></td>
                                            <td>
                                                {{-- button to read ids --}}
                                                <a href="javascript:void(0)" onclick="SetAsRespondent()"
                                                    class="btn btn-sm btn-primary" id="read-all">
                                                    {{__('Save')}}
                                                </a>
                                            </td>
                                            <td colspan=""></td>
                                            <td colspan=""></td>
                                            <td colspan=""></td>
                                            {{-- <td colspan=""></td>
                                            <td colspan=""></td>
                                            <td colspan=""></td>
                                            <td colspan=""></td>
                                            <td colspan=""></td> --}}
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
            type="{{$type}}";
            url="{{ route('clients.Respondents',[':d',':type',':survey']) }}";
            url=url.replace(':d',"{{$id}}");
            url=url.replace(':type',"{{$type}}");
            url=url.replace(':survey',"{{$survey->id}}");
            console.log(url);
            $('#Employee-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: url,
                columns:[
                    {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false,
                    "render": function (data, type, row) {
                        return '<button class="btn btn-xs btn-success mr-3 ml-3 text-xs show-more" data-id="' + data.id + '"><i class="fa fa-eye"></i></button>'+data;}},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'mobile', name: 'mobile'},
                    {data: 'position', name: 'position'},
                    // {data: 'hr', name: 'hr'},
                    // {data: 'action', name: 'action', orderable: false, searchable: false},
                    // {data: 'SendSurvey', name: 'SendSurvey', orderable: false, searchable: false},
                    // {data: 'SendReminder', name: 'SendReminder', orderable: false, searchable: false},
                    // {data: 'raters', name: 'raters', orderable: false, searchable: false},
                ],
                "columnDefs": [
            {
                "targets": 1,
                "render": function(data, type, row) {
                    if(row.isAddAsRespondent == true)
                    {
                        return '<input type="checkbox" class="row-select" value="' + row.id + '" checked><label class="form-check-label" for="exampleCheck1">Selected as Respondent</label>';
                    }
                    else{
                    return '<input type="checkbox" class="row-select" value="' + row.id + '"><label class="form-check-label" for="exampleCheck1">Add as Respondent</label>';
                    }
                }
            }
        ],
                "drawCallback": function(settings) {
            var api = this.api();
            api.rows().every(function() {
                var data = this.data();
                if (data.service_type != 5) {
                    // Remove the 3rd column (index 2) if the status is 'inactive'
                    $('#Employee-data').DataTable().column(10).visible(false);
                }
                else{
                    $('#Employee-data').DataTable().column(8).visible(false);
                    $('#Employee-data').DataTable().column(9).visible(false);
                }
            });
        }
            });
            //====================================================
            var table = $('#Employee-data').DataTable();
            // Add a button to each row that, when clicked, shows the additional info div
$('#Employee-data tbody').on('click', 'button.show-more', function () {
    var service="{{ $survey_type }}";
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data = row.data();
    if (row.child.isShown()) {
        // This row is already open - close it
        this.innerHTML = '<i class="fa fa-eye"></i>';
        //change button color
        this.classList.remove('btn-danger');
        this.classList.add('btn-success');
        row.child.hide('slow');
        tr.removeClass('shown');
    } else {
        this.innerHTML = '<i class="fa fa-eye-slash"></i>';
        //change button color
        this.classList.remove('btn-success');
        this.classList.add('btn-danger');
        // Open this row
        row_data='<div class="details-div"><table class="table table-striped-columns"><tr><th>'
            +"{{__('HR Manager?')}}"+'</th><th>'+"{{__('Actions')}}"+
                '</th>'
                if(service!=5){
                    row_data+='<th>'+"{{__('Send Survey')}}"+'</th><th>'
                        +"{{__('Send Reminder')}}"+'</th>'
                }
                if(service==5){
        row_data+='<th>'+"{{__('Raters')}}"+'</th>'
                }
        row_data+='</tr><tr><td>'
            +data['hr']+'</td><td>'+data['action']+'</td>'
            if(service!=5){
                row_data+='<td>'+data['SendSurvey']+'</td><td>'
                    +data['SendReminder']+'</td>';
            }
            if(service==5){
                row_data+='<td>'+data['raters']+'</td>'
            }
                row_data+='</tr></table></div>';
        row.child(row_data).show('slow');
        tr.addClass('shown');
    }
});
            //  Employee-data width 100%
            $('#Employee-data').css('width','100%');
            SetAsRespondent=()=>{
                var ids = [];
                $('.row-select:checked').each(function() {
                    ids.push($(this).val());
                });
                if(ids.length>0){
                    $.ajax({
                        url: "{{ route('clients.saveSurveyRespondents') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "ids": ids,
                            "survey": "{{$survey_id}}",
                            "type": "{{$type}}",
                            "client": "{{$id}}"
                        },
                        success: function(data) {
                            if (data.status) {
                                toastr.success(data.message);
                                $('#Employee-data').DataTable().ajax.reload();
                            }
                            if (!data.status) {
                               console.log(data);
                            }
                        }
                    });
                }
                else{
                    toastr.error("Please select at least one Employee");
                }
            }
        });
</script>
@endsection
