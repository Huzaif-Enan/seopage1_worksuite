<?php

namespace App\Http\Controllers;

use App\Helper\Reply;
use App\Models\AttendanceSetting;
use App\Models\DashboardWidget;
use App\Models\EmployeeDetails;
use App\Models\Event;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\ProjectTimeLog;
use App\Models\ProjectTimeLogBreak;
use App\Models\Task;
use App\Models\TaskboardColumn;
use App\Models\Ticket;
use App\Models\PMAssign;
use App\Models\Project;
use App\Traits\ClientDashboard;
use App\Traits\ClientPanelDashboard;
use App\Traits\CurrencyExchange;
use App\Traits\EmployeeDashboard;
use App\Traits\FinanceDashboard;
use App\Traits\HRDashboard;
use App\Traits\OverviewDashboard;
use App\Traits\ProjectDashboard;
use App\Traits\TicketDashboard;
use App\Traits\webdevelopmentDashboard;
use App\Traits\LeadDashboard;
use App\Traits\DeveloperDashboard;
use App\Traits\UxUiDashboard;
use App\Traits\GraphicsDashboard;
use App\Traits\SalesDashboard;
use App\Traits\PmDashboard;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Froiden\Envato\Traits\AppBoot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ClientDelay;
use PHPUnit\Framework\ActualValueIsNotAnObjectException;

