@extends('layouts.app')
@push('styles')
    <style>
        .tooltip-arrow,
        .red-tooltip+.tooltip>.tooltip-inner {
            background-color: #fff;
        }

        .won_deal_btn_primary {
            padding: 6px 8px;
        }
    </style>
@endpush
@push('datatable-styles')
    @include('sections.datatable_css')
@endpush

@section('filter-section')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <x-filters.filter-box>
        <!-- DATE START -->
        <div class="select-box d-flex pr-2 border-right-grey border-right-grey-sm-0">
            <p class="mb-0 pr-3 f-14 text-dark-grey d-flex align-items-center">@lang('app.date')</p>
            <div class="select-status d-flex">
                <input type="text" class="position-relative text-dark form-control border-0 p-2 text-left f-14 f-w-500"
                    id="datatableRange" placeholder="@lang('placeholders.dateRange')">
            </div>
        </div>

        <div class="task-search d-flex  py-1 px-lg-3 px-0 border-right-grey align-items-center">
            <form class="w-100 mr-1 mr-lg-0 mr-md-1 ml-md-1 ml-0 ml-lg-0">
                <div class="input-group bg-grey rounded">
                    <div class="input-group-prepend">
                        <span class="input-group-text border-0 bg-additional-grey">
                            <i class="fa fa-search f-13 text-dark-grey"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control f-14 p-1 border-additional-grey" id="search-text-field"
                        placeholder="@lang('app.startTyping')">
                </div>
            </form>
        </div>

        <div
            class="select-box d-flex py-2 {{ !in_array('client', user_roles()) ? 'px-lg-2 px-md-2 px-0' : '' }}  border-right-grey border-right-grey-sm-0">
            <p class="mb-0 pr-3 f-14 text-dark-grey d-flex align-items-center">@lang('Project Manager')</p>
            <div class="select-status">
                <select class="form-control select-picker" name="pm_id" id="pm_id" data-live-search="true"
                    data-size="8">
                    <option selected value="all">@lang('All PM')</option>
                    @php
                        $project_manager = App\Models\User::where('role_id', '4')->get();
                    @endphp
                    @foreach ($project_manager as $value)
                        <option value="{{ $value->id }}">{{ ucfirst($value->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div
            class="select-box d-flex py-2 {{ !in_array('client', user_roles()) ? 'px-lg-2 px-md-2 px-0' : '' }}  border-right-grey border-right-grey-sm-0">
            <p class="mb-0 pr-3 f-14 text-dark-grey d-flex align-items-center">@lang('app.clientName')</p>
            <div class="select-status">
                <select class="form-control select-picker" name="client_id" id="client_id" data-live-search="true"
                    data-size="8">
                    @if (!in_array('client', user_roles()))
                        <option value="all">@lang('app.all')</option>
                    @endif
                    @foreach ($clients as $client)
                        <option
                            data-content="<div class='d-inline-block mr-1'><img class='taskEmployeeImg rounded-circle' src='{{ $client->image_url }}' ></div> {{ ucfirst($client->name) }}"
                            value="{{ $client->id }}">{{ ucfirst($client->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div
            class="select-box d-flex py-2 {{ !in_array('client', user_roles()) ? 'px-lg-2 px-md-2 px-0' : '' }}  border-right-grey border-right-grey-sm-0">
            <p class="mb-0 pr-3 f-14 text-dark-grey d-flex align-items-center">@lang('Closed By')</p>
            <div class="select-status">
                <select class="form-control select-picker" name="closed_by" id="closed_by" data-live-search="true"
                    data-size="8">
                    <option selected value="all">@lang('All')</option>
                    @php
                        $project_manager = App\Models\User::whereIn('role_id', ['1', '7', '8'])->get();
                    @endphp
                    @foreach ($project_manager as $value)
                        <option value="{{ $value->id }}">{{ ucfirst($value->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- SEARCH BY TASK END -->

        <!-- RESET START -->
        <div class="select-box d-flex py-1 px-lg-2 px-md-2 px-0">
            <x-forms.button-secondary class="btn-xs d-none" id="reset-filters" icon="times-circle">
                @lang('app.clearFilters')
            </x-forms.button-secondary>
        </div>
        <!-- RESET END -->
    </x-filters.filter-box>
@endsection

@php
    $addContractPermission = user()->permission('add_contract');
    $manageContractTemplatePermission = user()->permission('manage_contract_template');
    
@endphp

@section('content')
    <!-- CONTENT WRAPPER START -->
    <div class="content-wrapper">
        <!-- Add Task Export Buttons Start -->
        <div class="d-flex justify-content-between action-bar">

            <div id="table-actions" class="d-flex align-items-center">
                @if ($addContractPermission == 'all' || $addContractPermission == 'added')
                    @if (Auth::user()->role_id == 1)
                        <button class="btn btn-primary mr-3 won_deal_btn_primary" id="deal-add">
                            <i class="fa-solid fa-plus"></i><span> Create Won Deal</span>
                        </button>
                        @include('contracts.modals.dealaddmodal')
                        @php
                            $total_request = App\Models\AwardTimeIncress::where('status', '0')->count();
                        @endphp
                        <a class="border-secondary btn btn-warning mr-3" href="{{ route('award_time_check.index') }}">
                            <i class="fa fa-clock"></i>
                            Incress Award Time Request
                            @if ($total_request > 0)
                                <span class="badge badge-primary">{{ $total_request }}</span>
                            @endif
                        </a>
                    @endif
                @endif
            </div>
        </div>

        <!-- Add Task Export Buttons End -->

        <!-- Task Box Start -->
        <div class="d-flex flex-column w-tables rounded mt-3 bg-white">
            {!! $dataTable->table(['class' => 'table table-hover border-0 w-100']) !!}
        </div>
        <!-- Task Box End -->
    </div>
    <!-- CONTENT WRAPPER END -->

    <div class="modal fade" id="award_time_incress_modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Award Time Extention</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="task_id">
                    <div class="form-group">
                        <label for="hours">Select Hours</label>
                        <select name="hours" id="task_hours" class="form-control">
                            <option value="">Select Hours</option>
                            <option value="2">2 Hours</option>
                            <option value="4">4 Hours</option>
                            <option value="10">10 Hours</option>
                            <option value="20">20 Hours</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="descripton" id="task_description" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="award_time_incress_submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    @include('sections.datatable_js')

    <script>
        $('#Wondeals-table').on('preXhr.dt', function(e, settings, data) {
            var dateRangePicker = $('#datatableRange').data('daterangepicker');
            var startDate = $('#datatableRange').val();
            var clientID = $('#client_id').val();
            var pm_id = $('#pm_id').val();
            var closed_by = $('#closed_by').val();

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
            data['client_id'] = clientID;
            data['pm_id'] = pm_id;
            data['closed_by'] = closed_by;

            data['searchText'] = searchText;
            //console.log(searchText);
        });
        const showTable = () => {
            window.LaravelDataTables["Wondeals-table"].draw();
        }

        $('#pm_id, #client_id, #closed_by, #search-text-field').on('change keyup', function() {
            if ($('#client_id').val() != "all") {
                $('#reset-filters').removeClass('d-none');
                showTable();
            } else if ($('#pm_id').val() != "all") {
                $('#reset-filters').removeClass('d-none');
                showTable();
            } else if ($('#project_link').val() != "all") {
                $('#reset-filters').removeClass('d-none');
                showTable();
            } else if ($('#closed_by').val() != "all") {
                $('#reset-filters').removeClass('d-none');
                showTable();
            } else if ($('#search-text-field').val() != "") {
                $('#reset-filters').removeClass('d-none');
                showTable();
            } else {
                $('#reset-filters').addClass('d-none');
                showTable();
            }
        });

        $('#reset-filters').click(function() {
            $('#filter-form')[0].reset();
            $('.filter-box .select-picker').selectpicker("refresh");
            $('#reset-filters').addClass('d-none');
            showTable();
        });

        $('#quick-action-type').change(function() {
            const actionValue = $(this).val();
            if (actionValue != '') {
                $('#quick-action-apply').removeAttr('disabled');

                if (actionValue == 'change-status') {
                    $('.quick-action-field').addClass('d-none');
                    $('#change-status-action').removeClass('d-none');
                } else {
                    $('.quick-action-field').addClass('d-none');
                }
            } else {
                $('#quick-action-apply').attr('disabled', true);
                $('.quick-action-field').addClass('d-none');
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

        $('body').on('click', '.delete-table-row', function() {
            var id = $(this).data('deal-id');
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
                    var url = "{{ route('deals.destroy', ':id') }}";
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

        $('body').on('click', '.award_time_incress', function(e) {
            e.preventDefault();
            $('#task_id').val($(this).data('id'));
            $('#award_time_incress_modal').modal('toggle');
        });

        $('#award_time_incress_submit').click(function() {
            var task_id = $('#task_id').val();
            var task_hours = $('#task_hours').val();
            var task_description = $('#task_description').val();

            $.easyAjax({
                url: '{{ route('award_time_check.store') }}',
                //container: '#quick-action-form',
                type: "POST",
                disableButton: true,
                buttonSelector: "#award_time_incress_submit",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: task_id,
                    hours: task_hours,
                    description: task_description,
                },
                success: function(resp) {
                    if (resp.status == 'success') {
                        toastr.options.closeMethod = 'fadeOut';
                        toastr.options.closeDuration = 120;
                        toastr.options.closeEasing = 'swing';
                        toastr.success('Request Submit to Admin', 'Success');
                        toastr.options.onHidden = function() {
                            $('#award_time_incress_modal').modal('toggle');
                        }
                    }
                }
            })
        });

        const applyQuickAction = () => {
            var rowdIds = $("#Wondeal-table input:checkbox:checked").map(function() {
                return $(this).val();
            }).get();

            var url = "{{ route('deals.apply_quick_action') }}?row_ids=" + rowdIds;

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

        $(document).ready(function() {
            @if (!is_null(request('start')) && !is_null(request('end')))
                $('#datatableRange').val('{{ request('start') }}' +
                    ' @lang('app.to') ' + '{{ request('end') }}');
                $('#datatableRange').data('daterangepicker').setStartDate("{{ request('start') }}");
                $('#datatableRange').data('daterangepicker').setEndDate("{{ request('end') }}");
                showTable();
            @endif
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#description2').summernote();
            $('#description3').summernote();

            $('#deal-add').click(function() {
                $('#dealaddmodal').modal('show');
            })
        });
    </script>
@endpush
