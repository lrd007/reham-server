<?php

namespace Modules\Event\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\Event\Entities\Event;
use Illuminate\Routing\Controller;
use App\Http\Controllers\BaseController;
use Modules\Subscriber\Entities\Subscriber;
use Illuminate\Contracts\Support\Renderable;
use Modules\Event\Http\Requests\EventRequest;

class EventController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('event.view');

        //dd('test');
        $data = [
            __('Id'),
            __('Title'),
            __('Start Date'),
            __('Link'),
            __('Created At'),
            __('Status'),
            __('Action')
        ];
        $table = [
            'id' => 'event_table',
            'source' => route('event.list'),
            'data' => $data
        ];

        return view('event::index', compact('table'));
    }


    public function list(DataTables $dataTables)
    {
        $this->authorize('event.view');

        $canUpdate = auth()->user()->can('event.update');
        $canDelete = auth()->user()->can('event.delete');

        $canUpdate = true;
        $canDelete = true;

        $builder = Event::select(['id', 'title' . withLocalization(), 'start_date', 'link', 'created_at', 'deleted_at'])->withTrashed();


        return $dataTables::of($builder)
            ->removeColumn('image_url')
            ->editColumn('start_date', function ($item) {
                return showDate($item->start_date);
            })
            ->editColumn('created_at', function ($item) {
                return showDate($item->created_at);
            })
            ->editColumn('deleted_at', function ($item) {
                return statusSwitch($item->id, route("event.change.status", $item->id), $item->deleted_at);
            })
            ->addColumn('action', function ($item) use ($canUpdate, $canDelete) {
                $buttons = editButton(route("event.edit", $item->id), $canUpdate, false);
                $buttons .= deleteForm(route("event.destroy", $item->id), $canDelete, true);
                return $buttons;
            }, 8)
            ->rawColumns(range(0, 8))
            ->make(false);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = route('event.store');
        return view('event::event', compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(EventRequest $request)
    {
        $this->authorize('affiliate.create');

        try {
            $titleAr = $request->title_ar;
            $titleEn = empty($request->title_en) ? $request->title_ar : $request->title_en;
            $path = uploads_images('event');
            $event = new Event();
            $event->title_ar = $titleAr;
            $event->title_en = $titleEn;
            $event->description_ar =  $request->description_ar;
            $event->description_en =  $request->description_en;
            $event->start_date = $request->start_date;
            $event->link = $request->link;
            $event->image = uploadFile($request, 'event', 'image', 'image', $path);

            if ($request->has('post_or_schedule') && $request->post_or_schedule) {
                $event->schedule = $request->schedule;
              //  $event->deleted_at = now();
            }

            $event->save();

            $this->logActivity(['activity' => sprintf('Event created.'), 'id' => $event->id], true, true);


            if ($request->has('send_emails') && $request->send_emails) {
                $emails = Subscriber::whereNull('subscribers.deleted_at')
                                    ->join('users', 'subscribers.user_id', '=', 'users.id')
                                    ->pluck('users.email');
    
            if ($emails->isNotEmpty()) {
                foreach ($emails as $email) {
                    dispatch(new \App\Jobs\SendEventNotification($email, $event));
                }
            }
            }


            return $this->success(['redirection' => route('event.index')]);
        } catch (Exception $e) {
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
        return view('event::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('affiliate.update');

        $action = route('event.update', $id);
        $event = Event::withTrashed()->findOrFail($id);
        return view('event::event', compact('action', 'event'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(EventRequest $request, $id)
    {
        $this->authorize('affiliate.update');

        try {
            $titleAr = $request->title_ar;
            $titleEn = empty($request->title_en) ? $request->title_ar : $request->title_en;
            $path = uploads_images('event');
            $event = Event::withTrashed()->findOrFail($id);
            $event->title_ar = $titleAr;
            $event->title_en = $titleEn;
            $event->description_ar =  $request->description_ar;
            $event->description_en =  $request->description_en;
            $event->start_date = $request->start_date;
            $event->link = $request->link;
            $event->image = uploadFile($request, 'event', 'image', 'image', $path, $event);
            //$affiliate->bonus_material = uploadFile($request, 'affiliate', 'bonus_material', 'bonus_material', $path, $affiliate);

            if ($request->has('post_or_schedule') && $request->post_or_schedule) {
                $event->schedule = $request->schedule;
              //  $event->deleted_at = now();
            }

            $event->save();

            $this->logActivity(['activity' => sprintf('Event updated.'), 'id' => $event->id], true, true);

            return $this->success(['redirection' => route('event.index')]);
        } catch (Exception $e) {
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
        $this->authorize('affiliate.delete');

        try {

            $path = uploads_images('event');
            $event = Event::withTrashed()->find($id);
            $event->image ? deleteFileIfExist($path . $event->image, true) : '';
            $event->forceDelete();

            $this->logActivity(['activity' => sprintf('even$event deleted.'), 'id' => $event->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }


    public function changeStatus($id)
    {
        $this->authorize('event.delete');

        try {
            $event = Event::withTrashed()->findOrFail($id);

            if (isset(request()->status)) {
                $event->restore();
                $this->logActivity(['activity' => sprintf('Event active.'), 'id' => $event->id], true, true);
            } else {
                $event->delete();
                $this->logActivity(['activity' => sprintf('Event disable.'), 'id' => $event->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
