<?php

namespace App\Http\Controllers;

use App\Helper\Reply;
use App\Http\Requests\Milestone\StoreMilestone;
use App\Models\BaseModel;
use App\Models\Currency;
use App\Models\Project;
use App\Models\ProjectMilestone;
use App\Models\ProjectTimeLogBreak;
use App\Models\Task;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Auth;
use Notification;
use App\Notifications\MilestoneComplete;
use App\Models\User;
use App\Models\PMAssign;
use App\Models\Contract;
use App\Models\Deal;
use App\Models\ProjectActivity;
use App\Models\AuthorizationAction;
use Illuminate\Support\Facades\Validator;
use App\Notifications\MilestoneCancelNotification;
use App\Notifications\MilestoneCancelApproveNotification;
use App\Notifications\ProjectCompleteNotification;
use DateTime;
class ProjectMilestoneController extends AccountBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.projects';
        $this->middleware(function ($request, $next) {
            abort_403(!in_array('projects', $this->user->modules));
            return $next($request);
        });
    }

    /**
     * XXXXXXXXXXX
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = request('id');

        $this->project = Project::findOrFail($id);
        $addProjectMilestonePermission = user()->permission('add_project_milestones');
        $project = Project::findOrFail($id);

        abort_403(!($addProjectMilestonePermission == 'all' || $project->project_admin == user()->id));
        return view('projects.milestone.create', $this->data);
    }
    public function CompleteMilestone(Request $request)
    {
    //    / dd($request);
        $milestone_id= ProjectMilestone::where('id',$request->id)->first();
        $milestone= ProjectMilestone::find($request->id);
        $milestone->status= "complete";
        $milestone->last_updated_by= Auth::id();
        $milestone->save();

        $project= Project::where('id',$milestone->project_id)->first();

        //authorization action start

        $authorization_action = new AuthorizationAction();
        $authorization_action->model_name = $milestone->getMorphClass();
        $authorization_action->model_id = $milestone->id;
        $authorization_action->type = 'complete_milestone';
        $authorization_action->deal_id = $project->deal_id;
        $authorization_action->project_id = $project->id;
        $authorization_action->link = route('projects.show', $project->id).'?tab=milestones';
        $authorization_action->title = Auth::user()->name.' mark milestone complete';
        $authorization_action->authorization_for = 62;
        $authorization_action->save();
        //authorization action end

        $milestone_count= ProjectMilestone::where('project_id',$milestone->project_id)->count();

        $milestone_complete= ProjectMilestone::where('project_id',$milestone->project_id)->where('status','complete')->count();
        if ($milestone_count == $milestone_complete) {
            $users= User::where('role_id',1)->get();
            foreach ($users as $user) {


                Notification::send($user, new MilestoneComplete($project,$milestone));
            }
        }


        //  dd($output);
        if($project->deal->project_type == 'hourly')
        {
            return response()->json(['status'=>200]);

        }else 
        {
            return back()->with('success','Milestone Status Updated Successfully');
        }

     
       

    }
    public function createAutoMilestone(Request $request)
    {
       // dd($request->all());
    //   / DB::beginTransaction();
        $project=Project::where('id',$request->project_id)->first();
        $deal=Deal::where('id',$project->deal_id)->first();
        $milestone_count= ProjectMilestone::where('project_id',$request->project_id)->count();
        $milestone= new ProjectMilestone();
        $milestone->project_id= $project->id;

        $milestone->currency_id = 1;
        $milestone->milestone_title= $project->project_name . '- Milestone('.$milestone_count+1 .')';

        $milestone->original_currency_id= $deal->original_currency_id;
        $milestone->cost= 0;

        $milestone->actual_cost= 0;

        $milestone->invoice_created= 0;
        $milestone->status= 'incomplete';
        $milestone->added_by= Auth::id();
        $milestone->last_updated_by= Auth::id();
        $milestone->milestone_type= 'Client Created this Milestone';
        //dd($milestone->actual_cost,$milestone->invoice_created,$milestone->status,$milestone->added_by,$milestone->last_updated_by, $milestone->milestone_type);

        $milestone->save();
        // /$milestone_id= ProjectMilestone::where('id',$request->id)->first();
        //dd($request);
        $milestone_update= ProjectMilestone::find($request->milestone_id);
        $milestone_update->status= "complete";
        $milestone_update->last_updated_by= Auth::id();
        $milestone_update->save();
        $tasks = Task::where('milestone_id',$milestone_update->id)->where('board_column_id','!=',4)->get();
        foreach ($tasks as $key => $task) {
            $update_task = Task::find($task->id);
            $update_task->milestone_id = $milestone->id;
            $update_task->save();
        }
      //  dd("true");
        $project_id= Project::where('id',$milestone_update->project_id)->first();
        $milestone_updated_count= ProjectMilestone::where('project_id',$milestone_update->project_id)->count();

        $milestone_complete= ProjectMilestone::where('project_id',$milestone_update->project_id)->where('status','complete')->count();
        //  dd($milestone_count,$milestone_complete);
        if ($milestone_updated_count == $milestone_complete) {
            $users= User::where('role_id',1)->get();
            foreach ($users as $user) {


                Notification::send($user, new MilestoneComplete($project,$milestone_update));
            }
        }

        return response()->json(['status'=>200]);
    }

    /**
     * @param StoreMilestone $request
     * @return array
     * @throws \Froiden\RestAPI\Exceptions\RelatedResourceNotFoundException
     */
    public function store(StoreMilestone $request)
    {
        // /dd($request);
        $currency= Currency::where('currency_code',$request->original_currency_id)->first();

        // /dd($currency);
        $milestone = new ProjectMilestone();
        $milestone->project_id = $request->project_id;
        $milestone->milestone_title = $request->milestone_title;
        $milestone->summary = $request->summary;
        $milestone->milestone_type = $request->milestone_type;
        //$currency= Currency::where('id',$deal->original_currency_id)->first();
        //dd($currency);
        $milestone->cost = ($request->actual_cost)/$currency->exchange_rate;
        $milestone->actual_cost = ($request->actual_cost == '') ? '0' : $request->actual_cost;
        $milestone->currency_id = 1;

        $milestone->original_currency_id = $currency->id;

        $milestone->save();

        $project = Project::where('id',$request->project_id)->first();

        $project_milestone_cost= ProjectMilestone::where('project_id',$project->id)->sum('cost');
        if($project_milestone_cost > $project->project_budget && $project_milestone_cost-$project->project_budget > 1 )
        {
            $project_update= Project::find($project->id);
            $project_update->project_budget= $project->project_budget+$milestone->cost;
            $project_update->due= $project->due+ $milestone->cost;
            if($project->status == 'finished')
            {
                $project_update->status ='in progress';
            }
            $project_update->save();
            $pm_id= PMAssign::where('pm_id',$project->pm_id)->first();
            $pm_assign= PMAssign::find($pm_id->id);
            $pm_assign->amount= $pm_assign->amount+ $milestone->cost;
            $pm_assign->actual_amount= $pm_assign->actual_amount+ $milestone->cost;
            $pm_assign->monthly_project_amount= $pm_assign->monthly_project_amount+ $milestone->cost;
            $pm_assign->monthly_actual_project_amount= $pm_assign->monthly_actual_project_amount+ $milestone->cost;
            $pm_assign->save();

            $deal_id= Deal::where('id',$project->deal_id)->first();
            $deal= Deal::find($deal_id->id);
            $deal->actual_amount= $deal->actual_amount+ $milestone->actual_cost;
            $deal->amount= $deal->amount+ $milestone->cost;
            $deal->save();
            $contract_id= Contract::where('deal_id',$deal->id)->first();
            $contract= Contract::find($contract_id->id);
            $contract->actual_amount= $contract->actual_amount+ $milestone->actual_cost;
            $contract->original_amount= $contract->original_amount+ $milestone->actual_cost;
            $contract->amount= $contract->amount+ $milestone->cost;
            $contract->save();
            $log_user = Auth::user();
            $activity = new ProjectActivity();
            $activity->activity= $milestone->milestone_title. '- New milestone added by '. $log_user->name;

            $activity->project_id = $project_update->id;

            $activity->save();




        }

        // if ($request->add_to_budget == 'yes') {
        //     $project->project_budget = (!is_null($project->project_budget) ? ($project->project_budget + $milestone->cost) : $milestone->cost);
        //     $project->currency_id = $request->currency_id;
        //     $project->save();
        // }

        // $this->logProjectActivity($project->id, 'messages.newMilestoneCreated');
        return Reply::success(__('messages.milestoneSuccess'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->milestone = ProjectMilestone::findOrFail($id);
        $this->currencies = Currency::all();
        return view('projects.milestone.edit', $this->data);
    }

    /**
     * @param StoreMilestone $request
     * @param int $id
     * @return array
     * @throws \Froiden\RestAPI\Exceptions\RelatedResourceNotFoundException
     */
    public function update(StoreMilestone $request, $id)
    {
        $pre_cost= ProjectMilestone::where('id',$id)->first();
        // dd($pre_cost);
        $project_id= Project::where('id',$request->project_id)->first();
        $project_update_price= Project::find($project_id->id);
        $project_update_price->project_budget= $project_id->project_budget-$pre_cost->cost;
        $project_update_price->due= $project_id->due- $pre_cost->cost;

        $project_update_price->save();
        $pm_id_update= PMAssign::where('pm_id',$project_id->pm_id)->first();
        $pm_assign_update= PMAssign::find($pm_id_update->id);
        $pm_assign_update->amount= $pm_assign_update->amount- $pre_cost->cost;
        $pm_assign_update->actual_amount= $pm_assign_update->actual_amount- $pre_cost->cost;
        $pm_assign_update->monthly_actual_project_amount= $pm_assign_update->monthly_actual_project_amount- $pre_cost->cost;
        $pm_assign_update->save();

        $deal_id_update= Deal::where('id',$project_id->deal_id)->first();
        $deal_update= Deal::find($deal_id_update->id);
        $deal_update->actual_amount= $deal_update->actual_amount- $pre_cost->actual_cost;
        $deal_update->amount= $deal_update->amount- $pre_cost->cost;
        $deal_update->save();
        $contract_update_id= Contract::where('deal_id',$deal_update->id)->first();
        $contract_update= Contract::find($contract_update_id->id);
        $contract_update->actual_amount= $contract_update->actual_amount- $pre_cost->actual_cost;
        $contract_update->original_amount= $contract_update->original_amount- $pre_cost->actual_cost;
        $contract_update->amount= $contract_update->amount- $pre_cost->cost;
        $contract_update->save();
        $currency= Currency::where('currency_code',$request->original_currency_id)->first();
        //dd($request,$id);
        $milestone = ProjectMilestone::findOrFail($id);
        $originalValues = $milestone->getOriginal();
        $milestone->project_id = $request->project_id;
        $milestone->milestone_title = $request->milestone_title;
        $milestone->summary = $request->summary;
        $milestone->milestone_type= $request->milestone_type;
        $milestone->cost = ($request->actual_cost)/$currency->exchange_rate;
        $milestone->actual_cost = ($request->actual_cost == '') ? '0' : $request->actual_cost;
        $milestone->currency_id = 1;
        $milestone->original_currency_id = $currency->id;
        // $milestone->status = $request->status;
        // $milestone->start_date = $request->start_date == null ? $request->start_date : Carbon::createFromFormat($this->global->date_format, $request->start_date)->format('Y-m-d');
        // $milestone->end_date = $request->end_date == null ? $request->end_date : Carbon::createFromFormat($this->global->date_format, $request->end_date)->format('Y-m-d');
        $milestone->save();
        $project = Project::where('id',$milestone->project_id)->first();

        $project_milestone_cost= ProjectMilestone::where('project_id',$project->id)->sum('cost');
        if($project_milestone_cost > $project->project_budget && $project_milestone_cost-$project->project_budget > 1 )
        {
            $project_update= Project::find($project->id);
            $project_update->project_budget= $project->project_budget+$milestone->cost;
            $project_update->due= $project->due+ $milestone->cost;
            if($project->status == 'finished')
            {
                $project_update->status ='in progress';
            }
            $project_update->save();
            $pm_id= PMAssign::where('pm_id',$project->pm_id)->first();
            $pm_assign= PMAssign::find($pm_id->id);
            $pm_assign->amount= $pm_assign->amount+ $milestone->cost;
            $pm_assign->actual_amount= $pm_assign->actual_amount+ $milestone->cost;
            $pm_assign->monthly_project_amount= $pm_assign->monthly_project_amount+ $milestone->cost;
            $pm_assign->monthly_actual_project_amount= $pm_assign->monthly_actual_project_amount+ $milestone->cost;
            $pm_assign->save();

            $deal_id= Deal::where('id',$project->deal_id)->first();
            $deal= Deal::find($deal_id->id);
            $deal->actual_amount= $deal->actual_amount+ $milestone->actual_cost;
            $deal->amount= $deal->amount+ $milestone->cost;
            $deal->save();
            $contract_id= Contract::where('deal_id',$deal->id)->first();
            $contract= Contract::find($contract_id->id);
            $contract->actual_amount= $contract->actual_amount+ $milestone->actual_cost;
            $contract->original_amount= $contract->original_amount+ $milestone->actual_cost;
            $contract->amount= $contract->amount+ $milestone->cost;
            $contract->save();
            $log_user = Auth::user();
            $activity = new ProjectActivity();
            $activity->activity= $milestone->milestone_title. '- milestone updated by '. $log_user->name;

            $activity->project_id = $project_update->id;

            $activity->save();





        }

        // $this->logProjectActivity($milestone->project_id, 'messages.milestoneUpdated');
        return Reply::success(__('messages.milestoneSuccess'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $milestone = ProjectMilestone::findOrFail($id);
        ProjectMilestone::destroy($id);
        $this->logProjectActivity($milestone->project_id, 'messages.milestoneDeleted');
        return Reply::success(__('messages.deleteSuccess'));
    }

    public function show($id)
    {
        $viewMilestonePermission = user()->permission('view_project_milestones');

        $this->milestone = ProjectMilestone::with('tasks', 'tasks.users', 'tasks.boardColumn', 'tasks.createBy', 'tasks.timeLogged', 'project')->findOrFail($id);

        $project = Project::findOrFail($this->milestone->project_id);

        abort_403(!(
            $viewMilestonePermission == 'all'
            || ($viewMilestonePermission == 'added' && $this->milestone->added_by == user()->id)
            || ($viewMilestonePermission == 'owned' && $this->milestone->project->client_id == user()->id && in_array('client', user_roles()))
            || ($viewMilestonePermission == 'owned' && in_array('employee', user_roles()))
            || ($project->project_admin == user()->id)
        ));

        $totalTaskTime = 0;

        foreach($this->milestone->tasks as $totalTime)
        {
            $totalMinutes = $totalTime->timeLogged->sum('total_minutes');
            $breakMinutes = $totalTime->breakMinutes();
            $totalMinutes = $totalMinutes - $breakMinutes;
            $totalTaskTime += $totalMinutes;
        }

        $this->timeLog = intdiv($totalTaskTime, 60) . ' ' . __('app.hrs') . ' ';

        if ($totalTaskTime % 60 > 0) {
            $this->timeLog .= $totalTaskTime % 60 . ' ' . __('app.mins');
        }

        return view('projects.milestone.show', $this->data);
    }

    public function byProject($id)
    {
        if ($id == 0) {
            $options = '<option value="">--</option>';
        }
        else {
            $projects = ProjectMilestone::where('project_id', $id)->get();
            $options = BaseModel::options($projects, null, 'milestone_title');
        }

        return Reply::dataOnly(['status' => 'success', 'data' => $options]);
    }

    public function CancelMilestone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comments' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400
            ]);
        };
        $milestone_id= ProjectMilestone::where('id',$request->milestoneId)->first();
        $milestone= ProjectMilestone::find($milestone_id->id);
        $milestone->cancelation_status= 'submitted';
        $milestone->comments= $request->comments;
        $milestone->save();
        $project= Project::where('id',$milestone->project_id)->first();

        //authorizatoin action start here
        $authorization_action = new AuthorizationAction();
        $authorization_action->model_name = $milestone->getMorphClass();
        $authorization_action->model_id = $milestone->id;
        $authorization_action->type = 'milestone_cancel';
        $authorization_action->deal_id = $project->deal_id;
        $authorization_action->project_id = $project->id;
        $authorization_action->link = route('projects.show', $project->id).'?tab=milestones';
        $authorization_action->title = Auth::user()->name.' send milestone canceled request ';
        $authorization_action->authorization_for = 62;
        $authorization_action->save();
        //end authorization action here

        $users= User::where('role_id',1)->get();
        foreach ($users as $user) {
            Notification::send($user, new MilestoneCancelNotification($milestone));
        }
        return response()->json([
            'status' => 'success'
        ]);


    }
    public function CancelMilestoneApprove(Request $request)
    {
//         dd($request->milestoneId);

        $milestone_id= ProjectMilestone::where('id',$request->milestoneId)->first();
        $milestone= ProjectMilestone::find($milestone_id->id);
        $milestone->cancelation_status= 'approved';
        $milestone->status= 'canceled';

        $milestone->save();
        $project= Project::where('id',$milestone->project_id)->first();
        $update_project= Project::find($project->id);
        $update_project->project_budget= $project->project_budget-$milestone->cost;
        $update_project->due= $project->due- $milestone->cost;
        $update_project->milestone_cancel_amount= $project->milestone_cancel_amount+ $milestone->cost;
        $update_project->milestone_cancel_count= $project->milestone_cancel_count+ 1;

        $update_project->save();
        $pm_id= PMAssign::where('pm_id',$project->pm_id)->first();
        $pm_assign= PMAssign::find($pm_id->id);
        $pm_assign->amount= $pm_assign->amount- $milestone->cost;
        $pm_assign->actual_amount= $pm_assign->actual_amount- $milestone->cost;
        $pm_assign->monthly_project_amount= $pm_assign->monthly_project_amount- $milestone->cost;
        $pm_assign->monthly_actual_project_amount= $pm_assign->monthly_actual_project_amount- $milestone->cost;
        $pm_assign->save();

        $deal_id= Deal::where('id',$project->deal_id)->first();
        $deal= Deal::find($deal_id->id);
        $deal->actual_amount= $deal->actual_amount- $milestone->actual_cost;
        $deal->amount= $deal->amount- $milestone->cost;
        $deal->save();
        $contract_id= Contract::where('deal_id',$deal->id)->first();
        $contract= Contract::find($contract_id->id);
        $contract->actual_amount= $contract->actual_amount- $milestone->actual_cost;
        $contract->original_amount= $contract->original_amount- $milestone->actual_cost;
        $contract->amount= $contract->amount- $milestone->cost;
        $contract->save();
        $user= User::where('id',$project->pm_id)->first();
        $log_user = Auth::user();
        $activity = new ProjectActivity();
        $activity->activity= $milestone->milestone_title. '- Milestone canceled by '. $user->name;


        $activity->project_id = $update_project->id;

        $activity->save();

        //update authoziation action
        if (is_null($request->authorization_form)) {
            $authorization_action = AuthorizationAction::where([
                'project_id' => $project->id,
                'type' => 'project_deliverable_time_extention',
                'authorization_for' => $this->user->id,
                'status' => '0'
            ])->first();
            if ($authorization_action) {
                $authorization_action->description = $this->user->name.' Accept this request';
                $authorization_action->authorization_by = $this->user->id;
                $authorization_action->approved_at = Carbon::now();
                $authorization_action->status = '1';
                $authorization_action->save();
            }
        }
        //end authorization action

        $project_update_status= Project::find($update_project->id);
        if ($update_project->due < 3) {
          $project_update_status->status = 'partially finished';
          $project_update_status->completion_percent= 100;
          //$var= Project::where('id',$request->project_id)->first();
          $date1 = new DateTime($project['start_date']);
          $date2 = Carbon::now();
          $days  = $date2->diff($date1)->format('%a');
          $project_update_status->payment_release_date = $date2;
          $project_update_status->project_completion_days= $days;
          $project_update_status->save();
          $users= User::where('role_id',1)->orWhere('role_id',6)->get();
          foreach ($users as $user) {


             Notification::send($user, new ProjectCompleteNotification($project));
          }
        }







        Notification::send($user, new MilestoneCancelApproveNotification($milestone));

        return response()->json([
            'status' => 'success'
        ]);


    }

}
