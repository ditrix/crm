

# Laravel + Vue (No-Inertia) MRSRB Architectural Rules & Standards

This file defines the strict architectural standards for this repository.
It is used as a system prompt and code-style context for Cursor AI.
All generated and refactored code must strictly comply with these guidelines.

---

## 1. Architectural Philosophy (MRSRB + Vue)

We enforce a strictly decoupled, clean-architecture approach using the **Model-Request-Service-Resource-Blade (MRSRB)** pattern, customized for both standard Blade templates and decoupled Vue 3 REST APIs. 

*We explicitly reject Inertia.js to maintain a transparent, clean separation between frontend and backend.*

### Core Communication Flows
1. **API Flow (Vue 3 Front-end)**:
   `Vue 3 SFC <──(Axios/Fetch JSON)──> API Controller ──> Form Request ──> Service/Action ──> Model` 
   *(Response is formatted strictly via Eloquent JsonResources).*
   
2. **Classic Web Flow (Blade Front-end)**:
   `Browser Request ──> Web Controller ──> Form Request ──> Service/Action ──> Model`
   *(Data is prepared for the view strictly via ViewModels before reaching Blade).*

---

## 2. Directory Structure Conventions

Always place generated files in their respective domain-driven directory locations:
app/ ├── Helpers/ # Global stateless helper functions (registered in composer.json) ├── Http/ │ ├── Controllers/ │ │ ├── Web/ # Standard Blade-based web controllers │ │ └── Api/ # Vue-friendly REST API controllers │ ├── Requests/ # Form Requests (validation & authorization) │ └── Resources/ # Eloquent JsonResources (API data transformers) ├── Models/ # Pure database schemas and Eloquent setups ├── Services/ # Cohesive business logic classes ├── Actions/ # Single-responsibility action classes ├── Traits/ # Reusable horizontal model behaviors (e.g., HasUuid) └── ViewModels/ # Data preparation classes strictly for Blade views resources/ └── js/ # Vue 3 Frontend components, composables, and stores



---

## 3. Core Rules for Cursor AI

When writing or refactoring code, the AI must strictly adhere to these rules:

1. **PHP Syntax**: Use modern PHP 8.3+ features (strict types, readonly properties, constructor property promotion, typed properties).
2. **Vue Syntax**: Use Vue 3 `<script setup>` with TypeScript (or clean ES6) and the Composition API.
3. **No Inertia.js**: Do NOT import `@inertiajs/vue3` or use `Inertia::render()`. All Vue-to-Laravel communication must happen over clean JSON APIs.
4. **Thin Controllers**: Controllers must act as traffic dispatchers only. Keep methods under 10 lines of code. Delegate logic to Services/Actions.
5. **No Database Queries in Views**: Eloquent queries inside Blade templates, JsonResources, or ViewModels are strictly forbidden. All relationships must be eager-loaded beforehand.

---

## 4. Layer Specifications & Templates

### 4.1. Model Layer
Models must contain ONLY database definitions, casts, Eloquent relationships, and local query scopes. No business logic calculations.

