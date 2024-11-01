<?php 

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\User\Entities\UserActivity;
use Arr;

class BaseController extends Controller
{
    use AuthorizesRequests;

    public $except_fields = [
        'password',
        '_method',
        '_token',
        'new_password',
        'new_password_confirmation',
        'old_password',
        'password_confirmation',
        'image',
        'thumbnail',
    ];
    
    /**
     * @param array $data
     * @param int $status
     * @param array $options
     * @return JsonResponse|Response
     */
    public function success($data = [], $status = 200, $options = [])
    {
        $data = $data ?: [];
        if ( ! Arr::get($data, 'status')) {
            $data['status'] = 'success';
        }

        foreach($data as $key => $value) {
            if ($value instanceof Arrayable) {
                $data[$key] = $value->toArray();
            }
        }

        return response()->json($data, $status);
    }

    /**
     * Return error response with specified messages.
     *
     * @param string $message
     * @param array $errors
     * @param int $status
     * @return JsonResponse
     */
    public function error(string $message = '', array $errors = [], int $status = 422)
    {
        $data = ['message' => $message, 'errors' => $errors ?: []];
        return response()->json($data, $status);
    }

    public function logActivity($data, $audit = false, $input = false)
    {
        $userActivity = new UserActivity;
        $userActivity->created_by = Auth::check() ? Auth::user()->id : 1;
        $userActivity->activity = $data['activity'];
        $userActivity->modal_id = $data['id'];

        if($input) {
            $inputs = request()->post();
            $userActivity->input = json_encode(Arr::except($inputs, $this->except_fields));
        }

        if($audit) {
            $userActivity->type = 1;
        }

        $userActivity->save();
    }
}
