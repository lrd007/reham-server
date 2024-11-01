<?php

namespace Modules\FAQ\Http\Controllers;

use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\FAQ\Entities\Category;
use Modules\FAQ\Entities\Faq;
use Modules\FAQ\Http\Requests\FaqRequest;
use Yajra\DataTables\DataTables;

class FAQController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('faq.view');

        $data = [
            __('Id'),
            __('Question'),
            __('Answer'),
            __('Created By'),
            __('Created At'),
            __('Status'),            
            __('Action')
        ];

        $table = [
            'id' => 'faq_table',
            'source' => route('faq.list'),
            'data' => $data
        ];
        
        return view('faq::index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('faq.view');

        $canUpdate = auth()->user()->can('faq.update');
        $canDelete = auth()->user()->can('faq.delete');
        $builder = Faq::select(['id','question' . withLocalization(), 'answer' . withLocalization(), 'created_by', 'created_at', 'deleted_at'])->withTrashed();

        return $dataTables::of($builder)        
            ->editColumn('answer' . withLocalization(), function($item) {
                return strlen($item->{'answer' . withLocalization()}) > 50 ? mb_substr($item->{'answer' . withLocalization()}, 0, 50) . "..." : $item->{'answer' . withLocalization()};
            })
            ->editColumn('deleted_at', function($item) {
                return statusSwitch($item->id, route("faq.change.status", $item->id), $item->deleted_at);
            })
            ->editColumn('created_by', function ($item){
                return @$item->user->name;
            })
            ->editColumn('created_at', function ($item){
                return showDate($item->created_at);
            })
            ->addColumn('Action', function ($item) use ($canUpdate, $canDelete) {

                $buttons = editButton(route("faq.edit", $item->id), $canUpdate, false);
                $buttons .= deleteForm(route("faq.destroy", $item->id), $canDelete, true);
                
                return $buttons;
            })
            ->rawColumns(range(0, 10))
            ->make(false);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = route('faq.store');
        $generalCategory = Category::where('type', 0)->orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $legalCategory = Category::where('type', 1)->orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('faq::faq', compact('action', 'legalCategory', 'generalCategory'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FaqRequest $request)
    {
        $this->authorize('faq.create');

        try{
            $faq = new Faq;
            $faq->question_ar = $request->question_ar;
            $faq->question_en = $request->question_en;
            $faq->answer_ar = $request->answer_ar;
            $faq->answer_en = $request->answer_en;
            $faq->type = $request->type;
            $faq->created_by = auth()->user()->id;
            $faq->save();

            $categories = $request->type ? $request->legal_category : $request->general_category;
            $faq->categories()->sync($categories);

            $this->logActivity(['activity' => sprintf('FAQ created.'), 'id' => $faq->id], true, true);

            return $this->success(['redirection'=> route('faq.index')]);
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
        return view('faq::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $action = route('faq.update', $id);
        $faq = Faq::withTrashed()->findOrFail($id);
        $faqCategoryIds = $faq->categories()->pluck('id')->toArray();
        $generalCategory = Category::where('type', 0)->orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $legalCategory = Category::where('type', 1)->orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('faq::faq', compact('action', 'faq', 'legalCategory', 'generalCategory', 'faqCategoryIds'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FaqRequest $request, $id)
    {
        $this->authorize('faq.update');

        try{
            $faq = Faq::withTrashed()->findOrFail($id);
            $faq->question_ar = $request->question_ar;
            $faq->question_en = $request->question_en;
            $faq->answer_ar = $request->answer_ar;
            $faq->answer_en = $request->answer_en;
            $faq->type = $request->type;
            $faq->save();

            $categories = $request->type ? $request->legal_category : $request->general_category;
            $faq->categories()->sync($categories);

            $this->logActivity(['activity' => sprintf('FAQ updated.'), 'id' => $faq->id], true, true);

            return $this->success(['redirection'=> route('faq.index')]);
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
        $this->authorize('faq.delete');

        try{
            $faq = Faq::withTrashed()->findOrFail($id);
            $faq->forceDelete();
            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function changeStatus($id)
    {
        $this->authorize('faq.delete');

        try{
            $faq = Faq::withTrashed()->findOrFail($id);

            if(isset(request()->status)) {
                $faq->restore();
                $this->logActivity(['activity' => sprintf('FAQ updated.'), 'id' => $faq->id], true, true);
            } else {
                $faq->delete();
                $this->logActivity(['activity' => sprintf('FAQ deleted.'), 'id' => $faq->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