```php
<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasUuid; // Trait usage for cross-cutting concern

    protected $fillable = ['user_id', 'amount', 'status', 'meta_data'];

    protected $casts = [
        'amount' => 'integer', // Amount stored in cents
        'meta_data' => 'array',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnpaid(Builder $query): void
    {
        $query->whereNull('paid_at');
    }
}
4.2. Request Layer (Validation)
Every input-receiving controller method must use a dedicated FormRequest class.


<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Invoice::class);
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'integer', 'min:100'], // amount in cents
            'meta_data' => ['nullable', 'array'],
        ];
    }
}
4.3. Service / Action Layer
Services: Group multi-step logic under cohesive domain classes (e.g., PaymentService).
Actions: Handle a single, atomic business event (e.g., CreateInvoiceAction).

<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use App\Helpers\CurrencyHelper;

class CreateInvoiceAction
{
    public function execute(User $user, array $data): Invoice
    {
        return DB::transaction(function () use ($user, $data) {
            // Apply business rules using global helper
            $calculatedAmount = CurrencyHelper::applyTax($data['amount'], 20); // 20% VAT

            $invoice = Invoice::create([
                'user_id' => $user->id,
                'amount' => $calculatedAmount,
                'status' => 'pending',
                'meta_data' => $data['meta_data'] ?? [],
            ]);

            return $invoice;
        });
    }
}
4.4. Resource Layer (API Response)
Convert models into presentation arrays using Eloquent JsonResources to keep API formats stable.


<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'amount_display' => number_format($this->amount / 100, 2) . ' ₽',
            'status' => $this->status,
            'is_paid' => $this->paid_at !== null,
            'created_date' => $this->created_at->toIso8601String(),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
4.5. API Controller Layer
Coordinates requests and invokes actions.


<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Actions\CreateInvoiceAction;
use App\Http\Resources\InvoiceResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class InvoiceApiController extends Controller
{
    public function store(StoreInvoiceRequest $request, CreateInvoiceAction $action): JsonResponse
    {
        $invoice = $action->execute(
            $request->user(),
            $request->validated()
        );

        return InvoiceResource::make($invoice->load('user'))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
4.6. Vue 3 Frontend Component (No Inertia)
Standard Vue 3 SFC communicating with Laravel over standard APIs using Axios or fetch.


<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';

interface Invoice {
  id: string;
  amount_display: string;
  status: string;
  is_paid: boolean;
  created_date: string;
}

const invoices = ref<Invoice[]>([]);
const isLoading = ref<boolean>(false);
const errorMessage = ref<string | null>(null);

const fetchInvoices = async (): Promise<void> => {
  isLoading.value = true;
  errorMessage.value = null;
  try {
    const response = await axios.get('/api/invoices');
    invoices.value = response.data.data;
  } catch (error) {
    errorMessage.value = 'Failed to load invoices.';
    console.error(error);
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  fetchInvoices();
});
</script>

<template>
  <div class="invoice-container">
    <h2>My Invoices</h2>
    <div v-if="isLoading">Loading...</div>
    <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
    
    <ul v-if="!isLoading && invoices.length">
      <li v-for="invoice in invoices" :key="invoice.id">
        <span>ID: {{ invoice.id }}</span> | 
        <span>Amount: {{ invoice.amount_display }}</span>
      </li>
    </ul>
  </div>
</template>
5. Architectural Utilities
5.1. Model Traits
Traits resolve common database configurations or hook into Eloquent life-cycle events.


<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUuid
{
    protected static function bootHasUuid(): void
    {
        static::creating(function (Model $model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}
5.2. Helpers
Helpers are pure, stateless global utilities. If a helper requires accessing database queries or configuration states, write a Service instead.


<?php

declare(strict_types=1);

namespace App\Helpers;

class CurrencyHelper
{
    public static function applyTax(int $amountInCents, float $taxPercentage): int
    {
        return (int) round($amountInCents * (1 + ($taxPercentage / 100)));
    }
}
5.3. View Composers (Blade-Only View State)
Only used for classic Blade views. Injects global database states without cluttering Web Controllers.


<?php

declare(strict_types=1);

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class UnpaidInvoicesComposer
{
    public function compose(View $view): void
    {
        $count = Auth::check() 
            ? Invoice::where('user_id', Auth::id())->unpaid()->count() 
            : 0;

        $view->with('unpaidInvoicesCount', $count);
    }
}
6. Architectural Exceptions & Bypass Rules (Simple Models)
Applying the full MRSRB flow to simple "flat" lookup tables, static dictionaries, or key-value structures without business logic is strictly forbidden (Anti-pattern: Over-engineering).

6.1. What defines a "Simple Model"?
A model is classified as "Simple/Flat" if it meets ALL of the following criteria:

No Foreign Keys (FK): It does not belong to other tables (no belongsTo or complex nested integrity constraints).
No Complex Business Logic: It only serves as a read-only list or basic CRUD (e.g., tags, countries, order_statuses, settings).
No State Machine Transitions: It does not dispatch jobs, events, or trigger third-party API actions upon saving.
6.2. The Bypass Protocol
For Simple Models, Cursor MUST bypass:

❌ Form Requests (use inline $request->validate() in the controller).
❌ Services or Actions (perform Eloquent queries directly in the controller).
❌ Eloquent Resources / ViewModels (return direct Eloquent collections or clean arrays directly from the controller).
6.3. Exception Template (Lightweight Dictionary Controller)

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TagApiController extends Controller
{
    /**
     * Direct database fetch (Bypass Service and Resource layers)
     */
    public function index(): JsonResponse
    {
        $tags = Tag::oldest('name')->get(['id', 'slug', 'name']);
        
        return response()->json([
            'data' => $tags
        ]);
    }

    /**
     * Inline validation and creation (Bypass Request and Action layers)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:tags,name'],
        ]);

        $tag = Tag::create([
            'name' => $validated['name'],
            'slug' => str($validated['name'])->slug()->toString(),
        ]);

        return response()->json([
            'message' => 'Tag created successfully',
            'data' => $tag
        ], 201);
    }
}
7. Prompts Cheat Sheet for Cursor
Copy and paste these templates when creating features inside this project:

Scenario A: Complex Feature (API Flow with Vue)

"Create a new feature flow for [Feature Name] following the MRSRB + Vue architecture. 
This feature is API-based (No Inertia). Please generate:
1. Migration and Model with strict types.
2. A FormRequest with validation rules.
3. A single-responsibility Action class for processing.
4. An Eloquent JsonResource.
5. An API Controller executing the Action and returning the Resource.
6. A Vue 3 Composition API component consuming the newly created endpoint."
Scenario B: Simple Lookup / Flat Table (Bypass Rules)

"Create a simple database lookup/CRUD for [Table Name, e.g., JobCategories]. 
This is a flat lookup model with no foreign keys or complex business logic.
Apply the Bypass Rules: do NOT generate Services, Actions, ViewModels, or Form Requests. 
Generate a migration, model, and a direct Controller using inline validation."


Type your message here…


Gemini 3.5 Flash

timefor.ai is an AI and can make mistakes. Please verify important information.