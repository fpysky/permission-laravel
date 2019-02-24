<?php

namespace App\Http\Controllers\Erp\V1;

use App\Http\Controllers\Controller;
use App\Services\Erp\V1\CommonService;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    protected $commonService;

    function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    public function uploadHeadImage(Request $request)
    {
        return $this->commonService->uploadHeadImage($request->all());
    }
}