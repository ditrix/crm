<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Deal;

use App\Actions\Deal\CreateDealAction;
use App\Actions\Deal\RestoreDealAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Deal\CreateDealRequest;
use App\Http\Requests\Deal\IndexDealRequest;
use App\Http\Requests\Deal\StoreDealRequest;
use App\Http\Requests\Deal\UpdateDealRequest;
use App\Models\Deal;
use App\Services\Deal\DealService;
use App\ViewModels\Deal\DealFormViewModel;
use App\ViewModels\Deal\DealIndexViewModel;
use App\ViewModels\Deal\DealShowViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DealController extends Controller
{
    public function index(IndexDealRequest $request, DealService $service): View
    {
        return view('deals.index', DealIndexViewModel::from($service, $request)->toArray());
    }

    public function create(CreateDealRequest $request, DealService $service): View
    {
        return view('deals.create', DealFormViewModel::forCreate($service, $request)->toArray());
    }

    public function store(StoreDealRequest $request, CreateDealAction $action): RedirectResponse
    {
        $action->execute($request->validated());

        return redirect()->route('deals.index')
            ->with('success', __('messages.deal_created'));
    }

    public function show(Deal $deal, DealService $service): View
    {
        $this->authorize('view', $deal);

        return view('deals.show', (new DealShowViewModel($service->loadForShow($deal)))->toArray());
    }

    public function edit(Deal $deal, DealService $service): View
    {
        $this->authorize('update', $deal);

        return view('deals.edit', DealFormViewModel::forEdit($service, $deal)->toArray());
    }

    public function update(UpdateDealRequest $request, Deal $deal, DealService $service): RedirectResponse
    {
        $service->update($deal, $request->validated());

        return redirect()->route('deals.show', $deal)
            ->with('success', __('messages.deal_updated'));
    }

    public function destroy(Deal $deal, DealService $service): RedirectResponse
    {
        $this->authorize('delete', $deal);

        $service->delete($deal);

        return redirect()->route('deals.index')
            ->with('success', __('messages.deal_deleted'));
    }

    public function restore(int $id, RestoreDealAction $action): RedirectResponse
    {
        $deal = Deal::withTrashed()->findOrFail($id);

        $this->authorize('restore', $deal);

        $action->execute($deal);

        return redirect()->route('deals.index', ['archived' => 1])
            ->with('success', __('messages.deal_restored'));
    }
}
