@extends('layout')

@section('content')

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

    <div class="form-wrapper">
        <h1 class="form-header">Create New Shipment</h1>

        @if ($errors->any())
            <div class="validation-summary">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">
            <form enctype="multipart/form-data" method="POST" action="{{ route('shipments.store') }}">
                @csrf

                <div class="form-row">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" maxlength="128" value="{{ old('title') }}" required>
                </div>

                <div class="form-row-split">
                    <div class="form-row">
                        <label for="from_city">From City</label>
                        <input type="text" id="from_city" name="from_city" maxlength="64" value="{{ old('from_city') }}"
                               required>
                    </div>
                    <div class="form-row">
                        <label for="from_country">From Country</label>
                        <input type="text" id="from_country" name="from_country" maxlength="64"
                               value="{{ old('from_country') }}" required>
                    </div>
                </div>

                <div class="form-row-split">
                    <div class="form-row">
                        <label for="to_city">To City</label>
                        <input type="text" id="to_city" name="to_city" maxlength="64" value="{{ old('to_city') }}"
                               required>
                    </div>
                    <div class="form-row">
                        <label for="to_country">To Country</label>
                        <input type="text" id="to_country" name="to_country" maxlength="64"
                               value="{{ old('to_country') }}" required>
                    </div>
                </div>

                <div class="form-row-split">
                    <div class="form-row">
                        <label for="price">Price</label>
                        <input type="number" id="price" name="price" min="0" step="1" value="{{ old('price') }}"
                               required>
                    </div>
                    <div class="form-row">
                        <label for="status">Status</label>
                        <select id="status" name="status" required>
                            @foreach(\App\Models\Shipment::ALLOWED_STATUSES as $status)
                                <option value="{{ $status }}">{{ $status }}</option>                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="form-row">
                    <label for="documents">Documents</label>
                   <input type="file" name="documents[]" multiple required>
                </div>

                <div class="form-row">
                    <label for="details">Details</label>
                    <textarea id="details" name="details" required>{{ old('details') }}</textarea>
                </div>

                <button type="submit" class="submit-btn">Create Shipment</button>
            </form>
        </div>
    </div>

@endsection
