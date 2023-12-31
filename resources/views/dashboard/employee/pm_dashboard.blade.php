{{-- @extends('layouts.app')
@push('datatable-styles')
@include('sections.daterange_css')
@endpush
@push('styles')
@if (!is_null($viewEventPermission) && $viewEventPermission != 'none')
<link rel="stylesheet"
      href="{{ asset('vendor/full-calendar/main.min.css') }}">
@endif
<style>
    .h-200 {
        max-height: 340px;
        overflow-y: auto;
    }

    .dashboard-settings {
        width: 600px;
    }

    @media (max-width: 768px) {
        .dashboard-settings {
            width: 300px;
        }
    }

    .fc-list-event-graphic {
        display: none;
    }

    .fc .fc-list-event:hover td {
        background-color: #fff !important;
        color: #000 !important;
    }

    .left-3 {
        margin-right: -22px;
    }

    .clockin-right {
        margin-right: -10px;
    }

    .week-pagination li {
        margin-right: 5px;
        z-index: 1;
    }

    .week-pagination li a {
        border-radius: 50%;
        padding: 2px 6px !important;
        font-size: 11px !important;
    }

    .week-pagination li.page-item:first-child .page-link {
        border-top-left-radius: 50%;
        border-bottom-left-radius: 50%;
    }

    .week-pagination li.page-item:last-child .page-link {
        border-top-right-radius: 50%;
        border-bottom-right-radius: 50%;
    }

    .hide-calender .table-condensed thead tr:nth-child(2),
    .hide-calender .table-condensed tbody {
        /*            display: none*/
    }

    .hide-calender.daterangepicker {
        width: 320px;
    }

    .hide-calender.monthselect {
        width: 100% !important;
    }

    .line-height-30 {
        line-height: 30px;
    }
</style>
@endpush
@section('content') --}}
{{--<div class="px-4 py-2 border-top-0">
    <!-- WELOCOME START -->
    @if (!is_null($checkTodayLeave))
    <div class="row pt-4">
        <div class="col-md-12">
            <x-alert type="info"
                     icon="info-circle">
                <a href="{{ route('leaves.show', $checkTodayLeave->id) }}"
                   class="openRightModal text-dark-grey">
                    <u>@lang('messages.youAreOnLeave')</u>
                </a>
            </x-alert>
        </div>
    </div>
    @elseif (!is_null($checkTodayHoliday))
    <div class="row pt-4">
        <div class="col-md-12">
            <x-alert type="info"
                     icon="info-circle">
                <a href="{{ route('holidays.show', $checkTodayHoliday->id) }}"
                   class="openRightModal text-dark-grey">
                    <u>@lang('messages.holidayToday')</u>
                </a>
            </x-alert>
        </div>
    </div>
    @endif

    <div class="d-lg-flex d-md-flex d-block py-4">
        <!-- WELOCOME NAME START -->
        <div>
            <h4 class=" mb-0 f-21 text-capitalize font-weight-bold">@lang('app.welcome')
                {{ $user->name }}</h4>
        </div>
        <!-- WELOCOME NAME END -->
    </div>
    <div class="emp-dash-detail">
        @if(count(array_intersect(['profile', 'shift_schedule', 'birthday', 'notices'], $activeWidgets)) > 0)
        <div class="row">
            @if (in_array('profile', $activeWidgets))
            <!-- EMP DASHBOARD INFO START -->
            <div class="col-md-12">
                <div class="card border-0 b-shadow-4 mb-3 e-d-info">
                    <div class="card-horizontal align-items-center">
                        <div class="card-img">
                            <img class=""
                                 src=" {{ $user->image_url }}"
                                 alt="Card image">
                        </div>
                        <div class="card-body border-0 pl-0">
                            <h4 class="card-title f-18 f-w-500 mb-0">{{ mb_ucwords($user->name) }}</h4>
                            <p class="f-14 font-weight-normal text-dark-grey mb-2">{{ $user->employeeDetails->designation->name ?? '--' }}</p>
                            <p class="card-text f-12 text-lightest"> @lang('app.employeeId') : {{ mb_strtoupper($user->employeeDetails->employee_id) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- EMP DASHBOARD INFO END -->
            @endif
        </div>
        @endif
    </div>
    <div id="accordion">
        <div class="card">
            <div class="card-header"
                 id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link"
                            data-toggle="collapse"
                            data-target="#collapseOne"
                            aria-expanded="true"
                            aria-controls="collapseOne">
                        Project Manager (Today's Update)
                    </button>
                </h5>
            </div>

            <div id="collapseOne"
                 class="collapse show"
                 aria-labelledby="headingOne"
                 data-parent="#accordion">
                <div class="card-body bg-amt-grey">
                    <div class="row my-2 text-center mx-auto">
                        <div class="col-sm-12 pb-3">
                            <div class="fc fc-media-screen fc-direction-ltr fc-theme-standard fc-liquid-hack text-center">
                                <div class="fc-toolbar-chunk">
                                    <div class="fc-button-group">
                                        <button date-mode="today"
                                                class="fc-prev-button fc-button fc-button-primary"
                                                type="button"
                                                aria-label="prev">
                                            <span class="fc-icon fc-icon-chevron-left"></span>
                                        </button>
                                        <h2 class="fc-toolbar-title mx-3 todayDate"></h2>
                                        <button class="fc-today-button fc-button fc-button-primary"
                                                type="button"
                                                disabled="">today</button>
                                        <button date-mode="today"
                                                class="fc-next-button fc-button fc-button-primary"
                                                type="button"
                                                aria-label="next">
                                            <span class="fc-icon fc-icon-chevron-right"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="todayHtml">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Projects Deadline Today</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$today_project_deadline->count()}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Milestone Waiting To be Completed</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$today_milestoe_to_be_completed}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Tasks Under Review (Assigned By Me)</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$today_tasks_under_review}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Task Deadline Today (Assigned By Me)</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$today_tasks_deadline}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Milestone Completed Today</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$today_completed_milestone}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Milestone Canceled Today</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$today_canceled_milestone}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Invoice Created Today</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$today_invoice_created}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Payment Released Today</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$today_payment_release}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">QC Form (Required Submission)</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$today_qc_required_submission}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Completion Form (Required Submission)</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$today_completion_form_required_submission}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Completion Form Pending Approval</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$completion_form_pending}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">QC Form Pending Approval</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$qc_form_pending}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize w-100 h-200">
                                        <h4 class="f-18 f-w-500 mb-2">Total Projects</h4>
                                        <table class="table w-100">
                                            <thead name="thead">
                                                <th class="pl-20 text-capitalize"> SL. No</th>
                                                <th class="pl-20 text-capitalize">Project</th>
                                                <th class="pl-20 text-capitalize">Client</th>
                                                <th class="pl-20 text-capitalize">Project Value</th>
                                                <th class="pl-20 text-capitalize">Tasks</th>
                                                <th class="pl-20 text-capitalize">Milestones (Task)</th>
                                                <th class="pl-20 text-capitalize">Milestones (Payment)</th>
                                                <th class="pl-20 text-capitalize">Start Date</th>
                                                <th class="pl-20 text-capitalize">Deadline</th>
                                                <th class="pl-20 text-capitalize">Progress</th>
                                                <th class="pl-20 text-capitalize">Status</th>
                                            </thead>
                                            <tbody>
                                                @forelse($today_project_status as $value)
                                                <tr>
                                                    <td>{{$loop->index+1}}</td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$value->project_name}}"
                                                           href="{{route('projects.show', $value->id)}}"
                                                           target="_blank">{{\Str::limit($value->project_name, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$value->client->name}}"
                                                           href="{{route('clients.show', $value->client_id)}}"
                                                           target="_blank">{{\Str::limit($value->client->name, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize">{{$value->project_budget}} $</td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $completed_task = $value->tasks->where('status', 'completed')->count();
                                                        $total = $value->tasks->count();
                                                        echo '('.$completed_task.' / '.$total.')';
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $milestones= \App\Models\ProjectMilestone::where('project_id',$value->id)->count();
                                                        $completed_milestones= \App\Models\ProjectMilestone::where('project_id',$value->id)->where('status','complete')->count();

                                                        echo '('.$completed_milestones.' / '.$milestones.')'
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $totalPaymentComplete = 0;
                                                        foreach($value->milestones as $mil) {
                                                        $invoice = \App\Models\Invoice::find($mil->invoice_id);
                                                        if (!is_null($invoice) && $invoice->status == 'paid') {
                                                        $totalPaymentComplete++;
                                                        }
                                                        }

                                                        echo '('.$totalPaymentComplete.' / '.$value->milestones->count().')';
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">{{$value->start_date->format('Y-m-d')}}</td>
                                                    <td class="pl-20 text-capitalize">{{$value->deadline}}</td>
                                                    <td>
                                                        @php
                                                        $milestones= \App\Models\ProjectMilestone::where('project_id',$value->id)->count();
                                                        $completed_milestones= \App\Models\ProjectMilestone::where('project_id',$value->id)->where('status','complete')->count();
                                                        if ($milestones < 1
                                                          )
                                                          {
                                                          $completion=0;
                                                          $statusColor='danger'
                                                          ;
                                                          }
                                                          elseif
                                                          ($milestones>= 1) {
                                                            $percentage = round(($completed_milestones/$milestones)*100,2);
                                                            if($percentage < 50)
                                                              {
                                                              $completion=$percentage;
                                                              $statusColor='danger'
                                                              ;
                                                              }
                                                              elseif
                                                              ($percentage>= 50 && $percentage < 75)
                                                                  {
                                                                  $completion=$percentage;
                                                                  $statusColor='warning'
                                                                  ;
                                                                  }
                                                                  elseif($percentage>= 75 && $percentage < 99)
                                                                      {
                                                                      $completion=$percentage;
                                                                      $statusColor='info'
                                                                      ;
                                                                      }
                                                                      else
                                                                      {
                                                                      $completion=$percentage;
                                                                      $statusColor='success'
                                                                      ;
                                                                      }
                                                                      }
                                                                      echo '<div class="progress" style="height: 15px;">
                                                                    <div class="progress-bar f-12 bg-'
                                                                      .
                                                                      $statusColor
                                                                      . '" role="progressbar" style="width: '
                                                                      .
                                                                      $completion
                                                                      . '%;" aria-valuenow="'
                                                                      .
                                                                      $completion
                                                                      . '" aria-valuemin="0" aria-valuemax="100">'
                                                                      .
                                                                      $completion
                                                                      . '%</div>
                                                                </div>'
                                                                      @endphp
                                                                      </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        //dd($value);
                                                        $projectStatus = \App\Models\ProjectStatusSetting::all();

                                                        foreach($projectStatus as $status)
                                                        {
                                                        if ($value->status == $status->status_name) {
                                                        $color = $status->color;
                                                        echo ' <i class="fa fa-circle mr-1 f-10"
                                                           style="color:'.$color.'"></i>' .'<span class="text-capitalize">'. ucfirst($status->status_name).'</span>';
                                                        }
                                                        }
                                                        @endphp
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="12"
                                                        class="shadow-none">
                                                        <x-cards.no-record icon="list"
                                                                           :message="__('messages.noRecordFound')" />
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize w-100 h-200">
                                        <h4 class="f-18 f-w-500 mb-2">Total Milestones</h4>
                                        <table class="table w-100">
                                            <thead>
                                                <th class="pl-20 text-capitalize">SL. No</th>
                                                <th class="pl-20 text-capitalize">Milestone</th>
                                                <th class="pl-20 text-capitalize">Deliverable</th>
                                                <th class="pl-20 text-capitalize">Project</th>
                                                <th class="pl-20 text-capitalize">Client</th>
                                                <th class="pl-20 text-capitalize">Milestone Cost</th>
                                                <th class="pl-20 text-capitalize">Status (Tasks)</th>
                                                <th class="pl-20 text-capitalize">Invoice Generated</th>
                                                <th class="pl-20 text-capitalize">Status</th>
                                            </thead>
                                            <tbody>
                                                @forelse($today_project_status as $value)
                                                @foreach($value->milestones as $milestone)
                                                <tr>
                                                    <td>{{$loop->index+1}}</td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$milestone->milestone_title}}"
                                                           href="{{route('milestones.show', $milestone->id)}}"
                                                           target="_blank">{{\Str::limit($milestone->milestone_title, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$milestone->deliverables->title ?? 'N/A'}}"
                                                           href="{{route('projects.show', $value->id)}}?tab=deliverables"
                                                           target="_blank">{{\Str::limit($milestone->deliverables->title ?? 'N/A', 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$value->project_name}}"
                                                           href="{{route('projects.show', $value->project_name)}}"
                                                           target="_blank">{{\Str::limit($value->project_name, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$value->client->name}}"
                                                           href="{{route('clients.show', $value->client_id)}}"
                                                           target="_blank">{{\Str::limit($value->client->name, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize">{{$milestone->cost}} $</td>
                                                    <td class="pl-20 text-capitalize">
                                                        ({{$milestone->tasks->where('status', 'tasks')->count()}} / {{$milestone->tasks->count()}})
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @if($milestone->invoice_created == 1)
                                                        <span class="badge badge-success">Yes</span>
                                                        @else
                                                        <span class="badge badge-danger">No</span>
                                                        @endif
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @if($milestone->invoice)
                                                        @if($milestone->invoice->status == 'paid')
                                                        <span class="badge badge-success">Paid</span>
                                                        @else
                                                        <span class="badge badge-danger">Unpaid</span>
                                                        @endif
                                                        @else
                                                        <span class="badge badge-warning">N/A</span>
                                                        @endif

                                                    </td>
                                                </tr>
                                                @endforeach
                                                @empty
                                                <tr>
                                                    <td colspan="12"
                                                        class="shadow-none">
                                                        <x-cards.no-record icon="list"
                                                                           :message="__('messages.noRecordFound')" />
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize w-100 h-200">
                                        <h4 class="f-18 f-w-500 mb-2">Total Tasks</h4>
                                        <table class="table w-100">
                                            <thead>
                                                <th class="pl-20 text-capitalize">SL. No</th>
                                                <th class="pl-20 text-capitalize">Task</th>
                                                <th class="pl-20 text-capitalize">Milestone</th>
                                                <th class="pl-20 text-capitalize">Deliverable</th>
                                                <th class="pl-20 text-capitalize">Project</th>
                                                <th class="pl-20 text-capitalize">Client</th>
                                                <th class="pl-20 text-capitalize">Start Date</th>
                                                <th class="pl-20 text-capitalize">Deadline</th>
                                                <th class="pl-20 text-capitalize">Assign To</th>
                                                <th class="pl-20 text-capitalize">Estimated Time</th>
                                                <th class="pl-20 text-capitalize">Hours Logged</th>
                                                <th class="pl-20 text-capitalize">Status</th>
                                            </thead>
                                            <tbody>
                                                @forelse($today_project_status as $value)
                                                @foreach($value->tasks as $task)
                                                <tr>
                                                    <td>{{$loop->index+1}}</td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$task->heading}}"
                                                           href="{{route('tasks.show', $task->id)}}"
                                                           target="_blank">{{\Str::limit($task->heading, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$task->milestone->milestone_title ?? 'N/A'}}"
                                                           href="{{route('projects.show', $value->id)}}?tab=milestone"
                                                           target="_blank">{{\Str::limit($task->milestone->milestone_title ?? 'N/A', 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$task->milestone->deliverables->title ?? 'N/A'}}"
                                                           href="{{route('projects.show', $value->id)}}?tab=deliverables"
                                                           target="_blank">{{\Str::limit($task->milestone->deliverables->title ?? 'N/A', 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$value->project_name}}"
                                                           href="{{route('projects.show', $value->id)}}"
                                                           target="_blank">{{\Str::limit($value->project_name, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$value->client->name ?? 'N/A'}}"
                                                           href="{{route('clients.show', $value->client_id ?? 0)}}"
                                                           target="_blank">{{\Str::limit($value->client->name ?? 'N/A', 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize">{{$task->start_date->format('Y-m-d') ?? '---'}}</td>
                                                    <td class="pl-20 text-capitalize">{{$task->due_date->format('Y-m-d') ?? '---'}}</td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $row = $task;
                                                        if (count($row->users) == 0) {
                                                        return '--';
                                                        }

                                                        $members = '<div class="position-relative">';

                                                            foreach ($row->users as $key => $member) {
                                                            if ($key < 4)
                                                              {
                                                              $img='<img data-toggle="tooltip" data-original-title="'
                                                              .
                                                              mb_ucwords($member->name) . '" src="' . $member->image_url . '">';
                                                                $position = $key > 0 ? 'position-absolute' : '';

                                                                $members .= '<div class="taskEmployeeImg rounded-circle '.$position.'"
                                                                     style="left:  '. ($key * 13) . 'px"><a href="' . route('employees.show', $member->id) . '">' . $img . '</a></div> ';
                                                                }
                                                                }

                                                                if (count($row->users) > 4) {
                                                                $members .= '<div class="taskEmployeeImg more-user-count text-center rounded-circle border bg-amt-grey position-absolute"
                                                                     style="left:  '. (($key - 1) * 13) . 'px"><a href="' .  route('tasks.show', [$row->id]). '"
                                                                       class="text-dark f-10">+' . (count($row->users) - 4) . '</a></div> ';
                                                                }

                                                                $members .= '</div>';

                                                        echo $members;
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $totalHours = $task->estimate_hours;
                                                        $totalMinutes = $task->estimate_minutes;

                                                        $tasks = $task->subtasks;

                                                        foreach($tasks as $value) {
                                                        $countTask = \App\Models\Task::where('subtask_id', $value->id)->first();
                                                        $totalHours = $totalHours + $countTask->estimate_hours;
                                                        $totalMinutes = $totalMinutes + $countTask->estimate_minutes;
                                                        }

                                                        if ($totalMinutes >= 60) {
                                                        $hours = intval(floor($totalMinutes / 60));
                                                        $minutes = $totalMinutes % 60;
                                                        $totalHours = $totalHours + $hours;
                                                        $totalMinutes = $minutes;
                                                        }

                                                        if ($totalHours == 0 && $totalMinutes == 0) {
                                                        echo '---';
                                                        } else {
                                                        echo $totalHours.' hrs '.$totalMinutes.' mins';
                                                        }
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $row = $task;
                                                        $timeLog = '--';

                                                        if($row->timeLogged) {
                                                        $totalMinutes = $row->timeLogged->sum('total_minutes');

                                                        foreach($row->timeLogged as $value) {
                                                        if (is_null($value->end_time)) {
                                                        $workingTime = $value->start_time->diffInMinutes(\Carbon\Carbon::now());
                                                        $totalMinutes = $totalMinutes + $workingTime;
                                                        }
                                                        }

                                                        $breakMinutes = $row->breakMinutes();
                                                        $totalMinutes = $totalMinutes - $breakMinutes;

                                                        $timeLog = intdiv($totalMinutes, 60) . ' ' . __('app.hrs') . ' ';

                                                        if ($totalMinutes % 60 > 0) {
                                                        $timeLog .= $totalMinutes % 60 . ' ' . __('app.mins');
                                                        }
                                                        }

                                                        $tas_id = \App\Models\Task::where('id',$row->id)->first();
                                                        $subtasks = \App\Models\Subtask::where('task_id', $tas_id->id)->get();

                                                        //$time = 0;

                                                        foreach ($subtasks as $subtask) {
                                                        $task = \App\Models\Task::where('subtask_id', $subtask->id)->first();
                                                        $totalMinutes = $totalMinutes + $task->timeLogged->sum('total_minutes');

                                                        foreach($task->timeLogged as $value) {
                                                        if (is_null($value->end_time)) {
                                                        $workingTime = $value->start_time->diffInMinutes(\Carbon\Carbon::now());
                                                        $totalMinutes = $totalMinutes + $workingTime;
                                                        }
                                                        }
                                                        }

                                                        if($subtasks == null) {
                                                        echo $timeLog;
                                                        } else {
                                                        $timeL = intdiv(($totalMinutes), 60) . ' ' . __('app.hrs') . ' ';

                                                        if ($totalMinutes % 60 > 0) {
                                                        $timeL .= ($totalMinutes) % 60 . ' ' . __('app.mins');
                                                        }
                                                        echo $timeL;
                                                        }
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        <i class="fa fa-circle mr-1 text-yellow"
                                                           style="color: {{$row->boardColumn->label_color}};"></i>{{$row->boardColumn->column_name}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @empty
                                                <tr>
                                                    <td colspan="12"
                                                        class="shadow-none">
                                                        <x-cards.no-record icon="list"
                                                                           :message="__('messages.noRecordFound')" />
                                                    </td>
                                                </tr>
                                                @endforelse
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
        <div class="card">
            <div class="card-header"
                 id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed"
                            type="button"
                            data-toggle="collapse"
                            data-target="#collapseTwo"
                            aria-expanded="false"
                            aria-controls="collapseTwo">
                        Project Manager Monthly Cycle Update (21st - 20th)
                    </button>
                </h2>
            </div>
            <div id="collapseTwo"
                 class="collapse"
                 aria-labelledby="headingTwo"
                 data-parent="#accordion">
                <div class="card-body bg-amt-grey">
                    <div class="row my-2 text-center mx-auto">
                        <div class="col-sm-12 pb-3">
                            <div class="fc fc-media-screen fc-direction-ltr fc-theme-standard fc-liquid-hack text-center">
                                <div class="fc-toolbar-chunk">
                                    <div class="fc-button-group">
                                        <button date-mode="month"
                                                class="fc-prev-button fc-button fc-button-primary"
                                                type="button"
                                                aria-label="prev">
                                            <span class="fc-icon fc-icon-chevron-left"></span>
                                        </button>
                                        <h2 class="fc-toolbar-title mx-3 monthDate"></h2>
                                        <button date-mode="month"
                                                class="fc-next-button fc-button fc-button-primary"
                                                type="button"
                                                aria-label="next">
                                            <span class="fc-icon fc-icon-chevron-right"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="monthHtml">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">No of Projects</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ $month_no_of_inprogress }}<span class="f-12 font-weight-normal text-lightest">
                                                        @lang('In Progress') </span>
                                                </p>
                                            </a>

                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-red d-grid">{{$month_no_of_canceled}}<span class="f-12 font-weight-normal text-lightest">@lang('Canceled')</span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Total Project Value</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($month_total_project_value,2) }} ($)<span class="f-12 font-weight-normal text-lightest">
                                                        @lang('Amount (USD)') </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Total Released Amount</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($month_total_released_amount,2) }} ($)<span class="f-12 font-weight-normal text-lightest">
                                                        @lang('Amount (USD)') </span>
                                                </p>
                                            </a>


                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">% Projects Got Completed/Money Released</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($month_percentage_of_complete_project_count,2) }}%<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">% Projects Got Canceled</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($month_percentage_of_canceled_project_count,2) }}%<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Average Project Completion Time</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($month_avg_project_completion_time,2) }} Days<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">No. Of Projects Got Canceled</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($month_total_canceled_project,2) }}<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- enanfafraferferfer <div class="col-md-4">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">No. Of Cross/Upsell Projects</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    0<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>


                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Avg. Payment Release Time</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($month_avg_project_completion_time,2) }} Days<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>


                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Negative Feedbacks After Submission</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($month_total_canceled_project,2) }}<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">% of Projects Completed on Time</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    0%<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">% of Project on Hold</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($month_percentage_of_onhold_project_count,2) }}%<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Projects Deadline Of this Month</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$month_project_deadline->count()}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Milestone Waiting To be Completed</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$month_milestoe_to_be_completed}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Tasks Under Review (Assigned By Me)</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$month_tasks_under_review}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Task Deadline Of this Month (Assigned By Me)</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$month_tasks_deadline}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Milestone Completed Of this Month</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$month_completed_milestone}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Invoice Created Of this Month</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$month_invoice_created}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Payment Released Of this Month</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{round($month_payment_release, 2)}}$<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">QC Form (Required Submission)</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$month_qc_required_submission}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Completion Form (Required Submission)</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$month_completion_form_required_submission}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Partially Finished Projects</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$month_partially_finished_project->count()}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Total Milestone</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$month_total_milestone_count}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Milestone Released</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$month_project_milestone_total}} $<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize w-100 h-200">
                                        <h4 class="f-18 f-w-500 mb-2">Total Projects</h4>
                                        <table class="table w-100">
                                            <thead name="thead">
                                                <th class="pl-20 text-capitalize"> SL. No</th>
                                                <th class="pl-20 text-capitalize">Project</th>
                                                <th class="pl-20 text-capitalize">Client</th>
                                                <th class="pl-20 text-capitalize">Project Value</th>
                                                <th class="pl-20 text-capitalize">Tasks</th>
                                                <th class="pl-20 text-capitalize">Milestones (Task)</th>
                                                <th class="pl-20 text-capitalize">Milestones (Payment)</th>
                                                <th class="pl-20 text-capitalize">Start Date</th>
                                                <th class="pl-20 text-capitalize">Deadline</th>

                                                <th class="pl-20 text-capitalize">Progress</th>
                                                <th class="pl-20 text-capitalize">Status</th>
                                            </thead>
                                            <tbody>
                                                @forelse($month_project_status as $value)
                                                <tr>
                                                    <td>{{$loop->index+1}}</td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$value->project_name}}"
                                                           href="{{route('projects.show', $value->id)}}"
                                                           target="_blank">{{\Str::limit($value->project_name, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$value->client->name}}"
                                                           href="{{route('clients.show', $value->client_id)}}"
                                                           target="_blank">{{\Str::limit($value->client->name, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize">{{$value->project_budget}} $</td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $completed_task = $value->tasks->where('status', 'completed')->count();
                                                        $total = $value->tasks->count();
                                                        echo '('.$completed_task.' / '.$total.')';
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $milestones= \App\Models\ProjectMilestone::where('project_id',$value->id)->count();
                                                        $completed_milestones= \App\Models\ProjectMilestone::where('project_id',$value->id)->where('status','complete')->count();

                                                        echo '('.$completed_milestones.' / '.$milestones.')'
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $totalPaymentComplete = 0;
                                                        foreach($value->milestones as $mil) {
                                                        $invoice = \App\Models\Invoice::find($mil->invoice_id);
                                                        if (!is_null($invoice) && $invoice->status == 'paid') {
                                                        $totalPaymentComplete++;
                                                        }
                                                        }

                                                        echo '('.$totalPaymentComplete.' / '.$value->milestones->count().')';
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">{{$value->start_date->format('Y-m-d')}}</td>
                                                    <td class="pl-20 text-capitalize">{{$value->deadline}}</td>

                                                    <td>
                                                        @php
                                                        $milestones= \App\Models\ProjectMilestone::where('project_id',$value->id)->count();
                                                        $completed_milestones= \App\Models\ProjectMilestone::where('project_id',$value->id)->where('status','complete')->count();
                                                        if ($milestones < 1
                                                          )
                                                          {
                                                          $completion=0;
                                                          $statusColor='danger'
                                                          ;
                                                          }
                                                          elseif
                                                          ($milestones>= 1) {
                                                            $percentage = round(($completed_milestones/$milestones)*100,2);
                                                            if($percentage < 50)
                                                              {
                                                              $completion=$percentage;
                                                              $statusColor='danger'
                                                              ;
                                                              }
                                                              elseif
                                                              ($percentage>= 50 && $percentage < 75)
                                                                  {
                                                                  $completion=$percentage;
                                                                  $statusColor='warning'
                                                                  ;
                                                                  }
                                                                  elseif($percentage>= 75 && $percentage < 99)
                                                                      {
                                                                      $completion=$percentage;
                                                                      $statusColor='info'
                                                                      ;
                                                                      }
                                                                      else
                                                                      {
                                                                      $completion=$percentage;
                                                                      $statusColor='success'
                                                                      ;
                                                                      }
                                                                      }
                                                                      echo '<div class="progress" style="height: 15px;">
                                                                    <div class="progress-bar f-12 bg-'
                                                                      .
                                                                      $statusColor
                                                                      . '" role="progressbar" style="width: '
                                                                      .
                                                                      $completion
                                                                      . '%;" aria-valuenow="'
                                                                      .
                                                                      $completion
                                                                      . '" aria-valuemin="0" aria-valuemax="100">'
                                                                      .
                                                                      $completion
                                                                      . '%</div>
                                                                </div>'
                                                                      @endphp
                                                                      </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        //dd($value);
                                                        $projectStatus = \App\Models\ProjectStatusSetting::all();

                                                        foreach($projectStatus as $status)
                                                        {
                                                        if ($value->status == $status->status_name) {
                                                        $color = $status->color;
                                                        echo ' <i class="fa fa-circle mr-1 f-10"
                                                           style="color:'.$color.'"></i>' .'<span class="text-capitalize">'. ucfirst($status->status_name).'</span>';
                                                        }
                                                        }
                                                        @endphp
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="12"
                                                        class="shadow-none">
                                                        <x-cards.no-record icon="list"
                                                                           :message="__('messages.noRecordFound')" />
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize w-100 h-200">
                                        <h4 class="f-18 f-w-500 mb-2">Total Milestones</h4>
                                        <table class="table w-100">
                                            <thead>
                                                <th class="pl-20 text-capitalize">SL. No</th>
                                                <th class="pl-20 text-capitalize">Milestone</th>
                                                <th class="pl-20 text-capitalize">Deliverable</th>
                                                <th class="pl-20 text-capitalize">Project</th>
                                                <th class="pl-20 text-capitalize">Client</th>
                                                <th class="pl-20 text-capitalize">Milestone Cost</th>
                                                <th class="pl-20 text-capitalize">Status (Tasks)</th>
                                                <th class="pl-20 text-capitalize">Invoice Generated</th>
                                                <th class="pl-20 text-capitalize">Status</th>
                                            </thead>
                                            <tbody>
                                                @forelse($month_project_status as $value)
                                                @foreach($value->milestones as $milestone)
                                                <tr>
                                                    <td>{{$loop->index+1}}</td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$milestone->milestone_title}}"
                                                           href="{{route('milestones.show', $milestone->id)}}"
                                                           target="_blank">{{\Str::limit($milestone->milestone_title, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$milestone->deliverables->title ?? 'N/A'}}"
                                                           href="{{route('projects.show', $value->id)}}?tab=deliverables"
                                                           target="_blank">{{\Str::limit($milestone->deliverables->title ?? 'N/A', 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$value->project_name}}"
                                                           href="{{route('projects.show', $value->project_name)}}"
                                                           target="_blank">{{\Str::limit($value->project_name, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$value->client->name}}"
                                                           href="{{route('clients.show', $value->client_id)}}"
                                                           target="_blank">{{\Str::limit($value->client->name, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize">{{$milestone->cost}} $</td>
                                                    <td class="pl-20 text-capitalize">
                                                        ({{$milestone->tasks->where('status', 'completed')->count()}} / {{$milestone->tasks->count()}})
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @if($milestone->invoice_created == 1)
                                                        <span class="badge badge-success">Yes</span>
                                                        @else
                                                        <span class="badge badge-danger">No</span>
                                                        @endif
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @if($milestone->invoice)
                                                        @if($milestone->invoice->status == 'paid')
                                                        <span class="badge badge-success">Paid</span>
                                                        @else
                                                        <span class="badge badge-danger">Unpaid</span>
                                                        @endif
                                                        @else
                                                        <span class="badge badge-warning">N/A</span>
                                                        @endif

                                                    </td>
                                                </tr>
                                                @endforeach
                                                @empty
                                                <tr>
                                                    <td colspan="12"
                                                        class="shadow-none">
                                                        <x-cards.no-record icon="list"
                                                                           :message="__('messages.noRecordFound')" />
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize w-100 h-200">
                                        <h4 class="f-18 f-w-500 mb-2">Total Tasks</h4>
                                        <table class="table w-100">
                                            <thead>
                                                <th class="pl-20 text-capitalize">SL. No</th>
                                                <th class="pl-20 text-capitalize">Task</th>
                                                <th class="pl-20 text-capitalize">Milestone</th>
                                                <th class="pl-20 text-capitalize">Deliverable</th>
                                                <th class="pl-20 text-capitalize">Project</th>
                                                <th class="pl-20 text-capitalize">Client</th>
                                                <th class="pl-20 text-capitalize">Start Date</th>
                                                <th class="pl-20 text-capitalize">Deadline</th>
                                                <th class="pl-20 text-capitalize">Assign To</th>
                                                <th class="pl-20 text-capitalize">Estimated Time</th>
                                                <th class="pl-20 text-capitalize">Hours Logged</th>
                                                <th class="pl-20 text-capitalize">Status</th>
                                            </thead>
                                            <tbody>
                                                @forelse($month_task_status as $task)

                                                <tr>
                                                    <td>{{$loop->index+1}}</td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$task->heading}}"
                                                           href="{{route('tasks.show', $task->id)}}"
                                                           target="_blank">{{\Str::limit($task->heading, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$task->milestone->milestone_title ?? 'N/A'}}"
                                                           href="{{route('projects.show', $task->project_id)}}?tab=milestone"
                                                           target="_blank">{{\Str::limit($task->milestone->milestone_title ?? 'N/A', 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$task->milestone->deliverables->title ?? 'N/A'}}"
                                                           href="{{route('projects.show', $task->project_id)}}?tab=deliverables"
                                                           target="_blank">{{\Str::limit($task->milestone->deliverables->title ?? 'N/A', 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$task->project->project_name}}"
                                                           href="{{route('projects.show', $task->project_id)}}"
                                                           target="_blank">{{\Str::limit($task->project->project_name, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$task->project->client->name ?? 'N/A'}}"
                                                           href="{{route('clients.show', $task->project->client_id ?? 0)}}"
                                                           target="_blank">{{\Str::limit($task->project->client->name ?? 'N/A', 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize">{{$task->start_date ?? '---'}}</td>
                                                    <td class="pl-20 text-capitalize">{{$task->due_date ?? '---'}}</td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $row = $task;
                                                        if (count($row->users) == 0) {
                                                        return '--';
                                                        }

                                                        $members = '<div class="position-relative">';

                                                            foreach ($row->users as $key => $member) {
                                                            if ($key < 4)
                                                              {
                                                              $img='<img data-toggle="tooltip" data-original-title="'
                                                              .
                                                              mb_ucwords($member->name) . '" src="' . $member->image_url . '">';
                                                                $position = $key > 0 ? 'position-absolute' : '';

                                                                $members .= '<div class="taskEmployeeImg rounded-circle '.$position.'"
                                                                     style="left:  '. ($key * 13) . 'px"><a href="' . route('employees.show', $member->id) . '">' . $img . '</a></div> ';
                                                                }
                                                                }

                                                                if (count($row->users) > 4) {
                                                                $members .= '<div class="taskEmployeeImg more-user-count text-center rounded-circle border bg-amt-grey position-absolute"
                                                                     style="left:  '. (($key - 1) * 13) . 'px"><a href="' .  route('tasks.show', [$row->id]). '"
                                                                       class="text-dark f-10">+' . (count($row->users) - 4) . '</a></div> ';
                                                                }

                                                                $members .= '</div>';

                                                        echo $members;
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $totalHours = $task->estimate_hours;
                                                        $totalMinutes = $task->estimate_minutes;

                                                        $tasks = $task->subtasks;

                                                        foreach($tasks as $value) {
                                                        $countTask = \App\Models\Task::where('subtask_id', $value->id)->first();
                                                        $totalHours = $totalHours + $countTask->estimate_hours;
                                                        $totalMinutes = $totalMinutes + $countTask->estimate_minutes;
                                                        }

                                                        if ($totalMinutes >= 60) {
                                                        $hours = intval(floor($totalMinutes / 60));
                                                        $minutes = $totalMinutes % 60;
                                                        $totalHours = $totalHours + $hours;
                                                        $totalMinutes = $minutes;
                                                        }

                                                        if ($totalHours == 0 && $totalMinutes == 0) {
                                                        echo '---';
                                                        } else {
                                                        echo $totalHours.' hrs '.$totalMinutes.' mins';
                                                        }
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $row = $task;
                                                        $timeLog = '--';

                                                        if($row->timeLogged) {
                                                        $totalMinutes = $row->timeLogged->sum('total_minutes');

                                                        foreach($row->timeLogged as $value) {
                                                        if (is_null($value->end_time)) {
                                                        $workingTime = $value->start_time->diffInMinutes(\Carbon\Carbon::now());
                                                        $totalMinutes = $totalMinutes + $workingTime;
                                                        }
                                                        }

                                                        $breakMinutes = $row->breakMinutes();
                                                        $totalMinutes = $totalMinutes - $breakMinutes;

                                                        $timeLog = intdiv($totalMinutes, 60) . ' ' . __('app.hrs') . ' ';

                                                        if ($totalMinutes % 60 > 0) {
                                                        $timeLog .= $totalMinutes % 60 . ' ' . __('app.mins');
                                                        }
                                                        }

                                                        $tas_id = \App\Models\Task::where('id',$row->id)->first();
                                                        $subtasks = \App\Models\Subtask::where('task_id', $tas_id->id)->get();

                                                        //$time = 0;

                                                        foreach ($subtasks as $subtask) {
                                                        $task = \App\Models\Task::where('subtask_id', $subtask->id)->first();
                                                        $totalMinutes = $totalMinutes + $task->timeLogged->sum('total_minutes');

                                                        foreach($task->timeLogged as $value) {
                                                        if (is_null($value->end_time)) {
                                                        $workingTime = $value->start_time->diffInMinutes(\Carbon\Carbon::now());
                                                        $totalMinutes = $totalMinutes + $workingTime;
                                                        }
                                                        }
                                                        }

                                                        if($subtasks == null) {
                                                        echo $timeLog;
                                                        } else {
                                                        $timeL = intdiv(($totalMinutes), 60) . ' ' . __('app.hrs') . ' ';

                                                        if ($totalMinutes % 60 > 0) {
                                                        $timeL .= ($totalMinutes) % 60 . ' ' . __('app.mins');
                                                        }
                                                        echo $timeL;
                                                        }
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        <i class="fa fa-circle mr-1 text-yellow"
                                                           style="color: {{$row->boardColumn->label_color}};"></i>{{$row->boardColumn->column_name}}
                                                    </td>
                                                </tr>

                                                @empty
                                                <tr>
                                                    <td colspan="12"
                                                        class="shadow-none">
                                                        <x-cards.no-record icon="list"
                                                                           :message="__('messages.noRecordFound')" />
                                                    </td>
                                                </tr>
                                                @endforelse
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
        <div class="card">
            <div class="card-header"
                 id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed"
                            data-toggle="collapse"
                            data-target="#collapseThree"
                            aria-expanded="false"
                            aria-controls="collapseThree">
                        Project Manager (General View)
                    </button>
                </h5>
            </div>
            <div id="collapseThree"
                 class="collapse"
                 aria-labelledby="headingThree"
                 data-parent="#accordion">
                <div class="card-body bg-amt-grey">
                    <div class="row">
                        <div class="align-items-center mx-auto h-100 pl-4 ml-5">
                            <div class="col-auto">
                                <label class="sr-only"
                                       for="inlineFormInputGroup"></label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-calendar-alt mr-2 f-14 text-dark-grey"></i></div>
                                    </div>
                                    <input type="text"
                                           class="position-relative text-dark form-control border-0 p-2 text-left f-14 f-w-500"
                                           id="datatableRange2"
                                           placeholder="Start Date And End Date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="generalHtml">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">No of Projects</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ $general_no_of_inprogress }}<span class="f-12 font-weight-normal text-lightest">
                                                        @lang('In Progress') </span>
                                                </p>
                                            </a>

                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-red d-grid">{{$general_no_of_canceled}}<span class="f-12 font-weight-normal text-lightest">@lang('Canceled')</span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Total Project Value</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($general_total_project_value,2) }} ($)<span class="f-12 font-weight-normal text-lightest">
                                                        @lang('Amount (USD)') </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Total Released Amount</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($general_total_released_amount,2) }} ($)<span class="f-12 font-weight-normal text-lightest">
                                                        @lang('Amount (USD)') </span>
                                                </p>
                                            </a>


                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">% Projects Got Completed/Money Released</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($general_percentage_of_complete_project_count,2) }}%<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">% Projects Got Canceled</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($general_percentage_of_canceled_project_count,2) }}%<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Average Project Completion Time</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($general_avg_project_completion_time,2) }} Days<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">No. Of Projects Got Canceled</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($general_total_canceled_project,2) }}<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">No. Of Cross/Upsell Projects</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    0<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>


                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Avg. Payment Release Time</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($general_avg_project_completion_time,2) }} Days<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>


                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Negative Feedbacks After Submission</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($general_total_canceled_project,2) }}<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">% of Projects Completed on Time</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    0%<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">% of Project on Hold</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{ round($general_percentage_of_onhold_project_count,2) }}%<span class="f-12 font-weight-normal text-lightest">
                                                    </span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Projects Deadline Of this Month</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$general_project_deadline->count()}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Milestone Waiting To be Completed</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$general_milestoe_to_be_completed}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Tasks Under Review (Assigned By Me)</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$general_tasks_under_review}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Task Deadline Of this Month (Assigned By Me)</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$general_tasks_deadline}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Milestone Completed Of this Month</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$general_completed_milestone}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Invoice Created Of this Month</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$general_invoice_created}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Payment Released Of this Month</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{round($general_payment_release, 2)}}$<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">QC Form (Required Submission)</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$general_qc_required_submission}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Completion Form (Required Submission)</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$general_completion_form_required_submission}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Partially Finished Projects</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$general_partially_finished_project->count()}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Total Milestone</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$general_total_milestone_count}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Milestone Released</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$general_project_milestone_total}} $<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Milestone Canceled</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$general_project_milestone->sum('milestone_cancel_amount')}} $<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">QC Form Pending Approval</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$general_qc_pending_count}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize">
                                        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">Completion Form Pending Approval</h5>
                                        <div class="d-flex">
                                            <a href="#">
                                                <p class="mb-0 f-21 font-weight-bold text-blue d-grid mr-5">
                                                    {{$general_completion_pending_count}}<span class="f-12 font-weight-normal text-lightest"></span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <i class="fa fa-list text-lightest f-27"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize w-100 h-200">
                                        <h4 class="f-18 f-w-500 mb-2">Total Projects</h4>
                                        <table class="table w-100">
                                            <thead name="thead">
                                                <th class="pl-20 text-capitalize"> SL. No</th>
                                                <th class="pl-20 text-capitalize">Project</th>
                                                <th class="pl-20 text-capitalize">Client</th>
                                                <th class="pl-20 text-capitalize">Project Value</th>
                                                <th class="pl-20 text-capitalize">Tasks</th>
                                                <th class="pl-20 text-capitalize">Milestones (Task)</th>
                                                <th class="pl-20 text-capitalize">Milestones (Payment)</th>
                                                <th class="pl-20 text-capitalize">Start Date</th>
                                                <th class="pl-20 text-capitalize">Deadline</th>

                                                <th class="pl-20 text-capitalize">Progress</th>
                                                <th class="pl-20 text-capitalize">Status</th>
                                            </thead>
                                            <tbody>
                                                @forelse($general_project_status as $value)
                                                <tr>
                                                    <td>{{$loop->index+1}}</td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$value->project_name}}"
                                                           href="{{route('projects.show', $value->id)}}"
                                                           target="_blank">{{\Str::limit($value->project_name, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$value->client->name}}"
                                                           href="{{route('clients.show', $value->client_id)}}"
                                                           target="_blank">{{\Str::limit($value->client->name, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize">{{$value->project_budget}} $</td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $completed_task = $value->tasks->where('status', 'completed')->count();
                                                        $total = $value->tasks->count();
                                                        echo '('.$completed_task.' / '.$total.')';
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $milestones= \App\Models\ProjectMilestone::where('project_id',$value->id)->count();
                                                        $completed_milestones= \App\Models\ProjectMilestone::where('project_id',$value->id)->where('status','complete')->count();

                                                        echo '('.$completed_milestones.' / '.$milestones.')'
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $totalPaymentComplete = 0;
                                                        foreach($value->milestones as $mil) {
                                                        $invoice = \App\Models\Invoice::find($mil->invoice_id);
                                                        if (!is_null($invoice) && $invoice->status == 'paid') {
                                                        $totalPaymentComplete++;
                                                        }
                                                        }

                                                        echo '('.$totalPaymentComplete.' / '.$value->milestones->count().')';
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">{{$value->start_date->format('Y-m-d')}}</td>
                                                    <td>
                                                        @php
                                                        $milestones= \App\Models\ProjectMilestone::where('project_id',$value->id)->count();
                                                        $completed_milestones= \App\Models\ProjectMilestone::where('project_id',$value->id)->where('status','complete')->count();
                                                        if ($milestones < 1
                                                          )
                                                          {
                                                          $completion=0;
                                                          $statusColor='danger'
                                                          ;
                                                          }
                                                          elseif
                                                          ($milestones>= 1) {
                                                            $percentage = round(($completed_milestones/$milestones)*100,2);
                                                            if($percentage < 50)
                                                              {
                                                              $completion=$percentage;
                                                              $statusColor='danger'
                                                              ;
                                                              }
                                                              elseif
                                                              ($percentage>= 50 && $percentage < 75)
                                                                  {
                                                                  $completion=$percentage;
                                                                  $statusColor='warning'
                                                                  ;
                                                                  }
                                                                  elseif($percentage>= 75 && $percentage < 99)
                                                                      {
                                                                      $completion=$percentage;
                                                                      $statusColor='info'
                                                                      ;
                                                                      }
                                                                      else
                                                                      {
                                                                      $completion=$percentage;
                                                                      $statusColor='success'
                                                                      ;
                                                                      }
                                                                      }
                                                                      echo '<div class="progress" style="height: 15px;">
                                                                    <div class="progress-bar f-12 bg-'
                                                                      .
                                                                      $statusColor
                                                                      . '" role="progressbar" style="width: '
                                                                      .
                                                                      $completion
                                                                      . '%;" aria-valuenow="'
                                                                      .
                                                                      $completion
                                                                      . '" aria-valuemin="0" aria-valuemax="100">'
                                                                      .
                                                                      $completion
                                                                      . '%</div>
                                                                </div>'
                                                                      @endphp
                                                                      </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        //dd($value);
                                                        $projectStatus = \App\Models\ProjectStatusSetting::all();

                                                        foreach($projectStatus as $status)
                                                        {
                                                        if ($value->status == $status->status_name) {
                                                        $color = $status->color;
                                                        echo ' <i class="fa fa-circle mr-1 f-10"
                                                           style="color:'.$color.'"></i>' .'<span class="text-capitalize">'. ucfirst($status->status_name).'</span>';
                                                        }
                                                        }
                                                        @endphp
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="12"
                                                        class="shadow-none">
                                                        <x-cards.no-record icon="list"
                                                                           :message="__('messages.noRecordFound')" />
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize w-100 h-200">
                                        <h4 class="f-18 f-w-500 mb-2">Total Milestones</h4>
                                        <table class="table w-100">
                                            <thead>
                                                <th class="pl-20 text-capitalize">SL. No</th>
                                                <th class="pl-20 text-capitalize">Milestone</th>
                                                <th class="pl-20 text-capitalize">Deliverable</th>
                                                <th class="pl-20 text-capitalize">Project</th>
                                                <th class="pl-20 text-capitalize">Client</th>
                                                <th class="pl-20 text-capitalize">Milestone Cost</th>
                                                <th class="pl-20 text-capitalize">Status (Tasks)</th>
                                                <th class="pl-20 text-capitalize">Invoice Generated</th>
                                                <th class="pl-20 text-capitalize">Status</th>
                                            </thead>
                                            <tbody>
                                                @forelse($general_project_status as $value)
                                                @foreach($value->milestones as $milestone)
                                                <tr>
                                                    <td>{{$loop->index+1}}</td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$milestone->milestone_title}}"
                                                           href="{{route('milestones.show', $milestone->id)}}"
                                                           target="_blank">{{\Str::limit($milestone->milestone_title, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$milestone->deliverables->title ?? 'N/A'}}"
                                                           href="{{route('projects.show', $value->id)}}?tab=deliverables"
                                                           target="_blank">{{\Str::limit($milestone->deliverables->title ?? 'N/A', 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$value->project_name}}"
                                                           href="{{route('projects.show', $value->project_name)}}"
                                                           target="_blank">{{\Str::limit($value->project_name, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$value->client->name}}"
                                                           href="{{route('clients.show', $value->client_id)}}"
                                                           target="_blank">{{\Str::limit($value->client->name, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize">{{$milestone->cost}} $</td>
                                                    <td class="pl-20 text-capitalize">
                                                        ({{$milestone->tasks->where('status', 'completed')->count()}} / {{$milestone->tasks->count()}})
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @if($milestone->invoice_created == 1)
                                                        <span class="badge badge-success">Yes</span>
                                                        @else
                                                        <span class="badge badge-danger">No</span>
                                                        @endif
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @if($milestone->invoice)
                                                        @if($milestone->invoice->status == 'paid')
                                                        <span class="badge badge-success">Paid</span>
                                                        @else
                                                        <span class="badge badge-danger">Unpaid</span>
                                                        @endif
                                                        @else
                                                        <span class="badge badge-warning">N/A</span>
                                                        @endif

                                                    </td>
                                                </tr>
                                                @endforeach
                                                @empty
                                                <tr>
                                                    <td colspan="12"
                                                        class="shadow-none">
                                                        <x-cards.no-record icon="list"
                                                                           :message="__('messages.noRecordFound')" />
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mb-4 mb-md-0 mb-lg-0">
                                    <div class="d-block text-capitalize w-100 h-200">
                                        <h4 class="f-18 f-w-500 mb-2">Total Tasks</h4>
                                        <table class="table w-100">
                                            <thead>
                                                <th class="pl-20 text-capitalize">SL. No</th>
                                                <th class="pl-20 text-capitalize">Task</th>
                                                <th class="pl-20 text-capitalize">Milestone</th>
                                                <th class="pl-20 text-capitalize">Deliverable</th>
                                                <th class="pl-20 text-capitalize">Project</th>
                                                <th class="pl-20 text-capitalize">Client</th>
                                                <th class="pl-20 text-capitalize">Start Date</th>
                                                <th class="pl-20 text-capitalize">Deadline</th>
                                                <th class="pl-20 text-capitalize">Assign To</th>
                                                <th class="pl-20 text-capitalize">Estimated Time</th>
                                                <th class="pl-20 text-capitalize">Hours Logged</th>
                                                <th class="pl-20 text-capitalize">Status</th>
                                            </thead>
                                            <tbody>
                                                @forelse($general_task_status as $task)

                                                <tr>
                                                    <td>{{$loop->index+1}}</td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$task->heading}}"
                                                           href="{{route('tasks.show', $task->id)}}"
                                                           target="_blank">{{\Str::limit($task->heading, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$task->milestone->milestone_title ?? 'N/A'}}"
                                                           href="{{route('projects.show', $value->id)}}?tab=milestone"
                                                           target="_blank">{{\Str::limit($task->milestone->milestone_title ?? 'N/A', 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$task->milestone->deliverables->title ?? 'N/A'}}"
                                                           href="{{route('projects.show', $value->id)}}?tab=deliverables"
                                                           target="_blank">{{\Str::limit($task->milestone->deliverables->title ?? 'N/A', 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$task->project->project_name}}"
                                                           href="{{route('projects.show', $task->project->id)}}"
                                                           target="_blank">{{\Str::limit($task->project->project_name, 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize ">
                                                        <a class="text-darkest-grey openRightModal RightModal"
                                                           id="RightModal"
                                                           title="{{$task->project->client->name ?? 'N/A'}}"
                                                           href="{{route('clients.show', $task->project->client_id ?? 0)}}"
                                                           target="_blank">{{\Str::limit($task->project->client->name ?? 'N/A', 20, ' ...')}}</a>
                                                    </td>
                                                    <td class="pl-20 text-capitalize">{{$task->start_date ?? '---'}}</td>
                                                    <td class="pl-20 text-capitalize">{{$task->due_date ?? '---'}}</td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $row = $task;
                                                        if (count($row->users) == 0) {
                                                        return '--';
                                                        }

                                                        $members = '<div class="position-relative">';

                                                            foreach ($row->users as $key => $member) {
                                                            if ($key < 4)
                                                              {
                                                              $img='<img data-toggle="tooltip" data-original-title="'
                                                              .
                                                              mb_ucwords($member->name) . '" src="' . $member->image_url . '">';
                                                                $position = $key > 0 ? 'position-absolute' : '';

                                                                $members .= '<div class="taskEmployeeImg rounded-circle '.$position.'"
                                                                     style="left:  '. ($key * 13) . 'px"><a href="' . route('employees.show', $member->id) . '">' . $img . '</a></div> ';
                                                                }
                                                                }

                                                                if (count($row->users) > 4) {
                                                                $members .= '<div class="taskEmployeeImg more-user-count text-center rounded-circle border bg-amt-grey position-absolute"
                                                                     style="left:  '. (($key - 1) * 13) . 'px"><a href="' .  route('tasks.show', [$row->id]). '"
                                                                       class="text-dark f-10">+' . (count($row->users) - 4) . '</a></div> ';
                                                                }

                                                                $members .= '</div>';

                                                        echo $members;
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $totalHours = $task->estimate_hours;
                                                        $totalMinutes = $task->estimate_minutes;

                                                        $tasks = $task->subtasks;

                                                        foreach($tasks as $value) {
                                                        $countTask = \App\Models\Task::where('subtask_id', $value->id)->first();
                                                        $totalHours = $totalHours + $countTask->estimate_hours;
                                                        $totalMinutes = $totalMinutes + $countTask->estimate_minutes;
                                                        }

                                                        if ($totalMinutes >= 60) {
                                                        $hours = intval(floor($totalMinutes / 60));
                                                        $minutes = $totalMinutes % 60;
                                                        $totalHours = $totalHours + $hours;
                                                        $totalMinutes = $minutes;
                                                        }

                                                        if ($totalHours == 0 && $totalMinutes == 0) {
                                                        echo '---';
                                                        } else {
                                                        echo $totalHours.' hrs '.$totalMinutes.' mins';
                                                        }
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        @php
                                                        $row = $task;
                                                        $timeLog = '--';

                                                        if($row->timeLogged) {
                                                        $totalMinutes = $row->timeLogged->sum('total_minutes');

                                                        foreach($row->timeLogged as $value) {
                                                        if (is_null($value->end_time)) {
                                                        $workingTime = $value->start_time->diffInMinutes(\Carbon\Carbon::now());
                                                        $totalMinutes = $totalMinutes + $workingTime;
                                                        }
                                                        }

                                                        $breakMinutes = $row->breakMinutes();
                                                        $totalMinutes = $totalMinutes - $breakMinutes;

                                                        $timeLog = intdiv($totalMinutes, 60) . ' ' . __('app.hrs') . ' ';

                                                        if ($totalMinutes % 60 > 0) {
                                                        $timeLog .= $totalMinutes % 60 . ' ' . __('app.mins');
                                                        }
                                                        }

                                                        $tas_id = \App\Models\Task::where('id',$row->id)->first();
                                                        $subtasks = \App\Models\Subtask::where('task_id', $tas_id->id)->get();

                                                        //$time = 0;

                                                        foreach ($subtasks as $subtask) {
                                                        $task = \App\Models\Task::where('subtask_id', $subtask->id)->first();
                                                        $totalMinutes = $totalMinutes + $task->timeLogged->sum('total_minutes');

                                                        foreach($task->timeLogged as $value) {
                                                        if (is_null($value->end_time)) {
                                                        $workingTime = $value->start_time->diffInMinutes(\Carbon\Carbon::now());
                                                        $totalMinutes = $totalMinutes + $workingTime;
                                                        }
                                                        }
                                                        }

                                                        if($subtasks == null) {
                                                        echo $timeLog;
                                                        } else {
                                                        $timeL = intdiv(($totalMinutes), 60) . ' ' . __('app.hrs') . ' ';

                                                        if ($totalMinutes % 60 > 0) {
                                                        $timeL .= ($totalMinutes) % 60 . ' ' . __('app.mins');
                                                        }
                                                        echo $timeL;
                                                        }
                                                        @endphp
                                                    </td>
                                                    <td class="pl-20 text-capitalize">
                                                        <i class="fa fa-circle mr-1 text-yellow"
                                                           style="color: {{$row->boardColumn->label_color}};"></i>{{$row->boardColumn->column_name}}
                                                    </td>
                                                </tr>

                                                @empty
                                                <tr>
                                                    <td colspan="12"
                                                        class="shadow-none">
                                                        <x-cards.no-record icon="list"
                                                                           :message="__('messages.noRecordFound')" />
                                                    </td>
                                                </tr>
                                                @endforelse
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

    </div>


</div>
<div> @endsection--}}

    <!DOCTYPE html>

    <head>
        <title>Project Manager</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet"
              href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>

    <body style="margin-left: 5%">
        <div class="form-group">
            <form action="{{ route('dashboard.filter') }}"
                  method="POST">
                {{ csrf_field() }}
                <label for="projectmanager">NAME:</label>
                <select name="pmid"
                        id="dropdown1"
                        required>
                    <option value="209">Diner M Islam</option>
                    <option value="210">Farhan Rahman</option>
                    <option value="245">Mohammad Fazle Rabbi</option>
                </select>
                <label for="start_date">Start Date:</label>
                <input type="date"
                       name="start_date"
                       id="start_date"
                       required>

                <label for="end_date">End Date:</label>
                <input type="date"
                       name="end_date"
                       id="end_date"
                       required>

                <button type="submit"
                        class="btn btn-primary">Submit</button>
            </form>
        </div>

        <div>



            @if (isset($totalAssignMilestonesCost))
            <p>Project Manager Name: {{ $username }} </p>
            <p>Date:{{ $startDate }} to {{ $endDate }} </p>

            <h3>Total Delayed Projects(Running Cycle)</h3>
            <p>{{ $delayedProjectsCount}}</p>

            <h3>Total Completed Delayed Projects (Running Cycle)</h3>
            <p>{{ $completeDelayedProjectsCount}}</p>

            <h3>Total Assigned projects number</h3>
            <p>{{ $totalRunningAcceptedProjectsRow + $totalRunningRejectedProjectsRow }}</p>

            <h3>Total Accepted projects number</h3>
            <p>{{ $totalRunningAcceptedProjectsRow}}</p>

            <h3>Total Rejected projects number</h3>
            <p>{{ $totalRunningRejectedProjectsRow}}</p>

            <h3>Total Assigned Projects value</h3>
            <p>{{ number_format($totalRunningAcceptedProjectsSum + $totalRunningRejectedProjectsSum,2)}}</p>

            <h3>Total Accepted Projects value</h3>
            <p>{{ number_format($totalRunningAcceptedProjectsSum,2)}}</p>

            <h3>Total Rejected Projects value</h3>
            <p>{{ number_format($totalRunningRejectedProjectsSum,2)}}</p>

            <h3>Released amount for Current Cycle</h3>
            <p>{{ $RunningtotalAssignMilestonesCost}}</p>

            <h3>Total released amount</h3>
            <p>{{ $totalAssignMilestonesCost}}</p>

            <h3>Total Cancelled Projects</h3>
            <p>{{ $totalProjectCancelled}}</p>


            <h3>Average Project Completion Time</h3>
            <p>{{ number_format($averageProjectCompletionTime,2) }} Days</p>

            <h3>Milestone Completion Rate</h3>
            <p>{{ $totalAssignMilestonesCost }} Dollar milestones assigned </p>
            <p>{{ $totalCompleteMilestonesCost }} Dollar milestones completed </p>
            <p>Percentage by Cost: {{ number_format($milestoneCompletionRatebyCost, 2) }}% </p>
            <p>{{ $totalAssignMilestonesRow }} milestones assigned </p>
            <p>{{ $totalCompleteMilestonesRow }} milestones completed </p>
            <p>Percentage by Count: {{ number_format($milestoneCompletionRatebyRow, 2) }}% </p>

            <h3>Milestone Completion Rate(Running)</h3>
            <p>{{ $RunningtotalAssignMilestonesCost }} Dollar milestones assigned </p>
            <p>{{ $RunningtotalCompleteMilestonesCost }} Dollar milestones completed </p>
            <p>Percentage by Cost: {{ number_format($RunningmilestoneCompletionRatebyCost, 2) }}% </p>
            <p>{{ $RunningtotalAssignMilestonesRow }} milestones assigned </p>
            <p>{{ $RunningtotalCompleteMilestonesRow }} milestones completed </p>
            <p>Percentage by Count: {{ number_format($RunningmilestoneCompletionRatebyRow, 2) }}% </p>


            <h3>Task Completion Rate</h3>
            {{-- <h3>Complete tasks for cycle (number)</h3> --}}
            <p>{{ $totalAssignTasksRow }} Tasks assigned </p>
            <p>{{ $totalCompleteTasksRow }} Tasks completed </p>
            <p>Percentage: {{ number_format($taskCompletionRate, 2) }}% </p>

            <h3>Task Completion Rate (Running)</h3>
            {{-- <h3>Complete tasks for Running cycle (number)</h3> --}}
            <p>{{ $RunningtotalAssignTasksRow }} Tasks assigned </p>
            <p>{{ $RunningtotalCompleteTasksRow }} Tasks completed </p>
            <p>Percentage: {{ number_format($RunningtaskCompletionRate, 2) }}% </p>

            <h3>Project Completion Rate</h3>
            <p>{{ $totalAssignProjectsSum }} Dollar assigned </p>
            <p>{{ $totalCompleteProjectsSum }} Dollar completed </p>
            <p>Percentage: {{ number_format($ProjectCompletionRatebyCost, 2) }}% </p>
            <p>{{ $totalAssignProjectsRow }} Projects assigned </p>
            <p>{{ $totalCompleteProjectsRow }} Projects completed </p>
            <p>Percentage: {{ number_format($projectsCompletionRatebyRow, 2) }}% </p>

            <h3>Project Completion Rate(Running Batch)</h3>
            <p>{{ $totalRunningAssignProjectsSum }} Dollar assigned </p>
            <p>{{ $totalRunningCompleteProjectsSum }} Dollar completed </p>
            <p>Percentage: {{ number_format($RunningProjectCompletionRatebyCost, 2) }}% </p>
            <p>{{ $totalRunningAssignProjectsRow }} Projects assigned </p>
            <p>{{ $totalRunningCompleteProjectsRow }} Projects completed </p>
            <p>Percentage: {{ number_format($RunningProjectsCompletionRatebyRow, 2) }}% </p>

            <h3>Project Completion Rate(Without QC and Completion Form)</h3>
            <p>{{ $totalAssignProjectsSum }} Dollar assigned </p>
            <p>{{ $ProjectCompletionWithoutQCCountbyCost }} Dollar completed </p>
            <p>Percentage: {{ number_format($ProjectCompletionRatebyCostWithoutQC, 2) }}% </p>

            <p>{{ $totalAssignProjectsRow }} Projects assigned </p>
            <p>{{ $ProjectCompletionWithoutQCCountbyRow }} Projects completed </p>
            <p>Percentage: {{ number_format($projectsCompletionRatebyRowWithoutQC, 2) }}% </p>


            @endif
            {{----------------------- Project manager transaction data about payment release ------------------------------}}
            <div>
                <h3> Project Manager Transaction </h3>
                @if (isset($pm_pending_milestone_value_upto_last_month))
                <h5>Pending Amount(upto last month): {{ number_format($pm_pending_milestone_value_upto_last_month, 2) }} Dollar</h5>
                <h5>Total Released Amount(this Cycle): {{ $pm_released_amount_month }} Dollar </h5>
                <h5>Total Assigned Amount(For this Cycle): {{ $RunningtotalAssignMilestonesCost }} Dollar </h5>
                <h5>Total release amount (For this cycles projects): {{$pm_released_amount_this_month_create }} Dollar </h5>
                <h5>Total Unreleased Amount(For this Cycle): {{$pm_unreleased_amount_month}} Dollar </h5>
                <h5>Total unrelease amount (Overall): {{ $pm_pending_milestone_value }} Dollar </h5><br>
                @endif
                <h3> Project Manager Transaction Data </h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>SL NO</th>
                            <th>Payment Release </th>
                            <th>Project Manager Name</th>
                            <th>Client Name</th>
                            {{-- <th>Milestone ID</th> --}}
                            <th>Project Name</th>
                            <th>Project Start Date</th>
                            <th>Project Budget</th>
                            <th>Unreleased Amount for Project</th>
                            <th>Milestone Name</th>
                            {{-- <th>Project ID</th> --}}
                            <th>Released Amount</th>
                            <th>Total Release Amount</th>


                        </tr>
                    </thead>
                    <tbody>
                        @php
                        if(isset($transaction_amount_dataview))
                        $dicrease = $pm_released_amount_month;
                        @endphp
                        @if(isset($transaction_amount_dataview))
                        @foreach ($transaction_amount_dataview as $key => $row)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{ $row->paid_on }}</td>
                            <td>{{ $row->manager_name }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->project_name }}</td>
                            <td>{{ $row->start_date->format('Y-m-d') }}</td>
                            <td>{{ $row->project_budget }}</td>
                            <td>{{round($row->project_budget- $row->released_amount_project,2) }}</td>
                            {{-- <td>{{ $row->milestone_id }}</td> --}}
                            <td>{{ $row->milestone_title }}</td>
                            {{-- <td>{{ $row->id }}</td> --}}
                            <td>{{ $row->cost }}</td>
                            <td>{{ $dicrease}}</td>
                            <?php $dicrease = $dicrease - $row->cost; ?>

                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            {{-------------------------END of Project Manager transaction data about payment release --------------------------------------}}
            <h3> Milestone History </h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>SL NO</th>
                        <th>Project Manager ID</th>
                        <th>Client ID</th>
                        <th>Client Name</th>
                        <th>Milestone ID</th>
                        <th>Milestone Title</th>
                        <th>Project ID</th>
                        <th>Project Name</th>
                        <th>Project Budget</th>
                        <th>Milestone Cost</th>
                        <th>Milestone Start</th>
                        <th>Milestone Complete</th>

                    </tr>
                </thead>
                <tbody>
                    @if(isset($dataview))
                    @foreach ($dataview as $key => $row)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $row->pm_id }}</td>
                        <td>{{ $row->client_id }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->milestone_id }}</td>
                        <td>{{ $row->milestone_title }}</td>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->project_name }}</td>
                        <td>{{ $row->project_budget }}</td>
                        <td>{{ $row->cost }}</td>
                        <td>{{ $row->created_at }}</td>
                        <td>{{ $row->paid_on }}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <br><br>

            <table class="table">
                <thead>
                    <tr>
                        <th>SL NO</th>
                        <th>Project Manager ID</th>
                        <th>Task ID</th>
                        <th>Task Name</th>
                        <th>Project Name</th>
                        <th>Task Start</th>
                        <th>Task Complete</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($dataview))
                    @foreach ($datafortasks as $key => $row)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $row->pm_id }}</td>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->heading }}</td>
                        <td>{{ $row->project_name }}</td>
                        <td>{{ $row->start_date }}</td>
                        <td>{{ $row->updated_at }}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

            <br><br>

            <h3>Projects Data (Running)</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>SL NO</th>
                        <th>Client Name</th>
                        <th>Project Name</th>
                        <th>Project Budget</th>
                        <th>Project Status</th>
                        <th>Start Time</th>
                        <th>Last Update Time</th>
                        <th>Status</th>

                    </tr>

                </thead>
                <tbody> @if(isset($dataviewforProject))
                    @foreach ($dataviewforProject as $key => $row)
                    @php
                    $startDate = \Carbon\Carbon::parse($row->start_date);
                    $updatedAt = \Carbon\Carbon::parse($row->updated_at);
                    $dateDifference = $updatedAt->diffInDays($startDate);
                    @endphp
                    @if($dateDifference <= 10
                       &&
                       $row->status !== 'in progress')
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->project_name }}</td>
                            <td>{{ $row->project_budget }}</td>
                            <td>{{ $row->status }}</td>
                            <td>{{ $row->start_date }}</td>
                            <td>{{ $row->updated_at }}</td>
                            <td style="background-color: rgb(68, 120, 68); ">Not Delayed</td>
                        </tr>
                        @else
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->project_name }}</td>
                            <td>{{ $row->project_budget }}</td>
                            <td>{{ $row->status }}</td>
                            <td>{{ $row->start_date }}</td>
                            <td>{{ $row->updated_at }}</td>
                            <td style="background-color: rgb(255, 17, 0); color: white">Delayed</td>
                        </tr>
                        @endif
                        @endforeach
                        @endif
                </tbody>
            </table>
            <br><br>

            <h3>Average Project Completion Time Data </h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>SL NO</th>
                        <th>Client Name</th>
                        <th>Project Name</th>
                        <th>Project Budget</th>
                        <th>Project Status</th>
                        <th>Start Time</th>
                        <th>Last Update Time</th>
                        <th>Total Duration</th>
                    </tr>

                </thead>
                <tbody> @if(isset($averageProjectCompletiontimesData))
                    @foreach ($averageProjectCompletiontimesData as $key => $row)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->project_name }}</td>
                        <td>{{ $row->project_budget }}</td>
                        <td>{{ $row->status }}</td>
                        <td>{{ $row->start_date }}</td>
                        <td>{{ $row->updated_at }}</td>
                        <td style="text-align: center">{{ $row->total_duration }} Days</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <br><br>

            <h3>Project Cancelletion Data</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>SL NO</th>
                        <th>Client Name</th>
                        <th>Project Name</th>
                        <th>Project Budget</th>
                        <th>Project Status</th>
                        <th>Start Time</th>
                        <th>Last Update Time</th>

                    </tr>

                </thead>
                <tbody> @if(isset($totalProjectCancelledData))
                    @foreach ($totalProjectCancelledData as $key => $row)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->project_name }}</td>
                        <td>{{ $row->project_budget }}</td>
                        <td>{{ $row->status }}</td>
                        <td>{{ $row->start_date }}</td>
                        <td>{{ $row->updated_at }}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

        </div>
        {{----------- DELAY FORM REQUEST PROJECT MANAGER TO ADMIN -------------------------}}

        <h3> Project
            Delay Request
            Form</h3>
        <form id="delayRequestForm"
              enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="pm_id">Project Manager ID</label>
                <input type="number"
                       class="form-control"
                       id="pm_id"
                       name="pm_id"
                       required>
            </div>
            <div class="form-group">
                <label for="project_id">Project ID</label>
                <input type="number"
                       class="form-control"
                       id="project_id"
                       name="project_id"
                       required>
            </div>
            {{-- <div class="form-group">
                <label for="extra_time">Extra Days</label>
                <input type="number"
                       class="form-control"
                       id="extra_time"
                       name="extra_time"
                       required>
            </div> --}}
            <div class="form-group">
                <label for="extra_time">Extra Days</label>
                <select class="form-control"
                        id="extra_time"
                        name="extra_time"
                        required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                </select>
            </div>
            <div class="form-group">
                <label for="comment">Comment</label>
                <textarea class="form-control"
                          id="pm_text"
                          name="pm_text"
                          rows="4"
                          required></textarea>
            </div>
            <div class="form-group">
                <label for="images">Images</label>
                <input type="file"
                       class="form-control"
                       id="images"
                       name="images[]"
                       multiple
                       required>
            </div>
            {{-- <button type="button"
                    class="btn btn-primary"
                    id="submitForm">Submit</button> --}}

            <div class="form-group">
                <input type="submit"
                       class=" btn btn-success"
                       value="Save">
            </div>
        </form>
