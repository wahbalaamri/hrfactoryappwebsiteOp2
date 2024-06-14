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
                <!-- /.col -->
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Dashboard </li>
                        <li class="breadcrumb-item active">Manual Builder</li>
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
                            <h3 class="card-title">{{ __('Manage Manual Builder') }}</h3>
                            {{-- tool --}}
                            <div class="card-tools">
                                <a href="{{ route('termsCondition.index') }}"
                                    class="btn btn-sm btn-tool {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-4 col-sm-12">
                                    {{-- dragable items --}}
                                    <ul class="list-group">
                                        @foreach ($sections as $section )
                                        @php
                                        $children=$section->children()->get();
                                        @endphp
                                        <li class="list-group-item" data-ordering="{{ $section->ordering }}"
                                            data-id="{{ $section->id }}" onclick="ParentClicked(this)">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    @if(count($children)>0) <i
                                                        class="fa fa-plus text-success m-2"></i>@endif
                                                    {{ $section->title}}
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <a href="javascript:void(0)" class="btn btn-xs btn-warning"
                                                                onclick="ShowEdit({{ $section }})">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <a href="javascript:void(0)" class="btn btn-xs btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    @checked($section->IsActive)
                                                                id="customSwitch1">
                                                                <label class="custom-control-label"
                                                                    for="customSwitch1"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (count($children)>0)
                                            <ul class="list-group d-none">
                                                @foreach ($children as $child )
                                                <li class="list-group-item" data-ordering="{{ $child->ordering }}"
                                                    data-id="{{ $child->id }}">
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            {{ $child->title}}
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-warning"
                                                                        onclick="ShowEdit({{ $child }})">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-danger">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            @checked($child->IsActive)
                                                                        id="customSwitch1">
                                                                        <label class="custom-control-label"
                                                                            for="customSwitch1"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-md-8 col-sm-12"></div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>
    var darggeditem_ordering;
    var targgeted_ordering;
    var currentDraggedItem_id;
    var targgeted_id;
    document.addEventListener('DOMContentLoaded', function () {
            var nestedSortables = [].slice.call(document.querySelectorAll('.list-group'));

            nestedSortables.forEach(function (nestedSortable) {
                new Sortable(nestedSortable, {
                    group: {
                        name: 'nested',
                        pull: function (to, from, dragEl) {
                            return dragEl.parentNode === to.el; // Prevents dragging out of parent
                        },
                        put: false // Prevents items from being inserted into the parent
                    },
                    animation: 150,
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                    onStart: function (evt) {
                        currentDraggedItem = evt.item;
                        //get data-id of currentDraggedItem
                        currentDraggedItem_id = currentDraggedItem.getAttribute('data-id');
                        darggeditem_ordering = currentDraggedItem.getAttribute('data-ordering');
                    },
                    onEnd:function(evt){
                        var replacedItem = evt.to.children[evt.oldIndex];
                        //get data-id of currentDraggedItem
                        targgeted_id = replacedItem.getAttribute('data-id');
                        targgeted_ordering = replacedItem.getAttribute('data-ordering');
                        //swap ordering
                        replacedItem.setAttribute('data-ordering',darggeditem_ordering)
                        currentDraggedItem.setAttribute('data-ordering',targgeted_ordering)
                        //update order
                        updateOrder(evt.to);
                    }
                });
            });
            function updateOrder(container) {
                var items = container.children;
                var orderData = [];
                //get current item
                for (var i = 0; i < items.length; i++) {
                    var item = items[i];
                    orderData.push({
                        id: item.getAttribute('data-id'),
                        ordering: item.getAttribute('data-ordering')
                    });
                }
                //send ajax request
                $.ajax({
                    url: "{{ route('manualBuilder.reorder') }}",
                    type: 'POST',
                    data: {
                        orderData: orderData,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        console.log(response);
                    }
                });
            }
        });
    ParentClicked=(ctr)=>{
            //get ctr child of ul
            ul=$(ctr).children('ul');
          //find childeren with class fa
            row=$(ctr).find('.row');
            col=$(row).find('div');
            //find i_childeren
            i_element=$(col).children('i');
            if(ul.hasClass('d-none')){
                ul.removeClass('d-none');
                //change fa-plus to minuse
                i_element.removeClass('fa-plus');
                i_element.addClass('fa-minus');
                i_element.removeClass('text-success');
                i_element.addClass('text-warning');
            }else{
                ul.addClass('d-none');
                //change fa-minus to plus
                i_element.removeClass('fa-minus');
                i_element.addClass('fa-plus');
                i_element.addClass('text-success');
                i_element.removeClass('text-warning');
            }
        }
        ShowEdit=(section)=>{
            console.log(section);
        }
</script>
@endsection
