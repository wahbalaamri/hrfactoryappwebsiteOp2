@extends('dashboard.layouts.main')

@section('content')
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('services.index') }}">{{ __('Service')
                                }}</a> </li>
                        <li class="breadcrumb-item active">{{ __('Create') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div id="accordion">
                <div class="card card-lightblue">
                    <div class="card-header">
                        <h5 class="card-title">
                            <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                                {{ __('General information about: ') }}{{ $service->name }}
                            </a>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-sm-12 text-center">
                                    <img src="{{ asset('uploads/services/images/' . $service->service_media_path) }}"
                                        class="img-fluid img-size-64" alt="service image">
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <p class="card-text">
                                    <h4>{{ $service->name }}</h4>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <p class="card-text">
                                    <h4>{{ $service->name_ar }}</h4>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <p class="card-text">
                                    <h6>Slug</h6>{{ $service->slug }}</p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <p class="card-text">
                                    <h6>سلج</h6>{{ $service->slug_ar }}</p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <p class="card-text">
                                    <h6>Description</h6>{!! $service->description !!}</p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <p class="card-text">
                                    <h6>الوصف</h6>{!! $service->description_ar!!}</p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <h6>Objectives</h6>
                                    <p class="card-text"> @if(strlen($service->objective) > 0){!!
                                        $service->objective!!}@else
                                        Not Setted @endif</p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <h6>الأهداف</h6>
                                    <p class="card-text">@if(strlen($service->objective_ar) > 0){!!
                                        $service->objective_ar!!}
                                        @else لم يتم إدخاله @endif</p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <h6>Service Type</h6>
                                    <p class="card-text">{{ $service->service_type }}</p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <h6>{{ __('Country') }}</h6>
                                    <p class="card-text">{{ $service->country? $service->country->name: __("Not Setted")
                                        }}
                                    </p>
                                </div>
                                {{-- framwork media --}}
                                <div class="col-md-6 col-sm-12">
                                    <h6>{{ __('Framework Media') }}</h6>
                                    @if($service->FW_uploaded_video)
                                    <video width="320" height="240" controls>
                                        <source
                                            src="{{ asset('uploads/services/videos/' . $service->framework_media_path) }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    @else
                                    {{-- iframe for youtube --}}
                                    <iframe width="320" height="240" src="{{ $service->framework_media_path }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                    @endif
                                </div>
                                {{-- framwork media arabic--}}
                                <div class="col-md-6 col-sm-12">
                                    <h6>{{ __('Framework Media Arabic') }}</h6>
                                    @if($service->FW_uploaded_video_ar)
                                    <video width="320" height="240" controls>
                                        <source
                                            src="{{ asset('uploads/services/videos/' . $service->framework_media_path_ar) }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    @else
                                    {{-- iframe for youtube --}}
                                    <iframe width="320" height="240" src="{{ $service->framework_media_path }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- card for service feature --}}
                <div class="card card-lightblue">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-9 col-sm-12 text-start">
                                <h5 class="float-start card-title">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                                        {{ __('Service Features') }}
                                    </a>
                                </h5>
                            </div>
                            <div class="col-md-3 col-sm-12 text-right">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#addEditFeature"
                                    class="btn bg-olive btn-sm float-right"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion" style="">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="list-group list-group-horizontal-md row">
                                    @foreach ($service->features as $feature)
                                    <div class="list-group-item col-lg-3 mt-1 mb-1"
                                        ondblclick="showEdit('{{ $feature->id }}')">
                                        <h6>
                                            {{ $feature->feature }}
                                        </h6>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- card for service approaches --}}
                <div class="card card-lightblue">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-9 col-sm-12 text-start">
                                <h5 class="float-start card-title">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
                                        {{ __('Service Approaches') }}
                                    </a>
                                </h5>
                            </div>
                            <div class="col-md-3 col-sm-12 text-right">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#addEditApproach"
                                    class="btn bg-olive btn-sm float-right">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="collapseThree" class="collapse" data-parent="#accordion" style="">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                @foreach ( $service->approaches as $approache)
                                <div class="col-md-3 col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                {{-- image --}}
                                                <div class="col-12 text-center">
                                                    <img src="{{ asset('uploads/services/icons/' . $approache->icon) }}"
                                                        class="img-fluid img-size-64" alt="service image">
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- approach --}}
                                                <div class="col-12 text-center">
                                                    <h6>{!! $approache->approach !!}</h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- approach arabic --}}
                                                <div class="col-12 text-center">
                                                    <h6>{!! $approache->approach_ar !!}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                {{-- card for service plans --}}
                <div class="card card-lightblue">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-9 col-sm-12 text-start">
                                <h5 class="float-start card-title">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseFour">
                                        {{ __('Service Plans') }}
                                    </a>
                                </h5>
                            </div>
                            <div class="col-md-3 col-sm-12 text-right">
                                <a href="{{ route('service-plans.create', $service->id) }}"
                                    class="btn bg-olive btn-sm float-right">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="collapseFour" class="collapse" data-parent="#accordion" style="">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                @foreach ($service->plans as $plan)
                                <div class="col-md-4 col-sm-12">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="row">
                                                {{-- plan --}}
                                                <div class="col-sm-12 text-center">
                                                    <h6>{{ $plan->name }}</h6>
                                                </div>

                                                {{-- plan arabic --}}
                                                {{-- <div class="col-sm-12 text-center">
                                                    <h6>{{ $plan->name_ar }}</h6>
                                                </div> --}}
                                                {{-- delivery_mode --}}
                                                <div class="col-sm-12 text-center">
                                                    <h6>delivery mode</h6> {!! $plan->delivery_mode !!}
                                                </div>
                                                {{-- delivery_mode arabic --}}
                                                {{-- <div class="col-sm-12 text-center">
                                                    <h6>طريقة التوصيل</h6> {!! $plan->delivery_mode_ar !!}
                                                </div> --}}
                                                {{-- limitations --}}
                                                <div class="col-sm-12 text-center">
                                                    <h6>limitations</h6> {!! $plan->limitations !!}
                                                </div>
                                                {{-- limitations arabic --}}
                                                {{-- <div class="col-sm-12 text-center">
                                                    <h6>القيود</h6> {!! $plan->limitations_ar !!}
                                                </div> --}}
                                                {{-- download sample report --}}
                                                <div class="col-sm-12 text-center">
                                                    <a
                                                        href="{{ asset('uploads/services/sample_reports/') }}{{ $plan->sample_report }}"></a>
                                                </div>
                                                {{-- download sample report arabic --}}
                                                <div class="col-sm-12 text-center">
                                                    {{-- <a
                                                        href="{{ asset('uploads/services/sample_reports/') }}{{ $plan->sample_report_ar }}"></a>
                                                    --}}
                                                </div>
                                                {{-- features --}}
                                                <hr>
                                                <div class="col-sm-12 text-center">
                                                    {{-- <h6 class="">benefits</h6> --}}
                                                    <ul class="list-group" style="list-style-type: none">
                                                        @foreach ($service->features as $feature)
                                                        {{-- check if id in an array --}}
                                                        @if (in_array($feature->id, $plan->Features))
                                                        {{-- add tick --}}
                                                        <li><i class="fa fa-check text-success pr-2 pl-2"></i>{{
                                                            $feature->feature }}</li>
                                                        @else
                                                        {{-- add cross --}}
                                                        <li><i class="fa fa-times text-danger pr-2 pl-2"></i>
                                                        {{ $feature->feature }}</li>
                                                        @endif
                                                        @if(!$loop->last)
                                                        <hr>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <hr>
                                                {{-- price --}}
                                                <div class="col-sm-12 text-center">
                                                    {{-- <h6>price</h6> --}} {{
                                                    number_format(($plan->plansPrices->annual_price)/12,2) }}{{
                                                    $plan->plansPrices->currency_symbol }}/month
                                                </div>
                                                {{-- currncy --}}
                                                {{-- <div class="col-sm-12 text-center">
                                                    <h6>currency</h6> {{ $plan->currency }}
                                                </div> --}}
                                                {{-- country --}}
                                                {{-- <div class="col-sm-12 text-center">
                                                    <h6>country</h6> {{ $plan->plansPrices->Country->name }}
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
{{-- modal to add_edit feature --}}
<div class="modal fade" id="addEditFeature" tabindex="-1" aria-labelledby="addEditFeatureLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditFeatureLabel">Add Feature</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    {{-- featur in English --}}
                    <input type="hidden" name="Fid" id="Fid">
                    <input type="hidden" name="Sid" id="Sid" value="{{ $service->id }}">
                    <div class="form-group col-12">
                        <label for="feature">{{ __('Feature') }}</label>
                        <input type="text" name="feature" id="feature" class="form-control" placeholder="Feature">
                    </div>
                    {{-- featur in Arabic --}}
                    <div class="form-group col-12">
                        <label for="feature_ar">{{ __('Feature Arabic') }}</label>
                        <input type="text" name="feature_ar" id="feature_ar" class="form-control"
                            placeholder="Feature Arabic">
                    </div>
                    {{-- feature status --}}
                    <div class="form-group col-12">
                        <label for="status">{{ __('Status') }}</label>
                        {{-- switch --}}
                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input" id="status" checked>
                            <label class="custom-control-label" for="status">{{ __('Active') }}</label>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <a type="submit" class="btn btn-sm btn-success float-right" id="FeatureSave">{{ __('Save')
                            }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- modal to add_edit approach --}}
<div class="modal fade" id="addEditApproach" tabindex="-1" aria-labelledby="addEditApproachLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditApproachLabel">Add Approach
                </h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- form to add new approach --}}
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row p-2">
                        <input type="hidden" name="Sid" value="{{ $service->id }}">
                        <input type="hidden" name="Aid" value="">
                        {{-- approach in English --}}
                        <div class="form-group col-12">
                            <label for="approach">{{ __('Approach') }}</label>
                            <textarea name="approach" class="form-control summernote" placeholder="Approach"></textarea>
                        </div>
                        {{-- approach in Arabic --}}
                        <div class="form-group col-12">
                            <label for="approach_ar">{{ __('Approach Arabic') }}</label>
                            <textarea name="approach_ar" class="form-control summernote" placeholder="Approach Arabic"></textarea>
                        </div>
                        {{-- icon --}}
                        <div class="form-group col-12">
                            <label for="icon">{{ __('Icon') }}</label>
                            <input type="file" name="icon" class="form-control">
                        </div>
                        {{-- save button --}}
                        <div class="form-group col-12">
                            <a type="submit" class="btn btn-sm btn-success float-right" id="ApproachSave">{{ __('Save')
                                }}</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $('.summernote').summernote();
    //on status change
    $('#status').change(function () {
        if ($(this).is(':checked')) {
            $(this).next().text('Active');
        } else {
            $(this).next().text('In-Active');
        }
    });
    // on FeatureSave click
    $('#FeatureSave').click(function () {
        var feature = $('#feature').val();
        var feature_ar = $('#feature_ar').val();
        var status = $('#status').is(':checked') ? 1 : 0;
        var Sid = $('#Sid').val();
        var Fid = $('#Fid').val();
        var url = '';
        if (Fid) {
            url = "{{ route('service-features.update', ':id') }}";
            url = url.replace(':id', Fid);
        } else {
            url = "{{ route('service-features.store') }}";
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                feature: feature,
                feature_ar: feature_ar,
                status: status,
                service: Sid,
                _token: "{{ csrf_token() }}",
                _method: Fid ? 'PUT' : 'POST'
            },
            success: function (data) {
                if (data.status) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            }
        });
    });
    //on ApproachSave click
    $('#ApproachSave').click(function () {
        var approach = $('textarea[name="approach"]').val();
        var approach_ar = $('textarea[name="approach_ar"]').val();
        var icon = $('input[name="icon"]').prop('files')[0];
        var Sid = $('input[name="Sid"]').val();
        var Aid = $('input[name="Aid"]').val();
        var url = '';
        if (Aid) {
            url = "{{ route('service-approaches.update', ':id') }}";
            url = url.replace(':id', Aid);
        } else {
            url = "{{ route('service-approaches.store') }}";
        }
        var form_data = new FormData();
        form_data.append('approach', approach);
        form_data.append('approach_ar', approach_ar);
        form_data.append('icon', icon);
        form_data.append('service', Sid);
        form_data.append('_token', "{{ csrf_token() }}");
        form_data.append('_method', Aid ? 'PUT' : 'POST');
        $.ajax({
            url: url,
            type: 'POST',
            data: form_data,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.status) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            }
        });
    });
//on double click
function showEdit(id) {
    var url = "{{ route('service-features.edit', ':id') }}";
    url = url.replace(':id', id);
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            $('#Fid').val(data.id);
            $('#feature').val(data.feature);
            $('#feature_ar').val(data.feature_ar);
            if(data.is_active == 1){
                $('#status').prop('checked', true);
                $('#status').next().text('Active');
            }else{
                //remove checked
                $('#status').removeAttr('checked');
                $('#status').next().text('In-Active');
            }
            $('#addEditFeature').modal('show');
        }
    });
}
</script>
@endsection
