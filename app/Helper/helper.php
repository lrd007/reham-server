<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

function showDate($date = '')
{

    if (!$date) {
        return '-';
    }
    try {
        return Carbon::parse($date)->format('d-m-y');
    } catch (Exception $e) {
        return '-';
    }
}

function showDateTime($dateTime = '')
{

    if (!$dateTime) {
        return '-';
    }
    try {
        return Carbon::parse($dateTime)->format('d-m-y H:i');
    } catch (Exception $e) {
        return '-';
    }
}

function editButton($route, $hasPermission = false, $modal = true)
{
    if (!$hasPermission) {
        return '';
    }
    $button = '<button type="button" class="action-icon btn modal-button" data-url="' . $route . '" data-toggle="modal" title="Edit"> <i class="mdi mdi-square-edit-outline"></i></button>';
    if (!$modal) {
        $button = '<a class="action-icon btn" href="' . $route . '" title="Edit"> <i class="mdi mdi-square-edit-outline"></i></a>';
    }
    return $button;
}

function mailButton($route, $hasPermission = false, $modal = true)
{
    if (!$hasPermission) {
        return '';
    }
    $button = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="mdi mdi-gmail"></i></button>';
    if (!$modal) {
        $button = '<a class="action-icon btn" href="' . $route . '" title="Edit"> <i class="mdi mdi-gmail"></i></a>';
    }
    return $button;
}

function recoverButton($route, $hasPermission = false)
{
    if (!$hasPermission) {
        return '';
    }
    return '<form method="POST" class="d-inline" action="' . $route . '" title="Recover" data-callback-function="reloadDatatable">' . csrf_field()
        . '<button type="button" class="recover-button action-icon btn d-inline"><i class="text-success mdi mdi-undo-variant"></i></button></form>';
}

function deleteForm($route, $hasPermission = false, $permanentDelete = true)
{
    if (!$hasPermission) {
        return '';
    }

    $icon = $permanentDelete ? 'text-danger mdi mdi-delete-forever' : 'text-info mdi mdi-archive-arrow-down';
    $title = $permanentDelete ? 'Delete forever' : 'Archive';
    $class = $permanentDelete ? '' : 'soft-delete-button';

    return '<form method="POST" class="d-inline" action="' . $route . '" title="' . $title . '" data-callback-function="reloadDatatable">' . csrf_field()
        . method_field('DELETE') . '<button type="button" class="delete-button ' . $class . ' action-icon btn d-inline"><i class="' . $icon . '"></i></button></form>';
}

function viewButton($route)
{
    // $button = '<button type="button" class="action-icon btn modal-button" data-url="' . $route . '" data-toggle="modal" title="Edit"> <i class="mdi mdi-square-edit-outline"></i></button>';

    $button = '<a class="action-icon btn" href="' . $route . '" title="Edit"> <i class="mdi mdi-view-carousel"></i></a>';
    return $button;
}

function shareUrl($id)
{
    $u = URL::to("/program/$id");
    $url = "copyToClipboard('$u')";
    return "<button class='action-icon btn d-inline' onclick=$url><i class='mdi mdi-content-copy'></i></button>";
}


function isFileExist($path = null)
{
    if ($path && File::exists(public_path($path))) {
        return url($path);
    }
    return noImage();
}

function noImage()
{
    return url('assets/images/no-image.jpg');
}

function deleteFileIfExist($file, $hasPublicPath = false)
{
    $path = $hasPublicPath ? $file : public_path($file);
    if ($file && File::exists($path)) {
        unlink($path);
    }
}

function fileNameFromPath($path)
{
    $path = explode('/', $path);
    return end($path);
}

function flushAllSessionsExceptReuired()
{

    $except = ['_flash', '_token', 'url', '_previous', 'locale'];
    $toRemove = [];
    $all = request()->session()->all();

    foreach ($all as $key => $value) {
        if (!in_array($key, $except) && !str_contains($key, 'login_web')) {
            $toRemove[] = $key;
        }
    }

    request()->session()->forget($toRemove);
}

