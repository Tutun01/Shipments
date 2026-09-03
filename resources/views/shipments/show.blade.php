@extends('layout')

@section('content')

    <style>
        .shipment-detail-wrapper {
            max-width: 700px;
            margin: 40px auto;
            padding: 0 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .detail-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 28px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .detail-title {
            font-size: 26px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .detail-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .status-pending { background: #fef3c7; color: #92400e; }
        .status-in_transit { background: #dbeafe; color: #1e40af; }
        .status-delivered { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        .status-unassigned { background: #f3f4f6; color: #374151; }

        .detail-route {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 0;
            border-top: 1px solid #f3f4f6;
            border-bottom: 1px solid #f3f4f6;
            margin-bottom: 20px;
        }

        .route-point {
            flex: 1;
        }

        .route-city {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
        }

        .route-country {
            font-size: 13px;
            color: #6b7280;
        }

        .route-arrow {
            color: #9ca3af;
            font-size: 20px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 14px;
        }

        .detail-label {
            color: #6b7280;
            font-weight: 600;
        }

        .detail-value {
            color: #111827;
        }

        .detail-price {
            font-size: 24px;
            font-weight: 700;
            color: #059669;
            margin-bottom: 16px;
        }

        .detail-text {
            margin-top: 16px;
            font-size: 14px;
            color: #374151;
            line-height: 1.6;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 16px;
            color: #059669;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>

    <div class="shipment-detail-wrapper">
        <a href="{{ route('shipments.index') }}" class="back-link">&larr; Back to shipments</a>

        <div class="detail-card">
            <h1 class="detail-title">{{ $shipment->title }}</h1>
            <span class="detail-status status-{{ $shipment->status }}">
            {{ str_replace('_', ' ', $shipment->status) }}
        </span>

            <div class="detail-route">
                <div class="route-point">
                    <div class="route-city">{{ $shipment->from_city }}</div>
                    <div class="route-country">{{ $shipment->from_country }}</div>
                </div>
                <span class="route-arrow">&rarr;</span>
                <div class="route-point">
                    <div class="route-city">{{ $shipment->to_city }}</div>
                    <div class="route-country">{{ $shipment->to_country }}</div>
                </div>
            </div>

            <div class="detail-price">${{ number_format($shipment->price) }}</div>

            <div class="detail-row">
                <span class="detail-label">User ID</span>
                <span class="detail-value">{{ $shipment->user_id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Created</span>
                <span class="detail-value">{{ $shipment->created_at->format('d.m.Y H:i') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Last updated</span>
                <span class="detail-value">{{ $shipment->updated_at->format('d.m.Y H:i') }}</span>
            </div>

            <div class="detail-text">
                <strong>Details:</strong><br>
                {{ $shipment->details }}
            </div>

            <div class="detail-row">
                @foreach($shipment->documents as $document)
                    <a target="_blank" href="/storage/documents/{{$document->documents_name}}">{{$document->documents_name}}</a>
                @endforeach
            </div>

        </div>
    </div>

@endsection
