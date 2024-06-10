<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Ckeditor\CkeditorService;
use Illuminate\Http\Request;

class CkeditorController extends Controller
{
    protected CkeditorService $ckeditorService;

    public function __construct(CkeditorService $ckeditorService)
    {
        $this->ckeditorService = $ckeditorService;
    }

    public function uploadImage(Request $request)
    {
        try {
            $url = $this->ckeditorService->create($request->file('upload'));
        } catch (\Exception $exception) {
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $msg = $exception->getMessage();
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }

        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        $msg = trans('messages.success_created');

        $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

        @header('Content-type: text/html; charset=utf-8');
        echo $re;
    }
}