function replaceMailVariable($body, $variables)
{

    foreach ($variables as $key => $variable) {
        $findString = '[' . $key . ']';
        $body = str_replace($findString, $variable, $body);
    }

    return $body;
}

function withLocalization()
{
    return '_' . app()->getLocale();
}

function generateRandomString($length = 7)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateReferenceNo($prefix, $no)
{
    $ym = Carbon::now()->format('Y/m');
    return $ym . '/' . $prefix . '-' . ref($no);
}

function zeroPrefixNo($num)
{
    switch ($num) {
        case $num < 10:
            return "0" . $num;
            break;
        default:
            return $num;
    }
}

function isActive($isDeleted = false, $withOutLabel = false)
{
    if ($isDeleted) {
        return $withOutLabel ? __('Disabled') : '<label class="badge bg-soft-danger text-danger p-1">' . __('Disabled') . '</label>';
    }
    return $withOutLabel ? __('Active') : '<label class="badge bg-soft-success text-success p-1">' . __('Active') . '</label>';
}


function statusSwitch($id, $route, $isDeleted = false)
{
    $isChecked = $isDeleted ? "" : "checked";
    return '<form method="POST" class="d-inline" action="' . $route . '" title="Recover" data-callback-function="reloadDatatable">' . csrf_field() .
        '<div class="custom-control custom-switch">
                <input type="checkbox" name="status" class="custom-control-input status-switch" id="customSwitch' . $id . '" ' . $isChecked . '>
                <label class="custom-control-label" for="customSwitch' . $id . '">' . isActive($isDeleted, true) . '</label>
            </div></form>';
}

/* **************** UPDATE ********************* */

function isInHome($isDeleted = false, $withOutLabel = false)
{
    if (!$isDeleted) {
        return $withOutLabel ? __('No') : '<label class="badge bg-soft-danger text-danger p-1">' . __('No') . '</label>';
    }
    return $withOutLabel ? __('Yes') : '<label class="badge bg-soft-success text-success p-1">' . __('Yes') . '</label>';
}


function statusSwitchForHome($id, $route, $isDeleted)
{
    $isChecked = !$isDeleted ? "" : "checked";
    return '<form method="POST" class="d-inline " action="' . $route . '" title="Recover2" data-callback-function="reloadDatatable">
    '.csrf_field().
        '<div class="custom-control custom-switch inputQty">
                <input type="checkbox" name="in_home_page" class="custom-control-input status-switch2 " id="customSwitch2' . $id . '" ' . $isChecked . '>
                <label class="custom-control-label" for="customSwitch2' . $id . '">' . isInHome($isDeleted, true) . '</label>
         </div>
    </form>';
}

/* **************** UPDATE ********************* */

function fileExtension($file)
{
    return strtoupper(strstr($file, '.'));
}

function isImage($extension)
{
    $extensions = ['.JPG', '.PNG', '.JPEG', '.GIF'];
    $extension = strtoupper($extension);

    return in_array($extension, $extensions);
}

function isFileImage($file)
{
    $extension = fileExtension($file);
    return isImage($extension);
}

function uploadFile($request, $prefix, $fileName, $file, $path, $model = null, $isImage = false)
{
    if (!$request->hasFile($file) && $model) {
        return $model->{$fileName};
    }

    if ($request->{$file}) {
        if ($model && !empty(trim($model->{$fileName}))) {
            deleteFileIfExist($path . $model->{$fileName}, true);
        }

        $file = $request->{$file};
        return $isImage ? upload_image($file, $path) : upload_file($file, $path, $prefix);
    }

    return null;
}

function GetVimeoFrameLink($link){
    $data = explode('/', $link);
    return 'https://player.vimeo.com/video/'.end($data).'?h=3168f6aec0&title=0&byline=0&portrait=0';

}
