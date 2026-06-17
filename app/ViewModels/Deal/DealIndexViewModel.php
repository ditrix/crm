<?php

declare(strict_types=1);

namespace App\ViewModels\Deal;

use App\Http\Requests\Deal\IndexDealRequest;
use App\Services\Deal\DealService;

final class DealIndexViewModel
{
    public function __construct(
        private readonly array $data,
    ) {}

    public static function from(DealService $service, IndexDealRequest $request): self
    {
        $options = $service->getFormOptions();

        return new self([
            'deals' => $service->paginateFiltered($request),
            'statuses' => $options['statuses'],
            'clients' => $options['clients'],
            'showArchived' => $request->boolean('archived'),
        ]);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
