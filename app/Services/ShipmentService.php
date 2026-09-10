<?php

namespace App\Services;

use App\Models\Shipment;

class ShipmentService
{
    public function store(array $data)
    {
        if (!empty($data['documents'])) {
            $data['documents'] = collect($data['documents'])
                ->map(fn ($file) => $file->store('shipment-documents', 'public'))
                ->toArray();
        }

        Shipment::create($data);
    }
}