</div>

{{-----------END OF DELAY FORM REQUEST PROJECT MANAGER TO ADMIN -------------------------}}


<div class="form-group">
    <form action="{{ route('dashboard.pmPointsFilter') }}"
          method="POST">
        {{ csrf_field() }}
        <label for="projectmanager">NAME:</label>
        <select name="pmid"
                id="dropdown1"
                required>
            <option value="209">Diner M Islam</option>
            <option value="210">Farhan Rahman</option>
            <option value="245">Mohammad Fazle Rabbi</option>
        </select>
        <label for="start_date">Start Date:</label>
        <input type="date"
               name="start_date"
               id="start_date"
               required>

        <label for="end_date">End Date:</label>
        <input type="date"
               name="end_date"
               id="end_date"
               required>

        <button type="submit"
                class="btn btn-primary">Submit</button>
    </form>
</div>

<div>@if(isset($deliverableProjects))
    <h4 style="color: rgba(16, 47, 200, 0.777)">Date:{{ $startDate1->format('Y-m-d') }} to {{ $endDate1->format('Y-m-d') }} </h4>
    @endif
</div>

{{----------- ------------------------------- Bonus Weekly Hour Point------------------------------------------}}

<div>

    <h3> Bonus Weekly Hour Points (Above 100 hours)</h3>
    <table class="table">
        <thead>
            <tr>
                <th>SL NO</th>
                <th>Project Manager Name</th>
                <th>Weekly First Day </th>
                <th>Weekly Last Day</th>
                <th>Total Hour (Weekly)</th>
                <th>Earned Points</th>

            </tr>

        </thead>
        <tbody> @if(isset($bonus_weekly_hours_points))
            @foreach ($bonus_weekly_hours_points as $key => $row)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{ $row['project_manager'] }}</td>
                <td>{{ $row['start_date'] }}</td>
                <td>{{ $row['end_date'] }}</td>
                <td>{{ $row['total_weekly_hour'] }} Hours</td>
                <td>{{ $row['bonus_earned_points']}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

    @if(isset($bonus_sum_weekly_hours_points))
    <h4>Total Earned Bonus Points: {{$bonus_sum_weekly_hours_points}}</h4>
    @endif
</div>


{{----------- -------------------------------End of Bonus Weekly Hour Point------------------------------------------}}

{{----------- ------------------------------- Weekly Billable Hour Point------------------------------------------}}

<div>

    <h3>Weekly Billable Hour Points(3% of Hourly Projects)</h3>
    <table class="table">
        <thead>
            <tr>
                <th>SL NO</th>
                <th>Project Manager Name</th>
                <th>Weekly First Day </th>
                <th>Weekly Last Day</th>
                <th>Total Billable Hour (Weekly)</th>
                <th>Earned Points</th>

            </tr>

        </thead>
        <tbody> @if(isset($weekly_billable_hours_points))
            @foreach ($weekly_billable_hours_points as $key => $row)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{ $row['project_manager'] }}</td>
                <td>{{ $row['start_date'] }}</td>
                <td>{{ $row['end_date'] }}</td>
                <td>{{ $row['total_weekly_billable_hour'] }} Dollar</td>
                <td>{{ $row['earned_points']}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

    @if(isset($sum_weekly_billable_hours_points))
    <h4>Total Earned Bonus Points: {{$sum_weekly_billable_hours_points}}</h4>
    @endif
</div>


{{----------- -------------------------------End of Weekly Billable Hour Point------------------------------------------}}

{{----------- ------------------------------- Weekly Project Complete Bonus Point------------------------------------------}}

<div>

    <h3>Weekly Project Completion Bonus Point</h3>
    <table class="table">
        <thead>
            <tr>
                <th>SL NO</th>
                <th>Project ID</th>
                <th>Project Manager Name</th>
                <th>Client Name</th>
                <th>Project Name</th>
                <th>Project Budget</th>
                <th>Form Fillup Date </th>
                <th>Start Date </th>
                <th>Complete Date</th>



            </tr>

        </thead>
        <tbody> @if(isset($completed_projects_count_data))
            @foreach ($completed_projects_count_data as $key => $row)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{ $row->id }}</td>
                <td>{{ $row->manager_name }}</td>
                <td>{{ $row->client_name }}</td>
                <td>{{ $row->project_name }}</td>
                <td>{{ $row->project_budget }}</td>
                <td>{{ $row->sales_start_date }}</td>
                <td>{{ $row->start_date }}</td>
                <td>{{ $row->updated_at }}</td>

            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

    @if(isset($completed_projects_count_points))
    <h4>Total Earned Bonus Points: {{$completed_projects_count_points}}</h4>
    @endif
