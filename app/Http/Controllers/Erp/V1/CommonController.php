<?php

namespace App\Http\Controllers\Erp\V1;

use App\Http\Controllers\Controller;
use App\Services\Erp\V1\UploadService;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    protected $uploadService;

    function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function uploadHeadImage(Request $request)
    {
        return $this->uploadService->uploadHeadImage($request);
    }
}