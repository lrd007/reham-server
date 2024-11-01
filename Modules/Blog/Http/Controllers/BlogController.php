<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Blog\Entities\Blog;
use Modules\Course\Entities\Course;
use Modules\Tag\Entities\Tag;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Modules\Blog\Http\Requests\BlogRequest;

class BlogController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('course.view');

        $data = [
            __('Id'),
            __('Title'),
            __('Tag'),            
            __('Created At'),
            __('Status'),
            __('Action')
        ];
        $table = [
            'id' => 'blog_table',
            'source' => route('blog.list'),
            'data' => $data
        ];
        
        return view('blog::index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('blog.view');

        $canUpdate = auth()->user()->can('blog.update');
        $canDelete = auth()->user()->can('blog.delete');
        $builder = Blog::select(['id','title' . withLocalization(), 'created_at', 'deleted_at'])->withTrashed();

        return $dataTables::of($builder)
            ->addColumn('tag', function($item) {
                $label = '';
                foreach($item->tags as $tag) {
                    $label .= '<label class="badge bg-soft-primary text-primary p-1">'. $tag->{'name' . withLocalization()} .'</label> ';
                }

                return $label;
            }, 2)
            ->editColumn('deleted_at', function($item) {
                return statusSwitch($item->id, route("blog.change.status", $item->id), $item->deleted_at);
            })
            ->editColumn('created_at', function ($item){
                return showDate($item->created_at);
            })
            ->addColumn('Action', function ($item) use ($canUpdate, $canDelete) {

                $buttons = editButton(route("blog.edit", $item->id), $canUpdate, false);
                $buttons .= deleteForm(route("blog.destroy", $item->id), $canDelete, true);
                
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
        $action = route('blog.store');
        $tags = Tag::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('blog::blog', compact('action', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(BlogRequest $request)
    {
        $this->authorize('blog.create');

        try{
            $titleAr = $request->title_ar;
            $titleEn = empty($request->title_en) ? $request->title_ar : $request->title_en;
            $path = uploads_images('blog');
            $blog = new Blog;
            $blog->title_ar = $titleAr;
            $blog->title_en = $titleEn;
            $blog->slug = Str::slug($titleEn);
            $blog->thumb_image = uploadFile($request, 'blog', 'thumb_image', 'thumbnail', $path);
            $blog->description_ar = $request->description_ar;
            $blog->description_en = $request->description_en;
            
            if($request->has('post_or_schedule') && $request->post_or_schedule) {
                $blog->schedule = $request->schedule;
                $blog->deleted_at = now();
            }

            $blog->save();
            $blog->tags()->sync($request->tag);

            $this->logActivity(['activity' => sprintf('Blog created.'), 'id' => $blog->id], true, true);

            return $this->success(['redirection'=> route('blog.index')]);
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
        return view('blog::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $action = route('blog.update', $id);
        $tags = Tag::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $blog = Blog::withTrashed()->findOrFail($id);
        return view('blog::blog', compact('action', 'tags', 'blog'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(BlogRequest $request, $id)
    {
        $this->authorize('blog.create');

        try{
            $titleAr = $request->title_ar;
            $titleEn = empty($request->title_en) ? $request->title_ar : $request->title_en;
            $path = uploads_images('blog');
            $blog = Blog::withTrashed()->findOrFail($id);
            $blog->title_ar = $titleAr;
            $blog->title_en = $titleEn;
            $blog->slug = Str::slug($titleEn);
            $blog->thumb_image = uploadFile($request, 'blog', 'thumb_image', 'thumbnail', $path, $blog);
            $blog->description_ar = $request->description_ar;
            $blog->description_en = $request->description_en;
            
            if($request->has('post_or_schedule') && $request->post_or_schedule) {
                $blog->schedule = $request->schedule;
                $blog->deleted_at = now();
            }

            $blog->save();
            $blog->tags()->sync($request->tag);

            $this->logActivity(['activity' => sprintf('Blog updated.'), 'id' => $blog->id], true, true);

            return $this->success(['redirection'=> route('blog.index')]);
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
        $this->authorize('blog.delete');

        try{
            $path = uploads_images('blog');
            $blog = Blog::findOrFail($id);
            $blog->thumb_image ? deleteFileIfExist($path . $blog->thumb_image, true) : '';
            $blog->forceDelete();

            $this->logActivity(['activity' => sprintf('Blog deleted.'), 'id' => $blog->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function changeStatus($id)
    {
        $this->authorize('blog.delete');

        try{
            $blog = Blog::withTrashed()->findOrFail($id);

            if(isset(request()->status)) {
                $blog->restore();
                $this->logActivity(['activity' => sprintf('Blog active.'), 'id' => $blog->id], true, true);
            } else {
                $blog->delete();
                $this->logActivity(['activity' => sprintf('Blog disable.'), 'id' => $blog->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