</div>


{{----------- -------------------------------End of Weekly Project Complete Bonus Point------------------------------------------}}




{{----------- -------------------------------Deadline Comparision with Complete time Data------------------------------------------}}
<div>

    <h3>Deadline Time Comparison with Complete Time </h3>
    <table class="table">
        <thead>
            <tr>
                <th>SL NO</th>
                <th>Project ID</th>
                <th>Project Manager Name</th>
                <th>Client Name</th>
                <th>Project Name</th>
                <th>Start Date </th>
                <th>Deadline Date</th>
                <th>Complete Date</th>
                <th>Project Budget</th>
                <th>Earned Points</th>

            </tr>

        </thead>
        <tbody> @if(isset($project_deadline_complete_data))
            @foreach ($project_deadline_complete_data as $key => $row)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{ $row->id }}</td>
                <td>{{ $row->manager_name }}</td>
                <td>{{ $row->client_name }}</td>
                <td>{{ $row->project_name }}</td>
                <td>{{ $row->start_date }}</td>
                <td>{{ $row->deadline }}</td>
                <td>{{ $row->updated_at }}</td>
                <td>{{ $row->project_budget }}</td>
                <td>{{ $project_deadline_complete_points[$row->id]}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

    @if(isset($total_project_deadline_complete_points))
    <h4>Total Earned Points: {{$total_project_deadline_complete_points}}</h4>
    @endif
</div>




{{----------- -------------------------------END of Deadline Comparision with Complete time Data-------------------------------------------}}

{{----------- -------------------------------Estimation Comparision Data------------------------------------------}}

<div>

    <h3>Estimate Time Comparison with Complete Time </h3>
    <table class="table">
        <thead>
            <tr>
                <th>SL NO</th>
                <th>Project ID</th>
                <th>Project Manager Name</th>
                <th>Client Name</th>
                <th>Project Name</th>
                <th>Estimate Time (Minutes)</th>
                <th>Complete Time (Minutes)</th>
                <th>Accuracy</th>
                <th>Earned Points</th>

            </tr>

        </thead>
        <tbody> @if(isset($estimate_log_time_date))
            @foreach ($estimate_log_time_date as $key => $row)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{ $row->id }}</td>
                <td>{{ $row->manager_name }}</td>
                <td>{{ $row->client_name }}</td>
                <td>{{ $row->project_name }}</td>
                <td>{{ $row->estimation_time * 60 }}</td>
                <td>{{ $row->project_total_minutes }}</td>
                <td>{{ number_format($manager_estimate_percentage[$row->id],2) }}%</td>
                <td>{{ $manager_estimate_points[$row->id]}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

    @if(isset($total_estimate_points))
    <h4>Total Earned Points: {{$total_estimate_points}}</h4>
    @endif
</div>
{{----------- -------------------------------END of Estimation Comparision Data------------------------------------------}}




{{----------- -------------------------------Deliverable Points Data------------------------------------------}}
<div>
    <h3>Deliverable Points Data (Accept By Project Manager) </h3>
    <table class="table">
        <thead>
            <tr>
                <th>SL NO</th>
                <th>Project ID</th>
                <th>Project Manager Name</th>
                <th>Client Name</th>
                <th>Project Name</th>
                <th>Points Earned</th>
                <th>Start Date</th>
                <th>Signing Date</th>
                <th>Time Difference</th>

            </tr>

        </thead>
        <tbody> @if(isset($deliverableProjects))
            @foreach ($deliverableProjects as $key => $row)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$row->id}}</td>
                <td>{{ $row->manager_name }}</td>
                <td>{{ $row->client_name }}</td>
                <td>{{ $row->project_name }}</td>
                <td>{{ $deliverablePoints[$row->id] }}</td>
                {{-- <td>{{ $row->start_date }}</td> --}}
                <td>{{ $row->min_created_at }}</td>
                <td>{{ $row->created_at }}</td>
                <td>{{ $row->time_difference }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    @if(isset($deliverableProjects))
    <h4>Total Earned Points: {{$totalDeliverablePoints}}</h4>
    @endif

</div>


<div>

    <h3>Deliverable Points Data (Assigned By Sales) </h3>
    <table class="table">
        <thead>
            <tr>
                <th>SL NO</th>
                <th>Project ID</th>
                <th>Project Manager Name</th>
                <th>Client Name</th>
                <th>Project Name</th>
                <th>Points Earned</th>
                <th>Form Fillup Date</th>
                <th>Signing Date</th>
                <th>Time Difference</th>

            </tr>

        </thead>
        <tbody> @if(isset($deliverableProjectsAssignedBySales))
            @foreach ($deliverableProjectsAssignedBySales as $key => $row)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{ $row->id }}</td>
                <td>{{ $row->manager_name }}</td>
                <td>{{ $row->client_name }}</td>
                <td>{{ $row->project_name }}</td>
                <td>{{ $deliverablePointsAssignedBySales[$row->id] }}</td>
                <td>{{ $row->sales_start_date }}</td>
                <td>{{ $row->created_at }}</td>
                <td>{{ $row->time_difference }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    @if(isset($deliverableProjectsAssignedBySales))
    <h4>Total Earned Points: {{$totalDeliverablePointsAssignedBySales}}</h4>
    @endif

</div>
{{----------- -------------------------------END of Deliverable Points Data------------------------------------------}}

<div>
    @php
    $users= App\Models\User::where('role_id',5)->get();
    @endphp
    <div class="form-group">
        <form action="{{ route('dashboard.developerPointsFilter') }}"
              method="POST">
            {{ csrf_field() }}
            <label for="projectmanager">NAME:</label>
            <select name="developerID"
                    id="dropdown1"
                    required>
                @foreach($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
                {{-- <option value="213">Md. Rakib Hossain</option>
                <option value="214">Md. Mahfuz Khan</option>
                <option value="215">Hillol Das Gupta</option>
                <option value="223">Mehedi Hasan Polash</option>
                <option value="245">Mohammad Fazle Rabbi</option>
                <option value="224">Md. Shakib Ahmed</option>
                <option value="225">Mohammad Farhad</option>
                <option value="226">Md. Rasedul Islam</option>
                <option value="2062">Mainul Hoque Rakib</option>
                <option value="2063">Md. Saddam Hossain (Sh Arif)</option> --}}
                @endforeach
            </select>
            <label for="start_date">Start Date:</label>
            <input type="date"
                   name="start_date"
                   id="start_date"
                   required>

            <label for="end_date">End Date:</label>
            <input type="date"
                   name="end_date"
                   id="end_date"
                   required>

            <button type="submit"
                    class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div>@if(isset($developer_estimated_time_compared_log_time))
        <h4 style="color: rgba(16, 47, 200, 0.777)">Date:{{ $startDate1->format('Y-m-d') }} to {{ $endDate1->format('Y-m-d') }} </h4>
        @endif
    </div>
    {{-------------------------------Developer Log Time Compared with estimated Time--------------------------------------------}}
    <div>

        <h3>Developer Log Time Compared with estimated Time </h3>
        <table class="table">
            <thead>
                <tr>
                    <th>SL NO</th>
                    <th>Developer Name</th>
                    <th>Task ID</th>
                    <th>Task Name</th>
                    <th>Total Estimated Time (minutes)</th>
                    <th>Total Log Time (minutes)</th>
                    <th>Percentage</th>
                    <th>Complete Date</th>


                </tr>

            </thead>
            <tbody> @if(isset($developer_estimated_time_compared_log_time))
                @foreach ($developer_estimated_time_compared_log_time as $key => $row)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{ $row->developer_name }}</td>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->task_name }}</td>
                    <td>{{ $row->total_estimated_time_minutes }}</td>
                    <td>{{ $row->task_total_minutes }}</td>
                    <td>{{ round($row->percentage_compared_log_time,2) }}%</td>
                    <td>{{ $row->updated_at }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        @if(isset($bonus_point_estimate_time))
        <h4> Earned Bonus Points( not more than 5% of the cases): {{$bonus_point_estimate_time}} points</h4>
        @endif

    </div>

    {{------------------------------- END of Developer Log Time Compared with estimated Time-------------------------------------------}}


    {{-------------------------------Developer Track time for bonus points-------------------------------------------}}
    <div>

        <h3>Developer Track Time (above 165 & 180 hours)</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>SL NO</th>
                    <th>Developer Name</th>
                    <th>Task ID</th>
                    <th>Task Name</th>
                    <th>Total Track Time (minutes)</th>
                    <th>Total Track Time (hours)</th>
                    <th>Complete Date</th>


                </tr>

            </thead>
            <tbody> @if(isset($developer_track_time))
                @foreach ($developer_track_time as $key => $row)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{ $row->developer_name }}</td>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->task_name }}</td>
                    <td>{{ $row->task_total_minutes }}</td>
                    <td>{{round( $row->task_total_hours,2) }}</td>
                    <td>{{ $row->updated_at }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        @if(isset($bonus_point_track_time))
        <h4> Total Track Time (hours): {{round($total_developer_track_time,2)}} hours</h4>
        <h4> Earned Bonus Points( above 165 & 180 hours): {{$bonus_point_track_time}} points</h4>
        @endif

    </div>

    {{-------------------------------END of Developer Track time for bonus points--------------------------------------------}}


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


    <script>
        $("#delayRequestForm").submit(function(e){
      
            e.preventDefault();
             const formElement = document.getElementById('delayRequestForm');
             const formData = new FormData(formElement);
           //var formData  = new FormData(jQuery('#delayRequestForm')[0]);
            //console.log(formData);

            // $.ajaxSetup({
            // headers: {
            // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // }
            // });

            $.ajax({
                url:"{{route("dashboard.delayRequestForm")}}",
                type:'POST',
                data:formData,
                contentType:false,
                processData:false,
                success:function(data)
                {
                   
                    document.getElementById('delayRequestForm').reset();
                },
            })


        });
    
    
    </script>


    </body>

    </html>


    {{-- @push('scripts')
    <script src="{{ asset('vendor/jquery/daterangepicker.min.js') }}"></script>
    <script type="text/javascript">
        @php
            $startDate = \Carbon\Carbon::now()->startOfMonth()->subMonths(1)->addDays(20);
            $endDate = \Carbon\Carbon::now()->startOfMonth()->addDays(20);
        @endphp
        $(function() {
            var format = '{{ global_setting()->moment_format }}';
            var startDate = "{{ $startDate->format(global_setting()->date_format) }}";
            var endDate = "{{ $endDate->format(global_setting()->date_format) }}";
            var picker = $('#datatableRange2');
            var start = moment(startDate, format);
            var end = moment(endDate, format);

            function cb(start, end) {
                $('#datatableRange2').val(start.format('{{ global_setting()->moment_date_format }}') +
                    ' @lang("app.to") ' + end.format( '{{ global_setting()->moment_date_format }}'));
                $('#reset-filters').removeClass('d-none');
            }

            $('#datatableRange2').daterangepicker({
                locale: daterangeLocale,
                linkedCalendars: false,
                startDate: start,
                endDate: end,
                ranges: daterangeConfig,
                opens: 'left',
                parentEl: '.dashboard-header'
            }, cb);

            $('#datatableRange2').on('apply.daterangepicker', function(ev, picker) {
                showTable();
            });
        });
    </script>
    <script type="text/javascript">
        $(".dashboard-header").on("click", ".ajax-tab", function(event) {
            event.preventDefault();


            var dateRangePicker = $('#datatableRange2').data('daterangepicker');
            var startDate = $('#datatableRange').val();

            if (startDate == '') {
                startDate = null;
                endDate = null;
            } else {
                startDate = dateRangePicker.startDate.format('{{ global_setting()->moment_date_format }}');
                endDate = dateRangePicker.endDate.format('{{ global_setting()->moment_date_format }}');
            }

            const requestUrl = this.href;
            //alert(requestUrl);

            $.easyAjax({
                url: requestUrl,
                blockUI: true,
                container: "#emp-dashboard",
                historyPush: true,
                data: {
                    startDate: startDate,
                    endDate: endDate
                },
                blockUI: true,
                success: function(response) {
                    if (response.status == "success") {
                        $('#emp-dashboard').html(response.html);
                        init('#emp-dashboard');
                    }
                }
            });
            $.easyAjax({
                url: requestUrl,
                blockUI: true,
                container: "#emp-dashboard2",
                historyPush: true,
                data: {
                    startDate: startDate,
                    endDate: endDate
                },
                blockUI: true,
                success: function(response) {
                    if (response.status == "success") {
                        $('#emp-dashboard2').html(response.html);
                        init('#emp-dashboard2');
                    }
                }
            });
        });

        function showTable() {
            var dateRangePicker = $('#datatableRange2').data('daterangepicker');
            var startDate = $('#datatableRange').val();
            if (startDate == '') {
                startDate = null;
                endDate = null;
            } else {
                startDate = dateRangePicker.startDate.format('{{ global_setting()->moment_date_format }}');
                endDate = dateRangePicker.endDate.format('{{ global_setting()->moment_date_format }}');
            }

            const requestUrl = this.href;


            $.easyAjax({
                url: requestUrl,
                blockUI: true,
                container: "#emp-dashboard",
                data: {
                    startDate: startDate,
                    endDate: endDate
                },
                blockUI: true,
                success: function(response) {

                    if (response.status == "success") {

                        $('#emp-dashboard').html(response.html);

                        init('#emp-dashboard');
                    }
                }
            });
            $.easyAjax({
                url: requestUrl,
                blockUI: true,
                container: "#emp-dashboard2",
                data: {
                    startDate: startDate,
                    endDate: endDate
                },
                blockUI: true,
                success: function(response) {

                    if (response.status == "success") {

                        $('#emp-dashboard2').html(response.html2);

                        init('#emp-dashboard2');

                    }
                }
            });
        }
    </script>
    @if (!is_null($viewEventPermission) && $viewEventPermission != 'none')
    <script src="{{ asset('vendor/full-calendar/main.min.js') }}"></script>
    <script src="{{ asset('vendor/full-calendar/locales-all.min.js') }}"></script>
    <script>
        var initialLocaleCode = '{{ user()->locale }}';
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: initialLocaleCode,
                timeZone: '{{ global_setting()->timezone }}',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                navLinks: true, // can click day/week names to navigate views
                selectable: false,
                initialView: 'listWeek',
                selectMirror: true,
                select: function(arg) {
                    addEventModal(arg.start, arg.end, arg.allDay);
                    calendar.unselect()
                },
                eventClick: function(arg) {
                    getEventDetail(arg.event.id,arg.event.extendedProps.event_type);
                },
                editable: false,
                dayMaxEvents: true, // allow "more" link when too many events
                events: {
                    url: "{{ route('dashboard.private_calendar') }}",
                },
                eventDidMount: function(info) {
                    $(info.el).css('background-color', info.event.extendedProps.bg_color);
                    $(info.el).css('color', info.event.extendedProps.color);
                    $(info.el).find('td.fc-list-event-title').prepend('<i class="fa '+info.event.extendedProps.icon+'"></i>&nbsp;&nbsp;');
                    // tooltip for leaves
                    if(info.event.extendedProps.event_type == 'leave'){
                        $(info.el).find('td.fc-list-event-title > a').css('cursor','default'); // list view cursor for leave
                        $(info.el).css('cursor','default')
                        $(info.el).tooltip({
                            title: info.event.extendedProps.name,
                            container: 'body',
                            delay: { "show": 50, "hide": 50 }
                        });
                    }
                },
                eventTimeFormat: { // like '14:30:00'
                    hour: global_setting.time_format == 'H:i' ? '2-digit' : 'numeric',
                    minute: '2-digit',
                    meridiem: global_setting.time_format == 'H:i' ? false : true
                }
            });

            calendar.render();

            // Task Detail show in sidebar
            var getEventDetail = function(id,type) {
                if(type == 'ticket')
                {
                    var url = "{{ route('tickets.show', ':id') }}";
                    url = url.replace(':id', id);
                    window.location = url;
                    return true;
                }

                if(type == 'leave')
                {
                    return true;
                }

                openTaskDetail();

                switch (type) {
                    case 'task':
                        var url = "{{ route('tasks.show', ':id') }}";
                        break;
                    case 'event':
                        var url = "{{ route('events.show', ':id') }}";
                        break;
                    case 'holiday':
                        var url = "{{ route('holidays.show', ':id') }}";
                        break;
                    case 'leave':
                        var url = "{{ route('leaves.show', ':id') }}";
                        break;
                    default:
                        return 0;
                        break;
                }

                url = url.replace(':id', id);

                $.easyAjax({
                    url: url,
                    blockUI: true,
                    container: RIGHT_MODAL,
                    historyPush: true,
                    success: function(response) {
                        if (response.status == "success") {
                            $(RIGHT_MODAL_CONTENT).html(response.html);
                            $(RIGHT_MODAL_TITLE).html(response.title);
                        }
                    },
                    error: function(request, status, error) {
                        if (request.status == 403) {
                            $(RIGHT_MODAL_CONTENT).html(
                                '<div class="align-content-between d-flex justify-content-center mt-105 f-21">403 | Permission Denied</div>'
                            );
                        } else if (request.status == 404) {
                            $(RIGHT_MODAL_CONTENT).html(
                                '<div class="align-content-between d-flex justify-content-center mt-105 f-21">404 | Not Found</div>'
                            );
                        } else if (request.status == 500) {
                            $(RIGHT_MODAL_CONTENT).html(
                                '<div class="align-content-between d-flex justify-content-center mt-105 f-21">500 | Something Went Wrong</div>'
                            );
                        }
                    }
                });

            };

            // calendar filter
            var hideDropdown = false;

            $('#event-btn').click(function(){
                if(hideDropdown == true)
                {
                    $('#cal-drop').hide();
                    hideDropdown = false;
                }
                else
                {
                    $('#cal-drop').toggle();
                    hideDropdown = true;
                }
            });


            $(document).mouseup(e => {

                const $menu = $('.calendar-action');

                if (!$menu.is(e.target) && $menu.has(e.target).length === 0)
                {
                    hideDropdown = false;
                    $('#cal-drop').hide();
                }
            });


            $('.cal-filter').on('click', function() {

                var filter = [];

                $('.filter-check:checked').each(function() {
                    filter.push($(this).val());
                });

                if(filter.length < 1){
                    filter.push('None');
                }

                calendar.removeAllEventSources();
                calendar.addEventSource({
                    url: "{{ route('dashboard.private_calendar') }}",
                    extraParams: {
                        filter: filter
                    }
                });

                filter = null;
            });
    </script>
    @endif

    <script>
        $('#save-dashboard-widget').click(function() {
            $.easyAjax({
                url: "{{ route('dashboard.widget', 'private-dashboard') }}",
                container: '#privateDashboardWidgetForm',
                blockUI: true,
                type: "POST",
                redirect: true,
                data: $('#privateDashboardWidgetForm').serialize(),
                success: function() {
                    window.location.reload();
                }
            })
        });

        $('#clock-in').click(function() {
            const url = "{{ route('attendances.clock_in_modal') }}";
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });

        $('.request-shift-change').click(function() {
            var id = $(this).data('shift-schedule-id');
            var url = "{{ route('shifts-change.edit', ':id') }}";
            url = url.replace(':id', id);

            $(MODAL_DEFAULT + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_DEFAULT, url);
        });

        $('#view-shifts').click(function() {
            const url = "{{ route('employee-shifts.index') }}";
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });

        /** clock timer start here */
        function currentTime() {
            let date = new Date();
            date = moment.tz(date, "{{ global_setting()->timezone }}");

            let hour = date.hour();
            let min = date.minutes();
            let sec = date.seconds();
            let midday = "AM";
            midday = (hour >= 12) ? "PM" : "AM";
            @if (global_setting()->time_format == 'h:i A')
                hour = (hour == 0) ? 12 : ((hour > 12) ? (hour - 12) : hour); /* assigning hour in 12-hour format */
            @endif
                hour = updateTime(hour);
            min = updateTime(min);
            document.getElementById("clock").innerText = `${hour} : ${min} ${midday}`
            const time = setTimeout(function() {
                currentTime()
            }, 1000);
        }

        /* appending 0 before time elements if less than 10 */
        function updateTime(timer) {
            if (timer < 10) {
                return "0" + timer;
            } else {
                return timer;
            }
        }

        @if (!is_null($currentClockIn))
        $('#clock-out').click(function() {

            var token = "{{ csrf_token() }}";
            var currentLatitude = document.getElementById("current-latitude").value;
            var currentLongitude = document.getElementById("current-longitude").value;

            $.easyAjax({
                url: "{{ route('attendances.update_clock_in') }}",
                type: "GET",
                data: {
                    currentLatitude: currentLatitude,
                    currentLongitude: currentLongitude,
                    _token: token,
                    id: '{{ $currentClockIn->id }}'
                },
                success: function(response) {
                    if (response.status == 'success') {
                        window.location.reload();
                    }
                }
            });
        });
        @endif

        $('.keep-open .dropdown-menu').on({
            "click": function(e) {
                e.stopPropagation();
            }
        });

        $('#weekly-timelogs').on('click', '.week-timelog-day', function() {
            var date = $(this).data('date');

            $.easyAjax({
                url: "{{ route('dashboard.week_timelog') }}",
                container: '#weekly-timelogs',
                blockUI: true,
                type: "POST",
                redirect: true,
                data: {
                    'date': date,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#weekly-timelogs').html(response.html)
                }
            })
        });

    </script>
    <script>
        $(document).ready(function() {
            var todayDate = moment();
            var monthDate = moment();
            
            $('.todayDate').text(todayDate.format('dddd LL'));

            var todayOnlyDate = moment(todayDate).format('DD');
            if (todayOnlyDate > 21) {
                $('.monthDate').text('21st ' + moment(monthDate).format('MMMM, YYYY')+' to 20th '+moment(monthDate).add(1, 'month').format('MMMM, YYYY'));
            } else {
                $('.monthDate').text('21st ' + moment(monthDate).subtract(1, 'month').format('MMMM, YYYY')+' to 20th '+moment(monthDate).startOf('month').add(20, 'day').format('MMMM, YYYY'));
            }

            $('.fc-prev-button').click(function() {
                var mode = $(this).attr('date-mode');
                if (mode == 'month') {
                    if(todayOnlyDate > 21) {
                        monthDate = moment(monthDate).subtract(1, 'month');
                    } else {
                        monthDate = moment(monthDate).subtract(2, 'month');
                    }
                    $(this).next().text('21st ' + moment(monthDate).format('MMMM, YYYY')+ ' to 20th '+moment(monthDate).add(1, 'month').format('MMMM, YYYY'));
                    date = monthDate
                } else {
                    todayDate = moment(todayDate).subtract(1, 'days');
                    $(this).next().text(todayDate.format('dddd LL'));
                    date = todayDate
                }

                getData(mode, $(this), date);
            });

            $('.fc-next-button').click(function() {
                var mode = $(this).attr('date-mode');
                if (mode == 'month') {
                    monthDate = moment(monthDate).add(1, 'month');
                    $(this).prev().text('21st ' + moment(monthDate).format('MMMM, YYYY')+' to 20th '+moment(monthDate).add(1, 'month').format('MMMM, YYYY'));
                    date = monthDate
                } else {
                    todayDate = moment(todayDate).add(1, 'days');
                    $(this).prev().prev().text(todayDate.format('dddd LL'));
                    date = todayDate
                }
                
                getData(mode, $(this), date);
            });

            $('.fc-today-button').click(function() {
                todayDate = moment();
            })
        });

        function getData(mode, disableButton, date) {
            $.easyAjax({
                url: this.href,
                type: "GET",
                disableButton: true,
                buttonSelector: disableButton,
                data: {
                    mode: mode,
                    startDate: date.format('YYYY-MM-DD'),
                },
                success: function(resp) {
                    $('#'+mode+'Html').html(resp.html);
                }
            })
        }

        @php
            $startDate = \Carbon\Carbon::now()->startOfMonth();
            $endDate = \Carbon\Carbon::now();
        @endphp
        $(function() {
            var format = '{{ global_setting()->moment_format }}';
            var startDate = "{{ $startDate->format(global_setting()->date_format) }}";
            var endDate = "{{ $endDate->format(global_setting()->date_format) }}";
            var picker = $('#datatableRange2');
            var start = moment(startDate, format);
            var end = moment(endDate, format);

            function cb(start, end) {
                $('#datatableRange2').val(start.format('{{ global_setting()->moment_date_format }}') +
                    ' @lang("app.to") ' + end.format( '{{ global_setting()->moment_date_format }}'));
                $('#reset-filters').removeClass('d-none');
            }

            $('#datatableRange2').daterangepicker({
                locale: daterangeLocale,
                linkedCalendars: false,
                startDate: start,
                endDate: end,
                ranges: daterangeConfig,
                opens: 'left',
                parentEl: '.dashboard-header'
            }, cb);

            $('#datatableRange2').on('apply.daterangepicker', function(ev, picker) {
                showTable();
            });

            function showTable() {
                var dateRangePicker = $('#datatableRange2').data('daterangepicker');
                var startDate = $('#datatableRange').val();
                if (startDate == '') {
                    startDate = null;
                    endDate = null;
                } else {
                    startDate = dateRangePicker.startDate.format('{{ global_setting()->moment_date_format }}');
                    endDate = dateRangePicker.endDate.format('{{ global_setting()->moment_date_format }}');
                }

                const requestUrl = this.href;


                $.easyAjax({
                    url: requestUrl,
                    blockUI: true,
                    data: {
                        startDate: startDate,
                        endDate: endDate,
                        mode: 'general'
                    },
                    blockUI: true,
                    success: function(resp) {
                        if (resp.status == "success") {
                            $('#generalHtml').html(resp.html)
                        }
                    }
                });
            }
        });
    </script>

    @if (attendance_setting()->radius_check == 'yes' || attendance_setting()->save_current_location)
    <script>
        var currentLatitude = document.getElementById("current-latitude");
            var currentLongitude = document.getElementById("current-longitude");
            var x = document.getElementById("current-latitude");

            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    // x.innerHTML = "Geolocation is not supported by this browser.";
                }
            }

            function showPosition(position) {
                currentLatitude.value = position.coords.latitude;
                currentLongitude.value = position.coords.longitude;
            }
            getLocation();

    </script>
    @endif
    @endpush enan --}}