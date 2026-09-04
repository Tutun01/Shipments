<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewShipmentRequest;
use App\Http\Requests\UpdateShipmentRequest;
use App\Models\Shipment;
use App\Models\ShipmentDocuments;
use App\Traits\ImageUpload;
use Illuminate\Support\Facades\Cache;

class ShipmentController extends Controller
{
    use ImageUpload;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipments = Cache::remember('unassigned_status', now()->addMinutes(60), function () {
            return Shipment::orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        });

        return view('shipments.index', [
            'shipments' => $shipments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('shipments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewShipmentRequest $request)
    {
        $shipment = Shipment::create($request->validated());

        $fileTypes = [
          'application/pdf',
          'application/msword',
          'application/vnd.openxmlformats-officedocument.wordpreocessingml.document'
        ];

     foreach ($request->file('documents') as $document) {

         if (str_starts_with($document->getMimeType(), 'image/')) {

            $name = $this->uploadImage( $document, "documents/$shipment->id");
            $name = $shipment->id."/".$name;
            ShipmentDocuments::create([
                'shipment_id' => $shipment->id,
                'documents_name' => $name
            ]);

         } elseif (in_array($document->getMimeType(), $fileTypes)) {

             $extension = $document->getClientOriginalExtension(); // .pdf, .doc
             $fileName = uniqid().".".$extension;
             $path = $document->storeAs("documents/{$shipment->id}", $fileName, 'public');

             $path = str_replace("documents/", "", $path);

             ShipmentDocuments::create([
                 'shipment_id' => $shipment->id,
                 'documents_name' => $path
             ]);
         }
    }
        return redirect()->route('shipments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipment $shipment)
    {
        return view('shipments.show',[
          'shipment' => $shipment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipment $shipment)
    {
        return view('shipments.edit', compact('shipment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShipmentRequest $request, Shipment $shipment)
    {
        $shipment->update($request->validated());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipment $shipments)
    {
        //
    }
}
