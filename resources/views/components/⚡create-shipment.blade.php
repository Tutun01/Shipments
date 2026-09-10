<?php

use Livewire\Component;

new class extends Component
{
    use \Livewire\WithFileUploads;

    public string $title;
    public string $fromCountry;
    public string $fromCity;
    public string $toCity;
    public string $toCountry;
    public int $price;
    public array $statuses = [];
    public string $status = '';
    public int $clientId;
    public string $clientError;
    public array $documents;
    public string $details;

    public function mount()
    {
        $this->statuses = \App\Models\Shipment::ALLOWED_STATUSES;
    }

    public function validateUser()
    {
        $this->validate([
            'clientId' => 'required|integer|exists:users,id',
        ]);
    }

    public function submit(\App\Services\ShipmentService $shipmentService)
    {
        $request = new \App\Http\Requests\NewShipmentRequest();
        $data = $this->validate($request->rules());

        $data['from_city'] = $this->fromCity;
        $data['to_city'] = $this->toCity;
        $data['from_country'] = $this->fromCountry;
        $data['to_country'] = $this->toCountry;
        $data['client_id'] = $this->clientId;

        $shipmentService->store($data);
    }

};
?>

<div>

    <style>
        .form-wrapper {
            max-width: 640px;
            margin: 40px auto;
            padding: 0 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .form-header {
            font-size: 26px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 24px;
        }

        .form-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 28px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .form-row {
            margin-bottom: 18px;
        }

        .form-row-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            color: #111827;
            box-sizing: border-box;
            font-family: inherit;
            transition: border-color 0.15s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #059669;
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        .error-text {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
        }

        .submit-btn {
            background: #059669;
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .submit-btn:hover {
            background: #047857;
        }

        .validation-summary {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>


    <div class="form-card">
        <div class="form-wrapper">
            <h1 class="form-header">Create New Shipment</h1>
            @foreach($errors->all() as $error)
                {{$error}}
            @endforeach
    <form wire:submit="submit">

        <div class="form-row">
            <label for="title">Title</label>
            <input type="text" wire:model="title"  maxlength="128" required>
        </div>

        <div class="form-row-split">
            <div class="form-row">
                <label for="from_city">From City</label>
                <input type="text" maxlength="64" wire:model="fromCity"
                       required>
            </div>

            <div class="form-row">
                <label for="from_country">From Country</label>
                <input type="text" maxlength="64" wire:model="fromCountry" required>
            </div>
        </div>

        <div class="form-row-split">
            <div class="form-row">
                <label for="to_city">To City</label>
                <input type="text" maxlength="64" wire:model="toCity" required>
            </div>

            <div class="form-row">
                <label for="to_country">To Country</label>
                <input type="text" maxlength="64" wire:model="toCountry" required>
            </div>
        </div>

        <div class="form-row-split">
            <div class="form-row">
                <label for="price">Price</label>
                <input type="number"  min="0" step="1" wire:model="price" required>
        </div>

        <div class="form-row">
            <label for="clientId">Client ID</label>
           @error('clientId')
            <p> {{ $message }} </p>
            @enderror
            <input type="number" wire:blur="validateUser" wire:model="clientId" required>
        </div>

            <div class="form-row">
                <label for="status">Status</label>
                <select wire:model="status" required>
                    @foreach($statuses as $singleStatus)
                        <option value="{{ $singleStatus }}">{{ $singleStatus }}</option>                            @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <label for="documents">Documents</label>
            <input type="file" wire:model="documents" multiple required>
        </div>

        <div class="form-row">
            <label for="details">Details</label>
            <textarea wire:model="details" rows="4" required></textarea>
        </div>

        <button class="submit-btn">Submit</button>
    </form>
    </div>
</div>
</div>
