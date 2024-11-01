<?php

namespace Modules\NotificationCenter\Http\Controllers;

use App\Http\Controllers\BaseController;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\NotificationCenter\Entities\Notification;
use Modules\NotificationCenter\Entities\NotificationCourse;
use Modules\NotificationCenter\Entities\NotificationMedia;
use Modules\NotificationCenter\Entities\NotificationUser;
use Modules\NotificationCenter\Events\NotificationEvent;
use Modules\NotificationCenter\Http\Requests\NotificationRequest;
use Modules\NotificationCenter\Jobs\ProcessNotification;
use Modules\Program\Entities\Program;
use Modules\Subscriber\Entities\Subscriber;
use Modules\User\Entities\User;
use Yajra\DataTables\DataTables;

class NotificationCenterController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('notification.view');

        $data = [
            __('Id'),
            __('Title'),
            __('Message'),
            __('Send To'),            
            __('Medium'),
            __('Status'),
            __('Created At'),
            __('Action')
        ];

        $table = [
            'id' => 'notificationcenter_table',
            'source' => route('notificationcenter.list'),
            'data' => $data
        ];
        
        return view('notificationcenter::index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('notification.view');

        $canUpdate = auth()->user()->can('notification_center.update');
        $canDelete = auth()->user()->can('notification_center.delete');
        $canSend = auth()->user()->can('notification_center.send');

        $builder = Notification::select(['id','title', 'message', 'send_to' , 'status', 'created_at', 'schedule', 'deleted_at'])->withTrashed();

        return $dataTables::of($builder)
            ->removeColumn('schedule')
            ->removeColumn('deleted_at')
            ->editColumn('send_to', function ($item){
                return __(Notification::$sendTo[$item->send_to]);
            })
            ->editColumn('status', function ($item){
                $status = __(Notification::$status[$item->status]);
                $statusColor = Notification::$statusColor[$item->status];
                $status .= $item->status == 2 ? ': ' . showDateTime($item->schedule) : '';
                return '<label class="badge bg-soft-'. $statusColor .' text-'. $statusColor .' p-1">'. $status .'</label> ';
            })
            ->editColumn('created_at', function ($item){
                return showDateTime($item->created_at);
            })
            ->addColumn('media', function ($item){
                $label = '';
                foreach ($item->media as $media) {
                    $label .= '<label class="badge bg-soft-primary text-primary p-1">'. __(Notification::$mediumType[$media->medium_id]) .'</label> ';
                }
                return $label;
            }, 4)
            ->addColumn('Action', function ($item)  use ($canUpdate, $canDelete, $canSend) {
                $buttons = '';                

                $buttons .= editButton(route("notificationcenter.edit", $item->id), $canUpdate, false);
                $buttons .= deleteForm(route("notificationcenter.destroy", $item->id), $canDelete, true);
                if($canSend && $item->status != 2) {
                    $buttons .= '<form class="d-inline" action="'. route('notificationcenter.send', $item->id) .'" method="POST">'. csrf_field() .'<button type="button" class="action-icon btn d-inline send-notification" title="Send Notification"><i class="text-primary mdi mdi-bell-ring-outline"></i></button></form>';
                }
                return $buttons;
            }, 7)
            ->rawColumns(range(0, 7))
            ->make(false);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('notification.create');

        $action = route('notificationcenter.store');
        $courses = [];
        $programs = Program::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('notificationcenter::notification', compact('programs', 'courses', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(NotificationRequest $request)
    {
        $this->authorize('notification.create');
        
        DB::beginTransaction();
        try {            
            $notification = new Notification;
            $this->processNotification($notification, $request);

            $this->logActivity(['activity' => sprintf('Notification created.'), 'id' => $notification->id], true, true);

            DB::commit();
            return $this->success();
        } catch(Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('notificationcenter::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('notification.update');

        try {
            $notification = Notification::withTrashed()->findOrFail($id);
            $action = route('notificationcenter.update', $id);

            $notificationCourseIds = NotificationCourse::where('notification_id', $id)->pluck('course_id')->toArray();
            $notificationProgramIds = Program::whereHas('courses', function($query) use($notificationCourseIds) {
                $query->whereIn('course_id', $notificationCourseIds);
            })->pluck('id')->toArray();

            $programs = Program::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
            $courses = Course::select('id', 'name' . withLocalization())->whereHas('programs', function($query) use($notificationProgramIds) {
                $query->whereIn('program_id', $notificationProgramIds);
            })->orderBy('name' . withLocalization())->get();

            return view('notificationcenter::notification', compact('programs', 'courses', 'action', 'notification', 'notificationCourseIds', 'notificationProgramIds'));

        } catch(Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(NotificationRequest $request, $id)
    {
        $this->authorize('notification.update');
        
        DB::beginTransaction();
        try {            
            $notification = Notification::withTrashed()->findOrFail($id);
            $this->processNotification($notification, $request);

            $this->logActivity(['activity' => sprintf('Notification updated.'), 'id' => $notification->id], true, true);

            DB::commit();
            return $this->success();
        } catch(Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->authorize('notification.delete');

        try {

            $notification = Notification::withTrashed()->findOrFail($id);
            NotificationUser::where('notification_id', $id)->delete();
            NotificationMedia::where('notification_id', $id)->delete();
            NotificationCourse::where('notification_id', $id)->delete();
            $notification->forceDelete();

            $this->logActivity(['activity' => sprintf('Notification deleted.'), 'id' => $notification->id], true, true);

            return $this->success();

        } catch(Exception $e) {
            return $this->error($e->getMessage());
        }

    }

    public function processNotification($notification, $request)
    {
        if($request->status == 1 && $request->is_schedule == 1) {
            return $this->error(__('You can not send it now as it is schedule, For send now unset time.'));
        }

        $notification->title = $request->title;
        $notification->send_to = $request->send_to;
        $notification->schedule = $request->schedule ?: Carbon::now();
        $notification->message = $request->message;
        $notification->status = $request->is_schedule == 1 ? 2 : $request->status;
        $notification->save();
        
        if ($notification && $request->medium) {

            $notification->media()->delete();
            $courseIds = [];
            
            foreach ($request->medium as $medium) {
                $notificationMedium = new NotificationMedia;
                $notificationMedium->notification_id = $notification->id;
                $notificationMedium->medium_id = $medium;
                $notificationMedium->save();
            }

            if($request->send_to == 1) {
                                
                if($request->course) {
                    $courseIds = $request->course;
                } else {
                    $courseIds = Course::whereHas('programs', function($query) use($request) {
                        $query->whereIn('program_id', $request->program);
                    })->pluck('id')->toArray();
                }
                                
                $userIds = Subscriber::whereHas('subscribePrograms', function($query) use($courseIds) {
                                $query->whereIn('course_id', $courseIds);
                            })->pluck('user_id')->toArray();
                            
                $users = User::whereIn('id', $userIds)->get();

            } else {
                $users = User::whereIn('id', $request->subscriber)->get();
            }            

            // Sending notification
            if($request->status == 1) {
                $toNotifyUsers = $users->whereNotNull('email')->where('email', '!=', 'admin@demo.com');
                dispatch(new ProcessNotification($toNotifyUsers, $notification));
                event(new NotificationEvent($request->message));
            }
            
            $users = $users->pluck('id')->toArray();
            $notification->users()->sync($users);
            $notification->courses()->sync($courseIds);
        }
    }

    public function sendNotification($id)
    {
        $this->authorize('notification.send');

        $notification = Notification::findOrFail($id);
        if($notification->status == 2) {
            return $this->error(__('You can not send it now as it is schedule, For send now unset time.'));
        }

        $users = $notification->users;
        $media = $notification->media->pluck('medium_id')->toArray();

        if($notification->status != 2 && in_array(0, $media)) {
            $toNotifyUsers = $users->whereNotNull('email')->where('email', '!=', 'admin@demo.coms');
            dispatch(new ProcessNotification($toNotifyUsers, $notification));
        }

        if($notification->status != 2 && in_array(1, $media)) {
            event(new NotificationEvent($notification->message));
        }
        
        NotificationUser::where('notification_id', $id)->update([
            'is_seen' => 0
        ]);
        
        $notification->status = 1;
        $notification->save();

        $this->logActivity(['activity' => sprintf('Notification sent.'), 'id' => $notification->id], true, true);

        return $this->success();
    }
}
