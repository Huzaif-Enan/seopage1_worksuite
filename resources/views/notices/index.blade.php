@extends('layouts.app')

@push('datatable-styles')
@include('sections.datatable_css')
@endpush

@section('filter-section')

<x-filters.filter-box>

    <!-- DATE START -->
    <div class="select-box d-flex pr-2 border-right-grey border-right-grey-sm-0">
        <p class="mb-0 pr-3 f-14 text-dark-grey d-flex align-items-center">@lang('app.date')</p>
        <div class="select-status d-flex">
            <input type="text"
                   class="position-relative text-dark form-control border-0 p-2 text-left f-14 f-w-500"
                   id="datatableRange"
                   placeholder="@lang('placeholders.dateRange')">
        </div>
    </div>
    <!-- DATE END -->

    <!-- SEARCH BY TASK START -->
    <div class="task-search d-flex  py-1 px-lg-3 px-0 border-right-grey align-items-center">
        <form class="w-100 mr-1 mr-lg-0 mr-md-1 ml-md-1 ml-0 ml-lg-0">
            <div class="input-group bg-grey rounded">
                <div class="input-group-prepend">
                    <span class="input-group-text border-0 bg-additional-grey">
                        <i class="fa fa-search f-13 text-dark-grey"></i>
                    </span>
                </div>
                <input type="text"
                       class="form-control f-14 p-1 border-additional-grey"
                       id="search-text-field"
                       placeholder="@lang('app.startTyping')">
            </div>
        </form>
    </div>
    <!-- SEARCH BY TASK END -->

    <!-- RESET START -->
    <div class="select-box d-flex py-1 px-lg-2 px-md-2 px-0">
        <x-forms.button-secondary class="btn-xs d-none"
                                  id="reset-filters"
                                  icon="times-circle">
            @lang('app.clearFilters')
        </x-forms.button-secondary>
    </div>
    <!-- RESET END -->
</x-filters.filter-box>

@endsection

@php
$addNoticePermission = user()->permission('add_notice');
@endphp

@section('content')
<!-- CONTENT WRAPPER START -->
<div class="content-wrapper">
    <!-- Add Task Export Buttons Start -->
    <div class="d-flex justify-content-between action-bar">
        <div id="table-actions"
             class="flex-grow-1 align-items-center mt-3">
            @if ($addNoticePermission == 'all' || $addNoticePermission == 'added')
            <x-forms.link-primary :link="route('notices.create')"
                                  class="mr-3 openRightModal float-left"
                                  icon="plus">
                @lang('modules.notices.addNotice')
            </x-forms.link-primary>
            @endif
        </div>

        @if (!in_array('client', user_roles()))
        <x-datatable.actions>
            <div class="select-status mr-3 pl-3">
                <select name="action_type"
                        class="form-control select-picker"
                        id="quick-action-type"
                        disabled>
                    <option value="">@lang('app.selectAction')</option>
                    <option value="delete">@lang('app.delete')</option>
                </select>
            </div>
        </x-datatable.actions>
        @endif

    </div>
    <!-- Add Task Export Buttons End -->
    <!-- Task Box Start -->
    <div class="d-flex flex-column w-tables rounded mt-3 bg-white">

        {!! $dataTable->table(['class' => 'table table-hover border-0 w-100']) !!}

    </div>
    <!-- Task Box End -->
</div>
<!-- CONTENT WRAPPER END -->


<!-- Your HTML structure for displaying the delayed projects -->
<div class="container">
    @foreach ($delayedProjects as $project)
    @if($project->status=='pending')
    <div class="project">
        {{-- <p><b>PM ID:</b> {{ $project->pm_id }}</p>
        <p><b>Project ID:</b>{{ $project->project_id }}</p> --}}
        <p><b>Project Manager Name:</b> {{ $project->manager_name }}</p>
        <p><b>Client Name:</b> {{ $project->client_name }}</p>
        <p><b>Project Name:</b> {{ $project->project_name }}</p>
        <p><b>Reason:</b> {{ $project->pm_text }}</p>
        <p><b>Extended Days:</b> {{ $project->extra_time }}</p>
        <!-- Display the images -->
        @foreach ($project->pm_file as $image)
        <a data-fancybox="gallery"
           href="{{ asset('uploads/' . $image) }}">
            <img src="{{ asset('uploads/' . $image) }}"
                 alt="Project Image"
                 style="max-width: 250px;">
        </a>

        @endforeach
        <br><br>
        <!-- Comment box -->
        <textarea name="comment"
                  class="comment-box"
                  rows="6"
                  placeholder="Enter your comment"></textarea>

        <!-- Approve and Decline buttons --><br>
        <button class="btn btn-success approve-btn"
                data-project-id="{{ $project->id }}">Approve</button>

        <button class="btn btn-danger decline-btn"
                data-project-id="{{ $project->id }}">Decline</button>
    </div>
    @endif
    <br>
    @endforeach
</div>
<!-- Add JavaScript for handling the approve and decline buttons -->


@endsection

@push('scripts')
@include('sections.datatable_js')


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
{{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> --}}

<!-- resources/views/admin_view.blade.php -->

