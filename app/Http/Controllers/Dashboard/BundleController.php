<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\BundleCreateRequest;
use App\Http\Requests\BundleUpdateRequest;
use App\Models\Bundle;
use App\Services\BundleService;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BundleController extends Controller
{
    private BundleService $bundleService;
    private MediaService $mediaService;

    public function __construct(BundleService $bundleService, MediaService $mediaService)
    {
        $this->bundleService = $bundleService;
        $this->mediaService = $mediaService;
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
            if($bundle = $this->bundleService->create($request)) {
                if($request->hasFile('attachment')) {
                    $media = $this->mediaService->upload($request->file('attachment'));
                    if($media) {
                        $bundle->update(['logo' => $media->attachment]);
                    }
                }
                return redirect()->route('bundle.index')->with(ResponseHelper::success(__('Bundle successfully created')));
            }
        } catch (\Exception $exception) {
            dd($exception);
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

    public function update(BundleUpdateRequest $request, Bundle $bundle): RedirectResponse
    {
        try {
            if($this->bundleService->update($request, $bundle->id)) {
                if($request->hasFile('attachment')) {
                    $media = $this->mediaService->upload($request->file('attachment'));
                    if($media) {
                        $bundle->update(['logo' => $media->attachment]);
                    }
                }
                return redirect()->route('bundle.index')->with(ResponseHelper::success(__('Bundle successfully created')));
            }
        } catch (\Exception $exception) {
            dd($exception);
            Log::error('Bundle Create ' . $exception);
        }

        return redirect()->back()->with(ResponseHelper::failed(__('Bundle cannot be created')))->withInput($request->all());
    }

    public function destroy(Bundle $bundle): RedirectResponse
    {
        $bundle->delete();
        return redirect()->back()->with(ResponseHelper::failed(__('Bundle has been successfully deleted')));
    }
}
