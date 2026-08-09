@extends('layout')

@section('content')

    <style>
        .shipments-wrapper {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .shipments-header {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 24px;
        }

        .shipments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }

        .shipment-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        .shipment-card:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .shipment-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin: 0 0 12px 0;
        }

        .shipment-route {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #374151;
            margin-bottom: 14px;
        }

        .route-point {
            display: flex;
            flex-direction: column;
        }

        .route-city {
            font-weight: 600;
            color: #111827;
        }

        .route-country {
            font-size: 12px;
            color: #6b7280;
        }

        .route-arrow {
            color: #9ca3af;
            font-size: 16px;
        }

        .shipment-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .shipment-price {
            font-size: 20px;
            font-weight: 700;
            color: #059669;
        }

        .shipment-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-in_transit {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-delivered {
            background: #d1fae5;
            color: #065f46;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .shipment-details {
            font-size: 14px;
            color: #4b5563;
            line-height: 1.5;
            margin-bottom: 14px;
        }

        .shipment-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 12px;
            border-top: 1px solid #f3f4f6;
            font-size: 12px;
            color: #9ca3af;
        }

        .shipment-user {
            display: flex;
            align-items: center;
            gap: 6px;
        }
    </style>

    <div class="shipments-wrapper">
        <h1 class="shipments-header">Shipments ({{ $shipments->count() }})</h1>

        <div class="shipments-grid">
            @foreach($shipments as $shipment)
                <div class="shipment-card">
                    <h2 class="shipment-title">{{ $shipment->title }}</h2>

                    <div class="shipment-route">
                        <div class="route-point">
                            <span class="route-city">{{ $shipment->from_city }}</span>
                            <span class="route-country">{{ $shipment->from_country }}</span>
                        </div>
                        <span class="route-arrow">&rarr;</span>
                        <div class="route-point">
                            <span class="route-city">{{ $shipment->to_city }}</span>
                            <span class="route-country">{{ $shipment->to_country }}</span>
                        </div>
                    </div>

                    <div class="shipment-meta">
                        <span class="shipment-price">${{ number_format($shipment->price) }}</span>
                        <span class="shipment-status status-{{ $shipment->status }}">
                        {{ str_replace('_', ' ', $shipment->status) }}
                    </span>
                    </div>

                    <p class="shipment-details">
                        {{ \Illuminate\Support\Str::limit($shipment->details, 120) }}
                    </p>

                    <div class="shipment-footer">
                        <span class="shipment-user">User #{{ $shipment->user_id }}</span>
                        <span>{{ $shipment->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