<script>
    $(document).ready(function() {
        // Attach click event to the approve buttons
        $('.approve-btn').on('click', function() {
            var projectId = $(this).data('project-id');
            var comment = $(this).siblings('.comment-box').val();
          //  console.log('Project ID:', projectId);
            // console.log('Comment:', comment);


            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
               // url: '/project-extend-approval', // Replace with your actual update endpoint URL
               url:"{{route("dashboard.projectExtendApproval")}}",
                method: 'POST',
                data: {
                   // '_token': '{{ csrf_token() }}',
                    'id': projectId,
                    'status': 'approved',
                    'comment': comment
                },
                success: function(response) {
                   $('.approve-btn[data-project-id="' + projectId + '"]').hide();
                $('.decline-btn[data-project-id="' + projectId + '"]').hide();
                 
                },
               
            });
        });

        // Attach click event to the decline buttons
        $('.decline-btn').on('click', function() {
            var projectId = $(this).data('project-id');
            var comment = $(this).siblings('.comment-box').val();

            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
          
            // Send an AJAX request to update the status and comment in the database
            $.ajax({
              //  url: '/project-extend-approval', // Replace with your actual update endpoint URL
                url:"{{route("dashboard.projectExtendApproval")}}",
                method: 'POST',
                data: {
                  // '_token': '{{ csrf_token() }}',
                    'id': projectId,
                    'status': 'declined',
                    'comment': comment
                },
                success: function(response) {
                    $('.approve-btn[data-project-id="' + projectId + '"]').hide();
                    $('.decline-btn[data-project-id="' + projectId + '"]').hide();
                  
                },
               
            });
        });
    });
</script>

{{--
<script>
    $("#delayRequestForm").submit(function(e){
            e.preventDefault();
            const formElement = document.getElementById('delayRequestForm');
            const formData = new FormData(formElement);
           // var formData  = new FormData(jQuery('#delayRequestForm')[0]);
            console.log(formData);
            $.ajax({
                url:"{{route("dashboard.delayRequestForm")}}",
                type:'POST',
                data:formData,
                contentType:false,
                processData:false,
                success:function(data)
                {
                   
                    
                },
            })


        });
    
    
</script> --}}

{{-- <script>
    $('#notice-board-table').on('preXhr.dt', function(e, settings, data) {

            var dateRangePicker = $('#datatableRange').data('daterangepicker');
            var startDate = $('#datatableRange').val();

            if (startDate == '') {
                startDate = null;
                endDate = null;
            } else {
                startDate = dateRangePicker.startDate.format('{{ global_setting()->moment_date_format }}');
                endDate = dateRangePicker.endDate.format('{{ global_setting()->moment_date_format }}');
            }

            var searchText = $('#search-text-field').val();

            data['startDate'] = startDate;
            data['endDate'] = endDate;
            data['searchText'] = searchText;
        });
        const showTable = () => {
            window.LaravelDataTables["notice-board-table"].draw();
        }

        $('#search-text-field').on('change keyup', function() {
            if ($('#search-text-field').val() != "") {
                $('#reset-filters').removeClass('d-none');
                showTable();
            } else {
                $('#reset-filters').addClass('d-none');
                showTable();
            }
        });

        $('#reset-filters').click(function() {
            $('#filter-form')[0].reset();
            $('.select-picker').val('all');

            $('.select-picker').selectpicker("refresh");
            $('#reset-filters').addClass('d-none');

            showTable();
        });

        $('#quick-action-type').change(function() {
            const actionValue = $(this).val();
            if (actionValue != '') {
                $('#quick-action-apply').removeAttr('disabled');
            } else {
                $('#quick-action-apply').attr('disabled', true);
            }
        });

        $('#quick-action-apply').click(function() {
            const actionValue = $('#quick-action-type').val();
            if (actionValue == 'delete') {
                Swal.fire({
                    title: "@lang('messages.sweetAlertTitle')",
                    text: "@lang('messages.recoverRecord')",
                    icon: 'warning',
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText: "@lang('messages.confirmDelete')",
                    cancelButtonText: "@lang('app.cancel')",
                    customClass: {
                        confirmButton: 'btn btn-primary mr-3',
                        cancelButton: 'btn btn-secondary'
                    },
                    showClass: {
                        popup: 'swal2-noanimation',
                        backdrop: 'swal2-noanimation'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        applyQuickAction();
                    }
                });

            } else {
                applyQuickAction();
            }
        });

        const applyQuickAction = () => {
            var rowdIds = $("#notice-board-table input:checkbox:checked").map(function() {
                return $(this).val();
            }).get();

            var url = "{{ route('notices.apply_quick_action') }}?row_ids=" + rowdIds;

            $.easyAjax({
                url: url,
                container: '#quick-action-form',
                type: "POST",
                disableButton: true,
                buttonSelector: "#quick-action-apply",
                data: $('#quick-action-form').serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        showTable();
                        resetActionButtons();
                        deSelectAll();
                    }
                }
            })
        };

        $('body').on('click', '.delete-table-row', function() {
            var id = $(this).data('user-id');
            Swal.fire({
                title: "@lang('messages.sweetAlertTitle')",
                text: "@lang('messages.recoverRecord')",
                icon: 'warning',
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: "@lang('messages.confirmDelete')",
                cancelButtonText: "@lang('app.cancel')",
                customClass: {
                    confirmButton: 'btn btn-primary mr-3',
                    cancelButton: 'btn btn-secondary'
                },
                showClass: {
                    popup: 'swal2-noanimation',
                    backdrop: 'swal2-noanimation'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('notices.destroy', ':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {
                            '_token': token,
                            '_method': 'DELETE'
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                showTable();
                            }
                        }
                    });
                }
            });
        });

        $('body').on('click', '.noticeView', function() {
            let id = $(this).data('notice-id');

            var url = "{{ route('notices.show', ':id') }}";
            url = url.replace(':id', id);

            $(MODAL_XL + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_XL, url);
        });
</script> --}}
@endpush