<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'location_type' => 'required|string',
            'image' => 'nullable|string', // Base64 image
        ]);

        // Handle base64 image
        if ($request->has('image') && $request->image) {
            $image = $request->image;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            
            $imageName = uniqid() . '.png';
            Storage::disk('public')->put('services/' . $imageName, base64_decode($image));
            
            $validated['image'] = 'storage/services/' . $imageName;
        }

        $service = auth()->user()->services()->create($validated);

        return response()->json($service, 201);
    }

    public function index()
    {
        $services = Service::with('user')->latest()->get();
        return response()->json($services);
    }

    public function show($id)
    {
        $service = Service::with('user')->findOrFail($id);
        return response()->json($service);
    }

    public function updateStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,confirmed,completed,cancelled',
        ]);

        $service = Service::findOrFail($id);
        $service->status = $validated['status'];
        $service->save();

        return response()->json($service, 200);
    }

}
