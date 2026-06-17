<?php

declare(strict_types=1);

namespace App\ViewModels\Deal;

use App\Http\Requests\Deal\CreateDealRequest;
use App\Models\Deal;
use App\Services\Deal\DealService;

final class DealFormViewModel
{
    public function __construct(
        private readonly array $data,
    ) {}

    public static function forCreate(DealService $service, CreateDealRequest $request): self
    {
        $options = $service->getFormOptions();

        return new self([
            'statuses' => $options['statuses'],
            'clients' => $options['clients'],
            'selected' => $request->filled('client_id') ? $request->integer('client_id') : null,
        ]);
    }

    public static function forEdit(DealService $service, Deal $deal): self
    {
        $options = $service->getFormOptions();

        return new self([
            'deal' => $deal,
            'statuses' => $options['statuses'],
            'clients' => $options['clients'],
        ]);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
