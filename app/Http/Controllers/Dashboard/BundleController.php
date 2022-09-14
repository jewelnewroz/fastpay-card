<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\BundleCreateRequest;
use App\Http\Requests\BundleUpdateRequest;
use App\Models\Bundle;
use App\Services\BundleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BundleController extends Controller
{
    private BundleService $bundleService;

    public function __construct(BundleService $bundleService)
    {
        $this->bundleService = $bundleService;
    }

    public function index(Request $request)
    {
        if($request->ajax() || $request->wantsJson()) {
            return $this->bundleService->getDataTable($request);
        }
        return view('admin.bundle.index')->with(['title' => 'Bundles']);
    }

    public function create()
    {
        return view('admin.bundle.create')->with(['title' => 'Add new bundle']);
    }

    public function store(BundleCreateRequest $request): RedirectResponse
    {
        try {
            if($this->bundleService->create($request)) {
                return redirect()->route('bundle.index')->with(ResponseHelper::success(__('Bundle successfully created')));
            }
        } catch (\Exception $exception) {
            Log::error('Bundle Create ' . $exception);
        }

        return redirect()->back()->with(ResponseHelper::failed(__('Bundle cannot be created')))->withInput($request->all());
    }

    public function show(Bundle $bundle)
    {
        return view('admin.bundle.show', compact('bundle'))->with(['title' => 'View bundle']);
    }

    public function edit(Bundle $bundle)
    {
        return view('admin.bundle.edit', compact('bundle'))->with(['title' => 'Edit bundle']);
    }

    public function update(BundleUpdateRequest $request, $id): RedirectResponse
    {
        try {
            if($this->bundleService->update($request, $id)) {
                return redirect()->route('bundle.index')->with(ResponseHelper::success(__('Bundle successfully created')));
            }
        } catch (\Exception $exception) {
            Log::error('Bundle Create ' . $exception);
        }

        return redirect()->back()->with(ResponseHelper::failed(__('Bundle cannot be created')))->withInput($request->all());
    }

    public function destroy(Bundle $bundle)
    {
        //
    }
}
