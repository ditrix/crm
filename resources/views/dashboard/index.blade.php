<x-layout>
    <x-slot name="heading">{{ __('messages.dashboard') }}</x-slot>

    <div class="space-y-6">

        {{-- KPI — Deals --}}
        <div>
            <h2 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">
                {{ __('messages.deals') }}
            </h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <x-kpi-card
                    :value="$dealsTotal"
                    :label="__('messages.deals_total')"
                    color="indigo"
                    :href="route('deals.index')" />

                <x-kpi-card
                    :value="$dealsInProgress"
                    :label="__('messages.deals_in_progress')"
                    color="blue"
                    :href="route('deals.index', ['status' => \App\Models\DealStatus::bySlug('in_progress')->value('id')])" />

                <x-kpi-card
                    :value="$dealsActive"
                    :label="__('messages.deals_active')"
                    color="green"
                    :href="route('deals.index', ['status' => \App\Models\DealStatus::bySlug('active')->value('id')])" />

                <x-kpi-card
                    :value="$dealsClosed"
                    :label="__('messages.deals_closed')"
                    color="gray"
                    :href="route('deals.index', ['status' => \App\Models\DealStatus::bySlug('completed')->value('id')])" />
            </div>
        </div>

        {{-- KPI — Clients --}}
        <div>
            <h2 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">
                {{ __('messages.clients') }}
            </h2>
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                <x-kpi-card
                    :value="$clientsPotential"
                    :label="__('messages.clients_potential')"
                    color="amber"
                    :href="route('clients.index', ['status' => \App\Models\ClientStatus::bySlug('potential')->value('id')])" />

                <x-kpi-card
                    :value="$clientsActive"
                    :label="__('messages.clients_active')"
                    color="green"
                    :href="route('clients.index', ['status' => \App\Models\ClientStatus::bySlug('active')->value('id')])" />

                <x-kpi-card
                    :value="$clientsLoyal"
                    :label="__('messages.clients_loyal')"
                    color="purple"
                    :href="route('clients.index')" />
            </div>
        </div>

        {{-- KPI — Tasks today --}}
        <div>
            <h2 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">
                {{ __('messages.tools') }}
            </h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <x-kpi-card
                    :value="$tasksToday"
                    :label="__('messages.today_tasks')"
                    color="rose"
                    :href="'#'" />
            </div>
        </div>

        {{-- Sales funnel chart --}}
        <div>
            <h2 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">
                {{ __('messages.sales_funnel') }}
            </h2>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6">
                <div data-vue="sales-funnel"
                     data-stages="{{ json_encode($funnelData) }}"
                     class="w-full">
                </div>
            </div>
        </div>

    </div>
</x-layout>