class DashboardController extends AccountBaseController
{
    use AppBoot, CurrencyExchange, OverviewDashboard, EmployeeDashboard, ProjectDashboard, ClientDashboard, HRDashboard, webdevelopmentDashboard, TicketDashboard, FinanceDashboard, ClientPanelDashboard, LeadDashboard, DeveloperDashboard, UxUiDashboard, GraphicsDashboard, SalesDashboard, PmDashboard;

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.dashboard';
        $this->middleware(function ($request, $next) {
            $this->viewOverviewDashboard = user()->permission('view_overview_dashboard');
            $this->viewProjectDashboard = user()->permission('view_project_dashboard');
            $this->viewClientDashboard = user()->permission('view_client_dashboard');
            $this->viewHRDashboard = user()->permission('view_hr_dashboard');
            $this->viewTicketDashboard = user()->permission('view_ticket_dashboard');
            $this->viewFinanceDashboard = user()->permission('view_finance_dashboard');
            return $next($request);
        });
    }

    /**
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|mixed|void
     */
    public function index()
    {
        $this->isCheckScript();
        if (in_array('Lead Developer', user_roles())) {
            return $this->LeadDashboard();
        }
        if ($this->user->role_id == 4) {
            return $this->PmDashboard();
        }
        if ($this->user->role_id == 5) {
            return $this->DeveloperDashboard();
        }
        if ($this->user->role_id == 9) {
            return $this->UxUiDashboard();
        }
        if ($this->user->role_id == 7) {
            return $this->SalesDashboard();
        }
        if ($this->user->role_id == 10) {
            return $this->GraphicsDashboard();
        }
        if (in_array('employee', user_roles())) {
            return $this->employeeDashboard();
        }

        if (in_array('client', user_roles())) {
            return $this->clientPanelDashboard();
        }
    }

    public function widget(Request $request, $dashboardType)
    {
        $data = $request->all();
        unset($data['_token']);
        DashboardWidget::where('status', 1)->where('dashboard_type', $dashboardType)->update(['status' => 0]);

        foreach ($data as $key => $widget) {
            DashboardWidget::where('widget_name', $key)->where('dashboard_type', $dashboardType)->update(['status' => 1]);
        }

        return Reply::success(__('messages.updatedSuccessfully'));
    }

    public function checklist()
    {
        if (in_array('admin', user_roles())) {
            $this->isCheckScript();
            return view('dashboard.checklist', $this->data);
        }
    }

    /**
     * @return array|\Illuminate\Http\Response
     */
    public function memberDashboard()
    {
        abort_403(!in_array('employee', user_roles()));
        return $this->employeeDashboard();
    }

    public function advancedDashboard()
    {

        if (
            in_array('admin', user_roles()) || $this->sidebarUserPermissions['view_overview_dashboard'] == 4
            || $this->sidebarUserPermissions['view_project_dashboard'] == 4
            || $this->sidebarUserPermissions['view_client_dashboard'] == 4
            || $this->sidebarUserPermissions['view_hr_dashboard'] == 4
            || $this->sidebarUserPermissions['view_ticket_dashboard'] == 4
            || $this->sidebarUserPermissions['view_finance_dashboard'] == 4
        ) {

            $tab = request('tab');

            switch ($tab) {
                case 'project':
                    $this->projectDashboard();
                    break;
                case 'client':
                    $this->clientDashboard();
                    break;
                case 'hr':
                    $this->hrDashboard();
                    break;
                case 'ticket':
                    $this->ticketDashboard();
                    break;
                case 'finance':
                    $this->financeDashboard();
                    break;
                case 'web-development':
                    $this->webdevelopmentDashboard();
                    break;
                default:
                    if (in_array('admin', user_roles()) || $this->sidebarUserPermissions['view_overview_dashboard'] == 4) {
                        $this->activeTab = ($tab == '') ? 'overview' : $tab;
                        $this->overviewDashboard();
                    } elseif ($this->sidebarUserPermissions['view_project_dashboard'] == 4) {
                        $this->activeTab = ($tab == '') ? 'project' : $tab;
                        $this->projectDashboard();
                    } elseif ($this->sidebarUserPermissions['view_client_dashboard'] == 4) {
                        $this->activeTab = ($tab == '') ? 'client' : $tab;
                        $this->clientDashboard();
                    } elseif ($this->sidebarUserPermissions['view_hr_dashboard'] == 4) {
                        $this->activeTab = ($tab == '') ? 'hr' : $tab;
                        $this->hrDashboard();
                    } elseif ($this->sidebarUserPermissions['view_finance_dashboard'] == 4) {
                        $this->activeTab = ($tab == '') ? 'finance' : $tab;
                        $this->ticketDashboard();
                    } else if ($this->sidebarUserPermissions['view_ticket_dashboard'] == 4) {
                        $this->activeTab = ($tab == '') ? 'finance' : $tab;
                        $this->financeDashboard();
                    } else if ($this->sidebarUserPermissions['view_ticket_dashboard'] == 4) {
                        $this->activeTab = ($tab == '') ? 'web-development' : $tab;
                        $this->webdevelopmentDashboard();
                    }
                    break;
            }

            if (request()->ajax()) {
                $html = view($this->view, $this->data)->render();
                return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle]);
            }

            if (!isset($this->activeTab)) {
                $this->activeTab = ($tab == '') ? 'overview' : $tab;
            }

            return view('dashboard.admin', $this->data);
        }
    }

    public function accountUnverified()
    {
        return view('dashboard.unverified', $this->data);
    }

    public function weekTimelog()
    {
        $now = now(global_setting()->timezone);
        $attndcSetting = AttendanceSetting::first();
        $this->timelogDate = $timelogDate = Carbon::parse(request()->date);
        $this->weekStartDate = $now->copy()->startOfWeek($attndcSetting->week_start_from);
        $this->weekEndDate = $this->weekStartDate->copy()->addDays(7);
        $this->weekPeriod = CarbonPeriod::create($this->weekStartDate, $this->weekStartDate->copy()->addDays(6)); // Get All Dates from start to end date

        $this->dateWiseTimelogs = ProjectTimeLog::dateWiseTimelogs($timelogDate->toDateString(), user()->id);
        $this->dateWiseTimelogBreak = ProjectTimeLogBreak::dateWiseTimelogBreak($timelogDate->toDateString(), user()->id);

        $this->weekWiseTimelogs = ProjectTimeLog::weekWiseTimelogs($this->weekStartDate->copy()->toDateString(), $this->weekEndDate->copy()->toDateString(), user()->id);
        $this->weekWiseTimelogBreak = ProjectTimeLogBreak::weekWiseTimelogBreak($this->weekStartDate->toDateString(), $this->weekEndDate->toDateString(), user()->id);

        $html = view('dashboard.employee.week_timelog', $this->data)->render();
        return Reply::dataOnly(['html' => $html]);
    }

    public function privateCalendar()
    {
        if (request()->filter) {
            $employee_details = EmployeeDetails::where('user_id', user()->id)->first();
            $employee_details->calendar_view = (request()->filter != false) ? request()->filter : null;
            $employee_details->save();
            session()->forget('user');
        }

        $startDate = Carbon::parse(request('start'));
        $endDate = Carbon::parse(request('end'));

        // get calendar view current logined user
        $calendar_filter_array = explode(',', user()->employeeDetails->calendar_view);

        $eventData = array();

        if (in_array('events', $calendar_filter_array)) {
            // Events
            $model = Event::with('attendee', 'attendee.user');

            $model->where(function ($query) {
                $query->whereHas('attendee', function ($query) {
                    $query->where('user_id', user()->id);
                });
                $query->orWhere('added_by', user()->id);
            });

            $model->whereBetween('start_date_time', [$startDate->toDateString(), $endDate->toDateString()]);

            $events = $model->get();


            foreach ($events as $key => $event) {
                $eventData[] = [
                    'id' => $event->id,
                    'title' => ucfirst($event->event_name),
                    'start' => $event->start_date_time,
                    'end' => $event->end_date_time,
                    'event_type' => 'event',
                    'extendedProps' => ['bg_color' => $event->label_color, 'color' => '#fff', 'icon' => 'fa-calendar']
                ];
            }
        }

        if (in_array('holiday', $calendar_filter_array)) {
            // holiday
            $holidays = Holiday::whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])->get();

            foreach ($holidays as $key => $holiday) {
                $eventData[] = [
                    'id' => $holiday->id,
                    'title' => ucfirst($holiday->occassion),
                    'start' => $holiday->date,
                    'end' => $holiday->date,
                    'event_type' => 'holiday',
                    'extendedProps' => ['bg_color' => '#1d82f5', 'color' => '#fff', 'icon' => 'fa-star']
                ];
            }
        }

        if (in_array('task', $calendar_filter_array)) {
            // tasks
            $completedTaskColumn = TaskboardColumn::completeColumn();
            $tasks = Task::with('boardColumn')
                ->where('board_column_id', '<>', $completedTaskColumn->id)
                ->whereHas('users', function ($query) {
                    $query->where('user_id', user()->id);
                })
                ->where(function ($q) use ($startDate, $endDate) {
                    $q->whereBetween(DB::raw('DATE(tasks.`due_date`)'), [$startDate->toDateString(), $endDate->toDateString()]);

                    $q->orWhereBetween(DB::raw('DATE(tasks.`start_date`)'), [$startDate->toDateString(), $endDate->toDateString()]);
                })->get();

            foreach ($tasks as $key => $task) {
                $eventData[] = [
                    'id' => $task->id,
                    'title' => ucfirst($task->heading),
                    'start' => $task->start_date,
                    'end' => $task->due_date ? $task->due_date : $task->start_date,
                    'event_type' => 'task',
                    'extendedProps' => ['bg_color' => $task->boardColumn->label_color, 'color' => '#fff', 'icon' => 'fa-list']
                ];
            }
        }

        if (in_array('tickets', $calendar_filter_array)) {
            // tickets
            $tickets = Ticket::where('user_id', user()->id)
                ->whereBetween(DB::raw('DATE(tickets.`updated_at`)'), [$startDate->toDateString(), $endDate->toDateString()])->get();

            foreach ($tickets as $key => $ticket) {
                $eventData[] = [
                    'id' => $ticket->id,
                    'title' => ucfirst($ticket->subject),
                    'start' => $ticket->updated_at,
                    'end' => $ticket->updated_at,
                    'event_type' => 'ticket',
                    'extendedProps' => ['bg_color' => '#1d82f5', 'color' => '#fff', 'icon' => 'fa-ticket-alt']
                ];
            }
        }

        if (in_array('leaves', $calendar_filter_array)) {
            // approved leaves of all emoloyees with employee name
            $leaves = Leave::join('leave_types', 'leave_types.id', 'leaves.leave_type_id')
                ->where('leaves.status', 'approved')
                ->select('leaves.id', 'leaves.leave_date', 'leaves.status', 'leave_types.type_name', 'leave_types.color', 'leaves.leave_date', 'leaves.duration', 'leaves.status', 'leaves.user_id')
                ->with('user')
                ->whereBetween(DB::raw('DATE(leaves.`leave_date`)'), [$startDate->toDateString(), $endDate->toDateString()])
                ->get();

            $duration = '';

            foreach ($leaves as $key => $leave) {
                $duration = ($leave->duration == 'half day') ? '( ' . __('app.halfday') . ' )' : '';

                $eventData[] = [
                    'id' => $leave->id,
                    'title' => $duration . ' ' . ucfirst($leave->user->name),
                    'start' => $leave->leave_date->toDateString(),
                    'end' => $leave->leave_date->toDateString(),
                    'event_type' => 'leave',
                    /** @phpstan-ignore-next-line */
                    'extendedProps' => ['name' => 'Leave : ' . ucfirst($leave->user->name), 'bg_color' => $leave->color, 'color' => '#fff', 'icon' => 'fa-plane-departure']
                ];
            }
        }

        return $eventData;
    }

    public function projectManageDetalsOnAdvanceDashboard(Request $request)
    {
        $startDate = Carbon::createFromFormat($this->global->date_format, $request->startDate);
        $endDate = Carbon::createFromFormat($this->global->date_format, $request->endDate);

        $project_counts = PMAssign::where('pm_id', $request->pm_id)->whereBetween('created_at', [$startDate, $endDate])->first();
        if (!is_null($project_counts) && $project_counts->project_count != 0) {
            $project_release_count = Project::where('pm_id', $request->pm_id)->where('due', 0)->whereBetween('created_at', [$startDate, $endDate])->count();
            if ($project_release_count != 0) {
                $total_release_percentage = ($project_release_count / $project_counts->project_count) * 100;
            } else {
                $total_release_percentage = 0;
            }

            $project_cancelation =  Project::where('pm_id', $request->pm_id)->where('status', 'canceled')->whereBetween('created_at', [$startDate, $endDate])->count();
            if ($project_cancelation != 0) {
                $percentage_of_project_cancelation = ($project_cancelation / $project_counts->project_count) * 100;
            } else {
                $percentage_of_project_cancelation = 0;
            }

            $projects_on_hold = Project::where('pm_id', $request->pm_id)->where('status', 'on hold')->whereBetween('created_at', [$startDate, $endDate])->count();
            if ($projects_on_hold != 0) {
                $projects_on_hold_percentage = ($project_counts->project_count / $projects_on_hold) * 100;
            } else {
                $projects_on_hold_percentage = 0;
            }
        } else {
            $total_release_percentage = 0;
            $percentage_of_project_cancelation = 0;
            $projects_on_hold_percentage = 0;
        }
        if (!is_null($project_counts) && $project_counts->amount != 0) {

            $project_cancelation_rate =  Project::where('pm_id', $request->pm_id)->where('status', 'canceled')->whereBetween('created_at', [$startDate, $endDate])->sum('project_budget');
            $percentage_of_project_cancelation_rate = ($project_cancelation_rate / $project_counts->amount) * 100;
        } else {

            $percentage_of_project_cancelation_rate = 0;
        }

        $html = view('dashboard.ajax.projectManageDetalsOnAdvanceDashboard', [
            'pm_id' => $request->pm_id,
            'project_counts' => $project_counts,
            'total_release_percentage' => $total_release_percentage,
            'percentage_of_project_cancelation' => $percentage_of_project_cancelation,
            'percentage_of_project_cancelation_rate' => $percentage_of_project_cancelation_rate,
            'projects_on_hold_percentage' => $projects_on_hold_percentage,
        ])->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }

    ////PROJECT MANAGER PERFORMENCE PARAMETER ////
    public function filter(Request $request)
    {

        // $pmId = auth()->id();
        $pmId = $request->input('pmid');

        $userId = $pmId; // Replace with the actual user ID input
        $username = DB::table('users')->where('id', $userId)->value('name');

        $startDate = $request->input('start_date');
        //$startDate = Carbon::parse($request->startDate1)->format('Y-m-d');
        $endDate = $request->input('end_date');
        $assignEndDate = Carbon::parse($endDate)->addDays(1)->format('Y-m-d');

        $afterAssignStartDate = Carbon::parse($assignEndDate)->addDays(1)->format('Y-m-d');
        $releaseEndDate = Carbon::parse($assignEndDate)->addDays(11)->format('Y-m-d');



        //----------------------total milestone complete by project manager----------------------------------------//
        //valuewise
        $totalCost = DB::table('users')
            ->join('projects', 'users.id', '=', 'projects.pm_id')
            ->join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
            ->join('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
            //->whereNotNull('project_milestones.invoice_id')
            ->whereBetween('payments.paid_on', [$startDate, $releaseEndDate])
            ->whereNotBetween('project_milestones.created_at', [$afterAssignStartDate, $releaseEndDate])
            ->where('users.id', $pmId)
            ->sum('project_milestones.cost');



        $totalCompleteMilestonesCost = $totalCost;

        //countwise

        $totalrow = DB::table('users')
            ->join('projects', 'users.id', '=', 'projects.pm_id')
            ->join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
            ->join('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
            //->whereNotNull('project_milestones.invoice_id')
            ->whereBetween('payments.paid_on', [$startDate, $releaseEndDate])
            ->whereNotBetween('project_milestones.created_at', [$afterAssignStartDate, $releaseEndDate])
            ->where('users.id', $pmId)
            ->count();


        $totalCompleteMilestonesRow = $totalrow;



        //total milestone assigned by project manager//




        $query = Project::join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
            ->leftJoin('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
            ->where('projects.pm_id', $pmId)
            ->where(function ($q1) use ($startDate, $assignEndDate, $releaseEndDate) {
                $q1->whereBetween('project_milestones.created_at', [$startDate, $assignEndDate])
                    ->orWhere(function ($q2) use ($startDate, $releaseEndDate) {
                        $q2->where('project_milestones.created_at', '<', $startDate)
                            ->WhereBetween('payments.paid_on', [$startDate, $releaseEndDate]);
                    });
            });


        $totalAssignMilestonesRow = $query->count(); //rowwise 

        $totalAssignMilestonesCost = $query->sum('cost'); //valuewise 


        //Percentage of milestones 


        if ($totalAssignMilestonesCost != 0) {
            $milestoneCompletionRatebyCost = ($totalCompleteMilestonesCost / $totalAssignMilestonesCost) * 100; //costwise
        }

        if ($totalAssignMilestonesRow != 0) {
            $milestoneCompletionRatebyRow = ($totalCompleteMilestonesRow / $totalAssignMilestonesRow) * 100;  //countwise
        }

        //View milestone history by project manager//
        $dataview = Project::select('payments.paid_on', 'projects.pm_id', 'projects.client_id', 'clients.name', 'projects.id', 'projects.project_name', 'projects.project_budget', 'project_milestones.id as milestone_id', 'project_milestones.milestone_title', 'project_milestones.cost', 'project_milestones.created_at')
            ->join('users', 'users.id', '=', 'projects.pm_id')
            ->join('users as clients', 'clients.id', '=', 'projects.client_id')
            ->join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
            ->leftJoin('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
            ->where('projects.pm_id', $pmId)
            ->whereBetween('project_milestones.created_at', [$startDate, $assignEndDate])
            ->orWhere(function ($query) use ($startDate, $releaseEndDate, $pmId) {
                $query->where('project_milestones.created_at', '<', $startDate)
                    ->WhereBetween('payments.paid_on', [$startDate, $releaseEndDate])
                    ->where('projects.pm_id', $pmId);
            })
            ->orderBy('created_at', 'DESC')
            ->get();


        //----------------------total milestone complete by project manager  running----------------------------------------//
        //valuewise
        $totalCost = DB::table('users')
            ->join('projects', 'users.id', '=', 'projects.pm_id')
            ->join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
            ->join('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
            //->whereNotNull('project_milestones.invoice_id')
            ->whereBetween('payments.paid_on', [$startDate, $releaseEndDate])
            ->whereBetween('project_milestones.created_at', [$startDate, $assignEndDate])
            ->where('users.id', $pmId)
            ->sum('project_milestones.cost');


        $RunningtotalCompleteMilestonesCost = $totalCost;

        //countwise

        $totalrow = DB::table('users')
            ->join('projects', 'users.id', '=', 'projects.pm_id')
            ->join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
            ->join('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
            //->whereNotNull('project_milestones.invoice_id')
            ->whereBetween('payments.paid_on', [$startDate, $releaseEndDate])
            ->whereBetween('project_milestones.created_at', [$startDate, $assignEndDate])
            ->where('users.id', $pmId)
            ->count();


        $RunningtotalCompleteMilestonesRow = $totalrow;



        //total milestone assigned by project manager//
        $query = Project::join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
            // ->join('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
            ->where('projects.pm_id', $pmId)
            ->whereBetween('project_milestones.created_at', [$startDate, $assignEndDate]);



        $RunningtotalAssignMilestonesRow = $query->count(); //rowwise 

        $RunningtotalAssignMilestonesCost = $query->sum('cost'); //valuewise 



        //Percentage of milestones 


        if (
            $RunningtotalAssignMilestonesCost != 0
        ) {
            $RunningmilestoneCompletionRatebyCost = ($RunningtotalCompleteMilestonesCost / $RunningtotalAssignMilestonesCost) * 100; //costwise
        }

        if ($RunningtotalAssignMilestonesRow != 0) {
            $RunningmilestoneCompletionRatebyRow = ($RunningtotalCompleteMilestonesRow / $RunningtotalAssignMilestonesRow) * 100;  //countwise
        }

        //-------------------------------------total task  complete by project manager------------------------//

        $totalrow = DB::table('projects')
            ->join('tasks', 'projects.id', '=', 'tasks.project_id')
            ->whereBetween('tasks.updated_at', [$startDate, $releaseEndDate])
            ->whereNotBetween('tasks.start_date', [$afterAssignStartDate, $releaseEndDate])
            ->whereNull('tasks.subtask_id')
            ->where('tasks.board_column_id', '=', '4')
            ->where('projects.pm_id', $pmId)
            ->count();

        $totalCompleteTasksRow = $totalrow;

        //total task assigned by project manager//

        $totalAssignTasksRow = DB::table('projects')
            ->join('tasks', 'projects.id', '=', 'tasks.project_id')
            ->whereBetween('tasks.start_date', [$startDate, $assignEndDate])
            ->whereNull('tasks.subtask_id')
            ->where('projects.pm_id', $pmId)      // niche dile kaz kore na  WHY enan //
            ->orWhere(function ($query) use ($startDate, $releaseEndDate, $pmId) {
                $query->where('tasks.start_date', '<', $startDate)
                    ->whereBetween('tasks.updated_at', [$startDate, $releaseEndDate])
                    ->where('tasks.board_column_id', '=', '4')
                    ->whereNull('tasks.subtask_id')
                    ->where('projects.pm_id', $pmId);
            })

            ->count();


        //Percentage of taskcompletion


        if ($totalAssignTasksRow != 0) {
            $taskCompletionRate = ($totalCompleteTasksRow / $totalAssignTasksRow) * 100; //costwise
        }

        // //View task history by project manager- use or condition but use one logic many times but checked correct//
        // $datafortasks = Project::select('projects.pm_id', 'tasks.id', 'tasks.heading', 'projects.project_name', 'tasks.board_column_id', 'tasks.start_date', 'tasks.updated_at')
        //     ->join('tasks', 'projects.id', '=', 'tasks.project_id')
        //     ->whereBetween('tasks.start_date', [$startDate, $assignEndDate])
        //     ->where('projects.pm_id', $pmId)
        //     ->whereNull('tasks.subtask_id')
        //     ->orWhere(function ($query) use ($startDate, $releaseEndDate, $pmId) {
        //         $query->where('tasks.start_date', '<', $startDate)
        //             ->whereBetween('tasks.updated_at', [$startDate, $releaseEndDate])
        //             ->where('tasks.board_column_id', '=', '4')
        //             ->whereNull('tasks.subtask_id')
        //             ->where('projects.pm_id', $pmId);
        //     })
        //     ->orderBy('id', 'DESC')
        //     ->get();

        //View task history by project manager//
        $datafortasks = Project::select('projects.pm_id', 'tasks.id', 'tasks.heading', 'projects.project_name', 'tasks.board_column_id', 'tasks.start_date', 'tasks.updated_at')
            ->join('tasks', 'projects.id', '=', 'tasks.project_id')
            ->where(function ($q1) use ($startDate, $assignEndDate, $releaseEndDate) {
                $q1->whereBetween('tasks.start_date', [$startDate, $assignEndDate])
                    ->orWhere(function ($q2) use ($startDate, $releaseEndDate) {
                        $q2->where('tasks.start_date', '<', $startDate)
                            ->whereBetween('tasks.updated_at', [$startDate, $releaseEndDate])
                            ->where('tasks.board_column_id', '=', '4');
                    });
            })
            ->whereNull('tasks.subtask_id')
            ->where('projects.pm_id', $pmId)
            ->orderBy('id', 'DESC')
            ->get();


        //-------------------------------------Running total task  complete by project manager------------------------//

        $totalrow = DB::table('projects')
            ->join('tasks', 'projects.id', '=', 'tasks.project_id')
            ->whereBetween('tasks.updated_at', [$startDate, $releaseEndDate])
            ->whereBetween('tasks.start_date', [$startDate, $assignEndDate])
            ->whereNull('tasks.subtask_id')
            ->where('tasks.board_column_id', '=', '4')
            ->where('projects.pm_id', $pmId)
            ->count();

        $RunningtotalCompleteTasksRow = $totalrow;

        //total task assigned by project manager//

        $RunningtotalAssignTasksRow = DB::table('projects')
            ->join('tasks', 'projects.id', '=', 'tasks.project_id')
            ->whereBetween('tasks.start_date', [$startDate, $assignEndDate])
            ->where('projects.pm_id', $pmId)      // niche dile kaz kore na  WHY enan //
            ->whereNull('tasks.subtask_id')
            ->count();


        if ($RunningtotalAssignTasksRow != 0) {
            $RunningtaskCompletionRate = ($RunningtotalCompleteTasksRow / $RunningtotalAssignTasksRow) * 100; //costwise
        }



        //---------------------------------Project Completion rate  by project manager(running)-------------------------------------//

        //complete
        $query = Project::whereBetween('projects.updated_at', [$startDate, $releaseEndDate])
            ->whereBetween('projects.start_date', [$startDate, $assignEndDate])
            ->where('projects.status', 'finished')
            ->where('projects.pm_id', $pmId);

        $totalRunningCompleteProjectsRow = $query->count();
        $totalRunningCompleteProjectsSum = $query->sum('project_budget');


        //assign


        $query = Project::whereBetween('projects.start_date', [$startDate, $assignEndDate])
            ->where('projects.pm_id', $pmId);

        $totalRunningAssignProjectsRow = $query->count();
        $totalRunningAssignProjectsSum = $query->sum('project_budget');



        //Percentage of projects (running) 

        $RunningProjectsCompletionRatebyRow = 0;
        $RunningProjectCompletionRatebyCost = 0;
        if ($totalRunningAssignProjectsRow != 0) {
            $RunningProjectsCompletionRatebyRow = ($totalRunningCompleteProjectsRow / $totalRunningAssignProjectsRow) * 100; //costwise
        }

        if ($totalRunningAssignProjectsSum  != 0) {
            $RunningProjectCompletionRatebyCost = ($totalRunningCompleteProjectsSum  / $totalRunningAssignProjectsSum) * 100;  //countwise
        }

        //---------------------------------Project Completion rate  by project manager-------------------------------------//

        //complete
        $query = Project::whereBetween('projects.updated_at', [$startDate, $releaseEndDate])
            ->whereNotBetween('projects.start_date', [$afterAssignStartDate, $releaseEndDate])
            ->where('projects.status', 'finished')
            ->where('projects.pm_id', $pmId);

        $totalCompleteProjectsRow = $query->count();
        $totalCompleteProjectsSum = $query->sum('project_budget');


        //assign


        $query = Project::whereBetween('projects.start_date', [$startDate, $assignEndDate])
            ->where('projects.pm_id', $pmId);

        $totalAssignProjectsRow = $query->count();
        $totalAssignProjectsSum = $query->sum('project_budget');

        //before assign 
        $query = Project::whereBetween('projects.updated_at', [$startDate, $releaseEndDate])
            ->where('projects.start_date', '<', $startDate)
            ->where('projects.status', 'finished')
            ->where('projects.pm_id', $pmId);

        $beforeAssignProjectsRow = $query->count();
        $beforeAssignProjectsSum = $query->sum('project_budget');

        $totalAssignProjectsRow += $beforeAssignProjectsRow;
        $totalAssignProjectsSum += $beforeAssignProjectsSum;

        //Percentage of projects 
        $projectsCompletionRatebyRow = 0;
        $ProjectCompletionRatebyCost = 0;

        if ($totalAssignProjectsRow != 0) {
            $projectsCompletionRatebyRow = ($totalCompleteProjectsRow / $totalAssignProjectsRow) * 100; //costwise
        }

        if ($totalAssignProjectsSum  != 0) {
            $ProjectCompletionRatebyCost = ($totalCompleteProjectsSum  / $totalAssignProjectsSum) * 100;  //countwise
        }


        //View project history by project manager-running batch//
        $dataviewforProject = Project::select('projects.pm_id', 'projects.client_id', 'clients.name', 'projects.id', 'projects.status', 'projects.project_name', 'projects.project_budget', 'projects.start_date', 'projects.updated_at')
            ->join(
                'users',
                'users.id',
                '=',
                'projects.pm_id'
            )
            ->join('users as clients', 'clients.id', '=', 'projects.client_id')
            ->whereBetween('projects.start_date', [$startDate, $assignEndDate])
            ->where('projects.pm_id', $pmId)
            ->orderBy('start_date', 'DESC')
            ->get();


        //--------------- Project  completion rate  Without QC ---------------- //
        // $query = Project::join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
        //     // ->select('projects.id', 'projects.project_budget')
        //     ->where('projects.status', '<>', 'finsihed')
        //     ->where('projects.pm_id', $pmId)
        //     ->where(function ($query) use ($startDate, $releaseEndDate) {
        //         $query->where('project_milestones.status', 'complete')
        //             ->where('project_milestones.qc_status', 0);
        //     })

        //     ->havingRaw('MAX(project_milestones.updated_at) BETWEEN ? AND ?', [$startDate, $releaseEndDate]);


        $ProjectCompletionWithoutQCCountbyRow = Project::join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
            ->where('projects.pm_id', $pmId)
            ->whereBetween('projects.start_date', [$startDate, $assignEndDate])
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('project_milestones as pm')
                    ->whereRaw('pm.project_id = projects.id')
                    ->where(function ($subquery) {
                        $subquery->where('pm.status', '!=', 'complete')
                            ->orWhere('pm.qc_status', '!=', 0);
                    });
            })
            ->distinct('projects.id')
            ->count();

        $ProjectCompletionWithoutQCCountbyCost = Project::join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
            ->where('projects.pm_id', $pmId)
            ->whereBetween('projects.start_date', [$startDate, $assignEndDate])
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('project_milestones as pm')
                    ->whereRaw('pm.project_id = projects.id')
                    ->where(function ($subquery) {
                        $subquery->where('pm.status', '!=', 'complete')
                            ->orWhere('pm.qc_status', '!=', 0);
                    });
            })
            ->distinct('projects.id')
            ->sum('project_budget');



        // $ProjectCompletionWithoutQCCountbyRow = $query->count();
        // $ProjectCompletionWithoutQCCountbyCost = $query->sum('project_budget');

        $ProjectCompletionWithoutQCCountbyRow += $totalCompleteProjectsRow;
        $ProjectCompletionWithoutQCCountbyCost += $totalCompleteProjectsSum;

        //Percentage of Project completion rate without qc form
        $projectsCompletionRatebyRowWithoutQC = 0;
        $ProjectCompletionRatebyCostWithoutQC = 0;
        if ($totalAssignProjectsRow != 0) {
            $projectsCompletionRatebyRowWithoutQC = ($ProjectCompletionWithoutQCCountbyRow / $totalAssignProjectsRow) * 100; //countwise
        }

        if ($totalAssignProjectsSum  != 0) {
            $ProjectCompletionRatebyCostWithoutQC = ($ProjectCompletionWithoutQCCountbyCost / $totalAssignProjectsSum) * 100;  //costwise
        }

        //average project completion time 
        $totalDuration = Project::where(function ($q1) use ($startDate, $releaseEndDate, $assignEndDate) {
            $q1->whereBetween('projects.updated_at', [$startDate, $releaseEndDate])
                ->whereBetween('projects.start_date', [$startDate, $assignEndDate])
                ->orWhere(function ($q2) use ($startDate, $releaseEndDate) {
                    $q2->whereBetween('projects.updated_at', [$startDate, $releaseEndDate])
                        ->where('projects.start_date', '<', $startDate);
                });
        })
            ->where('projects.status', 'finished')
            ->where('projects.pm_id', $pmId)
            ->selectRaw('SUM(DATEDIFF(updated_at, start_date)) AS total_duration')
            ->value('total_duration');

        $averageProjectCompletionTime = 0;
        if ($totalCompleteProjectsRow != 0) {
            $averageProjectCompletionTime = $totalDuration / $totalCompleteProjectsRow;
        }


        //average project completion time 
        $averageProjectCompletiontimesData = Project::join('users as clients', 'clients.id', '=', 'projects.client_id')
            ->where(function ($q1) use ($startDate, $releaseEndDate, $assignEndDate) {
                $q1->whereBetween('projects.updated_at', [$startDate, $releaseEndDate])
                    ->whereBetween('projects.start_date', [$startDate, $assignEndDate])
                    ->orWhere(function ($q2) use ($startDate, $releaseEndDate) {
                        $q2->whereBetween('projects.updated_at', [$startDate, $releaseEndDate])
                            ->where('projects.start_date', '<', $startDate);
                    });
            })
            ->where('projects.status', 'finished')
            ->where('projects.pm_id', $pmId)
            ->selectRaw('clients.name,projects.status,projects.project_name,projects.project_budget,projects.start_date,projects.updated_at,(DATEDIFF(projects.updated_at, projects.start_date)) AS total_duration')
            ->get();



        //---------------------------------Project Canceletion  by project manager-------------------------------------//

        //total cancel(cancelled+partially finished)
        $query = Project::whereBetween('projects.updated_at', [$startDate, $releaseEndDate])
            ->whereNotBetween('projects.start_date', [$afterAssignStartDate, $releaseEndDate])
            ->Where(function ($q1) {
                $q1->where('projects.status', 'partially finished')
                    ->orWhere('projects.status', 'canceled');
            })
            ->where('projects.pm_id', $pmId);

        $totalProjectCancelled = $query->count();


        //total cancel(cancelled+partially finished) Data View  
        $totalProjectCancelledData = Project::select('clients.name', 'projects.status', 'projects.project_name', 'projects.project_budget', 'projects.start_date', 'projects.updated_at')
            ->join('users as clients', 'projects.client_id', '=', 'clients.id')
            ->whereBetween('projects.updated_at', [$startDate, $releaseEndDate])
            ->whereNotBetween('projects.start_date', [$afterAssignStartDate, $releaseEndDate])
            ->Where(function ($q1) {
                $q1->where('projects.status', 'partially finished')
                    ->orWhere('projects.status', 'canceled');
            })
            ->where('projects.pm_id', $pmId)
            ->orderBy('start_date', 'ASC')
            ->get();


        // ------------------Delayed Projects------------------------------------------//

        //Cycle delayed projects

        // $delayedProjectsCount = Project::where(function ($q) {
        //     $q->whereRaw('DATEDIFF(updated_at, start_date) >10')
        //         ->where('status', '!=', 'in progress')
        //         ->orWhere(function ($q2) {
        //             $q2->where('status', '=', 'in progress')
        //                 ->whereRaw('DATEDIFF(CURDATE(), start_date) > 10');
        //         });
        // })
        //     ->whereBetween('start_date', [$startDate, $assignEndDate])
        //     ->where('pm_id', $pmId)
        //     ->count();

        //Cycle delayed projects  with delay count

        $delayedProjectsCount = Project::leftJoin('client_delays', 'projects.id', '=', 'client_delays.project_id')
            ->where('projects.status', '!=', 'in progress')  //1st condition for old projects
            ->where(function ($q) use ($startDate, $assignEndDate, $pmId) {
                $q->Where(function ($q2) {
                    $q2->whereNotNull('client_delays.project_id') // Check if project ID exists in client_delays
                        ->where('client_delays.status', '=', 'approved')
                        ->whereRaw(DB::raw('DATEDIFF(projects.updated_at, DATE_ADD(projects.start_date, INTERVAL client_delays.extra_time DAY)) > 10'))
                        ->orWhere(function ($q5) {
                            $q5->whereNull('client_delays.project_id')
                                ->whereRaw('DATEDIFF(projects.updated_at, projects.start_date) > 10');
                        });
                })
                    ->whereBetween('projects.start_date', [$startDate, $assignEndDate])
                    ->where('projects.pm_id', $pmId);
            })
            ->orWhere(function ($q3) use ($startDate, $assignEndDate, $pmId) {  // 2nd condition for new projects in progress
                $q3->where('projects.status', '=', 'in progress')
                    ->Where(function ($q4) {
                        $q4->whereNotNull('client_delays.project_id') // Check if project ID exists in client_delays
                            ->where('client_delays.status', '=', 'approved')
                            ->whereRaw(DB::raw('DATEDIFF(CURDATE(), DATE_ADD(projects.start_date, INTERVAL client_delays.extra_time DAY)) > 10'))
                            ->orWhere(function ($q6) {
                                $q6->whereNull('client_delays.project_id')
                                    ->whereRaw('DATEDIFF(CURDATE(), projects.start_date) > 10');
                            });
                    })
                    ->whereBetween('projects.start_date', [$startDate, $assignEndDate])
                    ->where('projects.pm_id', $pmId);
            })

            ->count();

        //Cycle delayed complete projects

        $completeDelayedProjectsCount = Project::where('status', 'finished')
            ->whereBetween('projects.start_date', [$startDate, $assignEndDate])
            ->whereBetween('projects.updated_at', [$startDate, $releaseEndDate])
            ->where('pm_id', $pmId)
            ->whereRaw('DATEDIFF(updated_at, start_date) >10')
            ->count();


        //--------- Projects   INFO ABOUT TOTAL ASSIGN RELEASE -------------------//


        //Assigned  Projects NUmber and Value Running Cycle --- below two comments already have done other sections
        // $totalRunningAssignProjectsRow 
        // $totalRunningAssignProjectsSum 

        // Accepted Projects Number and Value
        $query = Project::join('deals', 'projects.deal_id', '=', 'deals.id')
            ->whereBetween('projects.start_date', [$startDate, $assignEndDate])
            ->where('deals.status', '=', 'Accepted')
            ->where('projects.pm_id', $pmId);

        $totalRunningAcceptedProjectsRow = $query->count();
        $totalRunningAcceptedProjectsSum = $query->sum('amount');

        // Rejected  Projects Number and Value

        $query = DB::table('deals')->whereBetween('updated_at', [$startDate, $assignEndDate])
            ->where('status', '=', 'Denied')
            ->where('pm_id', $pmId);

        $totalRunningRejectedProjectsRow = $query->count();
        $totalRunningRejectedProjectsSum = $query->sum('amount');



        //View transaction history by project manager  payment release date in the particular month//


        $transaction_amount_dataview = Project::select('payments.paid_on', 'projects.pm_id', 'projects.start_date', 'users.name as manager_name', 'projects.client_id', 'clients.name', 'projects.id', 'projects.project_name', 'projects.project_budget', 'project_milestones.id as milestone_id', 'project_milestones.milestone_title', 'project_milestones.cost', 'project_milestones.created_at')
            ->join('users',  'users.id', '=', 'projects.pm_id')
            ->join('users as clients', 'clients.id', '=', 'projects.client_id')
            ->join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
            ->leftJoin('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
            ->whereBetween('payments.paid_on', [$startDate, $assignEndDate])
            ->orderBy('payments.paid_on', 'DESC')
            ->where('projects.pm_id', $pmId)
            ->get();


        // $released_amount_project = DB::table('projects')
        //     ->join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
        //     ->leftJoin('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
        //     ->select('projects.id', DB::raw('SUM(project_milestones.cost) as project_released_value'))
        //     ->whereNotNull('payments.paid_on')
        //     ->groupBy('projects.id')
        //     ->get();

        foreach ($transaction_amount_dataview as $project) {
            $project_id = $project->id;
            $payment_date = $project->paid_on;

            $released_amount_project = DB::table('projects')
                ->join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
                ->join('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
                ->where('projects.id', $project_id)
                ->where('payments.paid_on', '<=', $payment_date)
                ->sum('project_milestones.cost');

            $project->released_amount_project = $released_amount_project;
        }


        $pm_pending_milestone_value = DB::table('projects')
            ->join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
            ->leftJoin('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
            ->where('project_milestones.created_at', '<=', $assignEndDate)
            ->where(function ($q1) use ($assignEndDate) {
                $q1->whereNull('payments.paid_on')
                    ->orWhere('payments.paid_on', '>', $assignEndDate);
            })
            ->whereNot('project_milestones.status', 'canceled')
            ->where('projects.pm_id', $pmId)
            ->sum('project_milestones.cost');



        $pm_pending_milestone_value_upto_last_month = DB::table('projects')
            ->join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
            ->leftJoin('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
            ->where('project_milestones.created_at', '<', $startDate)
            ->where(function ($q1) use ($startDate) {
                $q1->whereNull('payments.paid_on')
                    ->orWhere('payments.paid_on', '>', $startDate);
            })
            ->whereNot('project_milestones.status', 'canceled')
            ->where('projects.pm_id', $pmId)
            ->sum('project_milestones.cost');



        $pm_unreleased_amount_month = DB::table('users')    // this is used for finding upto last month pending and this is selected cycle pending amount and that will be minus to whole pending amount
            ->join('projects', 'users.id', '=', 'projects.pm_id')   //cancel  milestone  is not allowed
            ->join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
            ->leftJoin('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
            ->whereBetween('project_milestones.created_at', [$startDate, $assignEndDate])
            ->where(function ($q1) use ($assignEndDate) {
                $q1->whereNull('payments.paid_on')
                    ->orWhere('payments.paid_on', '>', $assignEndDate);
            })
            ->whereNot('project_milestones.status', 'canceled')
            ->where('users.id', $pmId)
            ->sum('project_milestones.cost');


        $pm_released_amount_month = DB::table('users')
            ->join('projects', 'users.id', '=', 'projects.pm_id')
            ->join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
            ->join('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
            //->whereNotNull('project_milestones.invoice_id')
            ->whereBetween('payments.paid_on', [$startDate, $assignEndDate])
            ->where('users.id', $pmId)
            ->sum('project_milestones.cost');



        $pm_released_amount_this_month_create = DB::table('users')
            ->join('projects', 'users.id', '=', 'projects.pm_id')
            ->join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
            ->join('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
            //->whereNotNull('project_milestones.invoice_id')
            ->whereBetween('project_milestones.created_at', [$startDate, $assignEndDate])
            ->whereBetween('payments.paid_on', [$startDate, $assignEndDate])
            ->where('users.id', $pmId)
            ->sum('project_milestones.cost');


        // foreach ($unreleased_amount_project as $project) {
        //     $transaction_amount_dataview->= $project->project_unreleased_value;
        // }



        //Debugging

        // DB::enableQueryLog();
        // dd(DB::getQueryLog());

        // Total Release Amount Current Cycle and Full Cycle below two comments Already have done other sections

        //$RunningtotalAssignMilestonesCost --- Current
        //$totalAssignMilestonesCost --- Previous 


        //delay projects sum in a date range full cycle ---new syntax are used here //

        // $currentDate = now();
        // $variableDate = $startDate;
        // $sumDelayedCountFullCycle = 0;
        // while ($variableDate <= $assignEndDate) {

        //     $delayCount = Project::where(function ($q) use ($variableDate) {
        //         $q->whereDate('updated_at', '>', $variableDate)    ///previous project finish cancel or partial 
        //             ->orWhere(function ($q3) use ($variableDate) {
        //                 $q3->whereRaw("DATE_ADD(start_date, INTERVAL 20 DAY) <'{$variableDate}'")
        //                     ->where('status', 'in progress');
        //             });
        //     })
        //         ->where(DB::raw("DATE('$currentDate')"), '>', $variableDate)
        //         ->whereRaw("DATE_ADD(start_date, INTERVAL 20 DAY) <'{$variableDate}'")
        //         ->where(function ($q1) use ($startDate, $releaseEndDate, $assignEndDate) {
        //             $q1->whereBetween('projects.start_date', [$startDate, $assignEndDate])
        //                 ->orWhere(function ($q2) use ($startDate, $releaseEndDate) {
        //                     $q2->whereBetween('projects.updated_at', [$startDate, $releaseEndDate])
        //                         ->where('projects.start_date', '<', $startDate);
        //                 });
        //         })
        //         ->where('pm_id', $pmId)
        //         ->count();

        //     $sumDelayedCountFullCycle += $delayCount;

        //     $variableDate = date('Y-m-d', strtotime($variableDate . ' +1 day'));
        // }





        return view('dashboard.employee.pm_dashboard', compact(
            'username',
            'startDate',
            'endDate',
            'assignEndDate',
            'pm_released_amount_this_month_create',
            'pm_pending_milestone_value',
            'pm_unreleased_amount_month',
            'pm_released_amount_month',
            'pm_pending_milestone_value_upto_last_month',
            'transaction_amount_dataview',
            'totalRunningAcceptedProjectsRow',
            'totalRunningAcceptedProjectsSum',
            'totalRunningRejectedProjectsRow',
            'totalRunningRejectedProjectsSum',
            'completeDelayedProjectsCount',
            'delayedProjectsCount',
            'totalProjectCancelledData',
            'totalProjectCancelled',
            'averageProjectCompletiontimesData',
            'averageProjectCompletionTime',
            'RunningtotalCompleteTasksRow',
            'RunningtotalAssignTasksRow',
            'RunningtaskCompletionRate',
            'RunningtotalCompleteMilestonesCost',
            'RunningtotalAssignMilestonesCost',
            'RunningmilestoneCompletionRatebyCost',
            'RunningtotalAssignMilestonesRow',
            'RunningtotalCompleteMilestonesRow',
            'RunningmilestoneCompletionRatebyRow',
            'projectsCompletionRatebyRowWithoutQC',
            'ProjectCompletionRatebyCostWithoutQC',
            'ProjectCompletionWithoutQCCountbyCost',
            'ProjectCompletionWithoutQCCountbyRow',
            'ProjectCompletionWithoutQCCountbyRow',
            'dataviewforProject',
            'RunningProjectCompletionRatebyCost',
            'RunningProjectsCompletionRatebyRow',
            'totalRunningCompleteProjectsSum',
            'totalRunningCompleteProjectsRow',
            'totalRunningAssignProjectsSum',
            'totalRunningAssignProjectsRow',
            'totalAssignProjectsRow',
            'totalAssignProjectsSum',
            'ProjectCompletionRatebyCost',
            'projectsCompletionRatebyRow',
            'totalCompleteProjectsSum',
            'totalCompleteProjectsRow',
            'totalCompleteTasksRow',
            'totalAssignTasksRow',
            'taskCompletionRate',
            'totalCompleteMilestonesCost',
            'totalAssignMilestonesCost',
            'milestoneCompletionRatebyCost',
            'dataview',
            'totalAssignMilestonesRow',
            'totalCompleteMilestonesRow',
            'milestoneCompletionRatebyRow',
            'datafortasks'
        ));
    }



    public function delayRequestForm(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {

            $request->validate([
                'pm_id' => 'required',
                'project_id' => 'required',
                'extra_time' => 'required',
                'pm_text' => 'required',
                'images' => 'required|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Process the form data and save it in the database
            $project = new ClientDelay();
            $project->pm_id = $request->input('pm_id');
            $project->project_id = $request->input('project_id');
            $project->pm_text = $request->input('pm_text');
            $project->status = 'pending'; // Default status is pending
            $project->approved_by = null; // No admin has approved it yet
            $project->extra_time = $request->input('extra_time'); // Assuming the input name for number of days is 'days'

            // Save the uploaded images in the database as an array
            $images = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads'), $imageName);
                $images[] = $imageName;
            }
            $project->pm_file = $images;

            $project->save();
        }
    }


    public function projectExtendApproval(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {

            $project = ClientDelay::find($request->input('id'));
            $project->status = $request->input('status');
            $project->admin_text = $request->input('comment');
            $project->approved_by = auth()->user()->id;

            $project->save();
        }
    }



    public function pmPointsFilter(Request $request)
    {
        //dd($request->all());
        // $pmId = auth()->id();
        $pmId = $request->input('pmid');

        //$userId = $pmId; // Replace with the actual user ID input
        // $username = DB::table('users')->where('id', $userId)->value('name');

        $startDate = $request->input('start_date');
        $endDate1 = $request->input('end_date');
        $endDate = Carbon::parse($endDate1)->addDays(1)->format('Y-m-d');
        // $startDate = $request->input('start_date');
        $startDate1 = Carbon::parse($startDate);
        // $endDate = $request->input('end_date');
        $endDate1 = Carbon::parse($endDate1);



        // deliverable when project manager accept the project //

        $deliverableProjects = DB::table('projects')
            ->join('contract_signs', 'projects.id', '=', 'contract_signs.project_id')
            ->join('users as managers', 'projects.pm_id', '=', 'managers.id')
            ->join('users as clients', 'clients.id', '=', 'projects.client_id')
            ->join('project_members', 'projects.id', '=', 'project_members.project_id')
            ->whereRaw('project_members.created_at = (
                 SELECT MIN(created_at) 
                 FROM project_members 
                 WHERE project_members.project_id = projects.id AND project_members.user_id = projects.pm_id 
             )')
            ->whereBetween('projects.start_date', [$startDate, $endDate])
            //->whereBetween('project_members.created_at', [$startDate, $endDate])
            ->where('projects.pm_id', $pmId)
            ->distinct('projects.id')
            ->selectRaw('projects.id, projects.project_name, projects.start_date, project_members.created_at as min_created_at,contract_signs.created_at, managers.name as manager_name, clients.name as client_name,(TIMEDIFF(contract_signs.created_at, project_members.created_at)) AS time_difference')
            ->get();

        $deliverablePoints = [];
        foreach ($deliverableProjects as $project) {
            $project_startDate = Carbon::parse($project->min_created_at);
            $contractDate = Carbon::parse($project->created_at);
            $daysDifference = $project_startDate->diffInSeconds($contractDate);

            if ($daysDifference > 172800) {
                $difference = ($daysDifference - 172800) / 86400;
                $difference = floor($difference);
                $deliverablePoints[$project->id] = max(4.5 - ($difference * 0.5), 0);  // 6 beacause if 3 days passed it will be 4.5 so 6- 3* 0.5 
            } else {
                $deliverablePoints[$project->id] = 5;
            }
        }
        $totalDeliverablePoints = array_sum($deliverablePoints);

        //  deliverable when Sales team fillup the form //

        $deliverableProjectsAssignedBySales = DB::table('projects')
            ->join('contract_signs', 'projects.id', '=', 'contract_signs.project_id')
            ->join('p_m_projects', 'projects.id', '=', 'p_m_projects.project_id')
            ->join('users as managers', 'projects.pm_id', '=', 'managers.id')
            ->join('users as clients', 'projects.client_id', '=', 'clients.id')
            ->whereBetween('projects.start_date', [$startDate, $endDate])
            ->where('projects.pm_id', $pmId)
            ->distinct('projects.id')
            ->selectRaw('projects.id, projects.project_name,p_m_projects.created_at as sales_start_date,contract_signs.created_at, managers.name as manager_name,clients.name as client_name,(TIMEDIFF(contract_signs.created_at, p_m_projects.created_at)) AS time_difference')
            ->get();

        $deliverablePointsAssignedBySales = [];
        foreach ($deliverableProjectsAssignedBySales as $project) {
            $sales_startDate = Carbon::parse($project->sales_start_date);
            $contractDate = Carbon::parse($project->created_at);
            $daysDifference = $sales_startDate->diffInSeconds($contractDate);

            if ($daysDifference > 172800) {
                $difference = ($daysDifference - 172800) / 86400;
                $difference = floor($difference);
                $deliverablePointsAssignedBySales[$project->id] = max(4.5 - ($difference * 0.5), 0);
            } else {
                $deliverablePointsAssignedBySales[$project->id] = 5;
            }
        }

        $totalDeliverablePointsAssignedBySales = array_sum($deliverablePointsAssignedBySales);


        //   Project Manager compared with Estimate Time and Developer Log Time //

        $estimate_log_time_date =  DB::table('projects')
            ->leftJoin('project_deliverables', 'projects.id', '=', 'project_deliverables.project_id')
            ->leftJoin('project_time_logs', 'projects.id', '=', 'project_time_logs.project_id')
            ->join('p_m_projects', 'projects.id', '=', 'p_m_projects.project_id')
            ->join('users as managers', 'projects.pm_id', '=', 'managers.id')
            ->join('users as clients', 'projects.client_id', '=', 'clients.id')
            ->select('projects.id', 'projects.project_name', 'managers.name as manager_name', 'clients.name as client_name', 'project_deliverables.estimation_time', DB::raw('SUM(project_time_logs.total_minutes) as project_total_minutes'))
            ->where('projects.status', '=', 'finished')
            ->whereBetween('projects.start_date', [$startDate, $endDate])
            ->where('projects.pm_id', $pmId)
            ->groupBy('project_time_logs.project_id')
            ->get();



        $manager_estimate_percentage = [];
        $manager_estimate_points = [];
        foreach ($estimate_log_time_date as $project) {
            if ($project->estimation_time > 0) {
                $estimation_time = $project->estimation_time * 60;
                $estimate_difference_percentage = ($project->project_total_minutes / $estimation_time) * 100;
                $manager_estimate_percentage[$project->id] = $estimate_difference_percentage;

                if ($manager_estimate_percentage[$project->id] >= 81 && $manager_estimate_percentage[$project->id] <= 120) {
                    $manager_estimate_points[$project->id] = 5;
                } else if ($manager_estimate_percentage[$project->id] >= 71 && $manager_estimate_percentage[$project->id] <= 80 || $manager_estimate_percentage[$project->id] >= 121 && $manager_estimate_percentage[$project->id] <= 130) {
                    $manager_estimate_points[$project->id] = 4;
                } else if ($manager_estimate_percentage[$project->id] >= 61 && $manager_estimate_percentage[$project->id] <= 70 || $manager_estimate_percentage[$project->id] >= 131 && $manager_estimate_percentage[$project->id] <= 140) {
                    $manager_estimate_points[$project->id] = 3;
                } else if ($manager_estimate_percentage[$project->id] >= 56 && $manager_estimate_percentage[$project->id] <= 60 || $manager_estimate_percentage[$project->id] >= 141 && $manager_estimate_percentage[$project->id] <= 145) {
                    $manager_estimate_points[$project->id] = 2;
                } else if ($manager_estimate_percentage[$project->id] >= 51 && $manager_estimate_percentage[$project->id] <= 55 || $manager_estimate_percentage[$project->id] >= 146 && $manager_estimate_percentage[$project->id] <= 150) {
                    $manager_estimate_points[$project->id] = 1;
                } else {
                    $manager_estimate_points[$project->id] = -5;
                }
            } else {
                $estimate_difference_percentage = 0;
                $manager_estimate_percentage[$project->id] = $estimate_difference_percentage;
                $manager_estimate_points[$project->id] = 0;
            }
        }
        $total_estimate_points = array_sum($manager_estimate_points);

        //   Project Manager compared with Deadline Time and Complete Time //

        $project_deadline_complete_data = DB::table('projects')
            ->join('users as managers', 'projects.pm_id', '=', 'managers.id')
            ->join('users as clients', 'projects.client_id', '=', 'clients.id')
            ->whereBetween('projects.start_date', [$startDate, $endDate])
            ->whereNotNull('projects.deadline')
            ->where('projects.status', 'finished')
            ->where('projects.pm_id', $pmId)
            ->select('projects.id', 'projects.project_name', 'projects.project_budget', 'projects.start_date', 'projects.deadline', 'projects.updated_at', 'managers.name as manager_name', 'clients.name as client_name')
            ->get();

        $project_deadline_complete_points = [];
        foreach ($project_deadline_complete_data as $project) {
            $deadline = Carbon::parse($project->deadline)->addDays(1);
            $complete_time = Carbon::parse($project->updated_at);


            if ($deadline >= $complete_time) {
                $project_deadline_complete_points[$project->id] = $project->project_budget / 100;
            } else {
                $project_deadline_complete_points[$project->id] = 0;
            }
        }

        $total_project_deadline_complete_points = array_sum($project_deadline_complete_points);

        // Project Manager  complete projects  in a weak and get bonus points

        $completed_projects_count_data = DB::table('projects')
            ->join('users as managers', 'projects.pm_id', '=', 'managers.id')
            ->join('users as clients', 'projects.client_id', '=', 'clients.id')
            ->join('p_m_projects', 'projects.id', '=', 'p_m_projects.project_id')
            ->whereBetween('projects.updated_at', [$startDate, $endDate])
            ->whereRaw('DATEDIFF(projects.updated_at, projects.start_date) <= 7')
            ->where('projects.status', 'finished')
            ->where('projects.pm_id', $pmId)
            ->distinct('projects.id')
            ->select('projects.id', 'projects.project_name', 'projects.project_budget', 'p_m_projects.created_at as sales_start_date', 'projects.start_date', 'projects.updated_at', 'managers.name as manager_name', 'clients.name as client_name')
            ->get();

        $completed_projects_count = DB::table('projects')
            ->join('users as managers', 'projects.pm_id', '=', 'managers.id')
            ->join('users as clients', 'projects.client_id', '=', 'clients.id')
            ->join('p_m_projects', 'projects.id', '=', 'p_m_projects.project_id')
            ->whereBetween('projects.updated_at', [$startDate, $endDate])
            ->whereRaw('DATEDIFF(projects.updated_at, p_m_projects.created_at) <= 7')
            ->where('projects.status', 'finished')
            ->where('projects.pm_id', $pmId)
            ->distinct('projects.id')
            ->count();

        if ($completed_projects_count >= 10) {
            $completed_projects_count_points = 50;
        } else if ($completed_projects_count >= 8) {
            $completed_projects_count_points = 30;
        } else if ($completed_projects_count >= 5) {
            $completed_projects_count_points = 15;
        } else $completed_projects_count_points = 0;


        //Billable Hours Completed By Project manager

        $weekly_biilable_hours_points = [];
        $current_date = $startDate;
        while ($current_date <= $endDate) {

            $weekly_interval_start = $current_date;
            $weekly_interval_end = date('Y-m-d', strtotime($current_date . ' +6 days')); // 01 00:00:00 to 08 00:00:00 it can be 7 days 

            if ($weekly_interval_end > $endDate) break;

            $total_billable_hour = DB::table('projects')
                ->join('users', 'projects.pm_id', '=', 'users.id')
                ->join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
                ->join('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
                ->join('deals', 'projects.deal_id', '=', 'deals.id')
                ->where('deals.project_type', 'hourly')
                ->whereBetween('payments.paid_on', [$weekly_interval_start, $weekly_interval_end])
                ->where('users.id', $pmId)
                ->sum('payments.amount');

            $username = DB::table('users')->where('id', $pmId)->value('name');

            $weekly_billable_hours_points[] = [
                'project_manager' => $username,
                'start_date' => $weekly_interval_start,
                'end_date' => $weekly_interval_end,
                'total_weekly_billable_hour' => $total_billable_hour,
                'earned_points' => ($total_billable_hour / 100) * 3,
            ];


            $current_date = date('Y-m-d', strtotime($current_date . ' +7 days'));
        }

        $sum_weekly_billable_hours_points = 0;

        foreach ($weekly_billable_hours_points as $totalpoints) {
            $sum_weekly_billable_hours_points  += $totalpoints['earned_points'];
        }


        //Above 100 Billable Hours Bonus Point  Completed By Project manager

        $bonus_weekly_hours_points = [];
        $current_date = $startDate;
        while ($current_date <= $endDate) {

            $weekly_interval_start = $current_date;
            $weekly_interval_end = date('Y-m-d', strtotime($current_date . ' +6 days')); // 01 00:00:00 to 08 00:00:00 it can be 7 days 

            if ($weekly_interval_end > $endDate) break;

            $bonus_above_billable_hours = DB::table('projects')
                ->join('users', 'projects.pm_id', '=', 'users.id')
                ->join('project_milestones', 'projects.id', '=', 'project_milestones.project_id')
                ->join('payments', 'project_milestones.invoice_id', '=', 'payments.invoice_id')
                ->join('deals', 'projects.deal_id', '=', 'deals.id')
                ->where('deals.project_type', 'hourly')
                ->whereBetween('payments.paid_on', [$weekly_interval_start, $weekly_interval_end])
                ->where('users.id', $pmId)
                ->select('project_milestones.id', 'deals.hourly_rate', 'deals.amount')
                ->get();

            $username = DB::table('users')->where('id', $pmId)->value('name');
            $total_weekly_hour = 0;
            foreach ($bonus_above_billable_hours  as $project) {
                if ($project->amount > 0) {

                    $total_weekly_hour = $total_weekly_hour + ($project->amount / $project->hourly_rate);
                }
            }
            if ($total_weekly_hour >= 180) {
                $total_weekly_hour_points = 30;
            } else if ($total_weekly_hour >= 100) {
                $total_weekly_hour_points = 20;
            } else $total_weekly_hour_point = 0;

            $bonus_weekly_hours_points[] = [
                'project_manager' => $username,
                'start_date' => $weekly_interval_start,
                'end_date' => $weekly_interval_end,
                'total_weekly_hour' => $total_weekly_hour,
                'bonus_earned_points' => $total_weekly_hour_point,
            ];

            $current_date = date('Y-m-d', strtotime($current_date . ' +7 days'));
        }

        $bonus_sum_weekly_hours_points = 0;

        foreach ($bonus_weekly_hours_points as $totalpoints) {
            $bonus_sum_weekly_hours_points += $totalpoints['bonus_earned_points'];
        }


        return view('dashboard.employee.pm_dashboard', compact(
            'startDate1',
            'endDate1',
            'bonus_sum_weekly_hours_points',
            'bonus_weekly_hours_points',
            'sum_weekly_billable_hours_points',
            'weekly_billable_hours_points',
            'completed_projects_count_points',
            'completed_projects_count_data',
            'project_deadline_complete_data',
            'project_deadline_complete_points',
            'total_project_deadline_complete_points',
            'total_estimate_points',
            'manager_estimate_points',
            'estimate_log_time_date',
            'manager_estimate_percentage',
            'deliverableProjectsAssignedBySales',
            'deliverablePointsAssignedBySales',
            'totalDeliverablePointsAssignedBySales',
            'deliverableProjects',
            'deliverablePoints',
            'totalDeliverablePoints'
        ));
    }

    public function developerPointsFilter(Request $request)
    {

        $devId = $request->input('developerID');

        //$userId = $pmId; // Replace with the actual user ID input
        // $username = DB::table('users')->where('id', $userId)->value('name');

        $startDate = $request->input('start_date');
        $endDate1 = $request->input('end_date');
        $endDate = Carbon::parse($endDate1)->addDays(1)->format('Y-m-d');
        // $startDate = $request->input('start_date');
        $startDate1 = Carbon::parse($startDate);
        // $endDate = $request->input('end_date');
        $endDate1 = Carbon::parse($endDate1);

        // compare with developer task log time and estimate time given by lead developer

        $developer_estimated_time_compared_log_time = DB::table('tasks')
            ->join('task_users', 'tasks.id', '=', 'task_users.task_id')
            ->join('users', function ($join) {
                $join->on('task_users.user_id', '=', 'users.id');
                $join->on('tasks.id', '=', 'task_users.task_id');
            })
            ->join('project_time_logs', function ($join) {
                $join->on('users.id', '=', 'project_time_logs.user_id');
                $join->on('tasks.id', '=', 'project_time_logs.task_id');
            })
            ->select('tasks.id', 'tasks.heading as task_name', 'users.name as developer_name', 'tasks.updated_at', 'tasks.estimate_hours', 'tasks.estimate_minutes', DB::raw('SUM(project_time_logs.total_minutes) as task_total_minutes'), DB::raw('(tasks.estimate_hours * 60 + tasks.estimate_minutes) as total_estimated_time_minutes'))
            ->whereBetween('tasks.updated_at', [$startDate, $endDate])
            ->where('tasks.board_column_id', '=', '4')
            ->where('users.id', $devId)
            ->groupBy('tasks.id')
            ->get();

        $total_task = 0;
        $exceed_task = 0;
        foreach ($developer_estimated_time_compared_log_time as $estimate) {
            $estimate->percentage_compared_log_time = ($estimate->task_total_minutes / $estimate->total_estimated_time_minutes) * 100;
            if (($estimate->task_total_minutes / $estimate->total_estimated_time_minutes) * 100 > 120) {

                $exceed_task++;
                $total_task++;
            } else {

                $total_task++;
            }
        }
        $bonus_point_estimate_time = 0;
        if (($exceed_task / $total_task) * 100 <= 5) {

            $bonus_point_estimate_time = 20;
        }


        // compare with developer task log time and estimate time given by lead developer

        $developer_track_time = DB::table('tasks')
            ->join('task_users', 'tasks.id', '=', 'task_users.task_id')
            ->join('users', function ($join) {
                $join->on('task_users.user_id', '=', 'users.id');
                $join->on('tasks.id', '=', 'task_users.task_id');
            })
            ->join('project_time_logs', function ($join) {
                $join->on('users.id', '=', 'project_time_logs.user_id');
                $join->on('tasks.id', '=', 'project_time_logs.task_id');
            })
            ->select('tasks.id', 'tasks.heading as task_name', 'users.name as developer_name', 'tasks.updated_at', DB::raw('SUM(project_time_logs.total_minutes) as task_total_minutes'), DB::raw('SUM(project_time_logs.total_minutes)/60 as task_total_hours'))
            ->whereBetween('tasks.updated_at', [$startDate, $endDate])
            ->where('tasks.board_column_id', '=', '4')
            ->where('users.id', $devId)
            ->groupBy('tasks.id')
            ->get();


        $total_developer_track_time = 0;
        foreach ($developer_track_time as $track_time) {
            $total_developer_track_time += $track_time->task_total_minutes;
        }
        $total_developer_track_time = $total_developer_track_time / 60;
        if ($total_developer_track_time >= 180) {

            $bonus_point_track_time = 25;
        } else if ($total_developer_track_time >= 165) {

            $bonus_point_track_time = 15;
        } else
            $bonus_point_track_time = 0;




        return view('dashboard.employee.pm_dashboard', compact(
            'bonus_point_track_time',
            'total_developer_track_time',
            'developer_track_time',
            'bonus_point_estimate_time',
            'developer_estimated_time_compared_log_time',
            'startDate1',
            'endDate1'

        ));
    }
}
