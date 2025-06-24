<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Services\ImageService;
use Illuminate\Validation\Rule;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Repositories\EstablishmentRepository;

class EstablishmentController extends Controller
{
    /**
     * Create a new class instance.
     */
    public function __construct(private EstablishmentRepository $EstablishmentRepository,private ImageService $ImageService)
    {
        //
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
        'type_id' => ['required',Rule::exists('establishment_types','id')],
        'region_id' => ['required',Rule::exists('regions', 'id')->where(function ($query){return $query->where('parent_id', '!=', null);})],
        'name' => ['required','string','max:255'],
        'description' => ['nullable','string'],
        'primary_image' => ['required','image','max:2048'],
        'images' => ['nullable', 'array'],
        'images.*' => ['image', 'max:2048'],
        'latitude' => ['nullable','numeric'],
        'longitude' => ['nullable','numeric'],
    ]);
    try {
    $user = auth('sanctum')->user();
    if ($user->user_type !== 'owner') {
        return ApiResponseClass::sendError('Only users with owner type can create establishments',null,403);
    }
    $fields['owner_id'] = $user->id;
    $fields['primary_image'] = $this->ImageService->saveImage($fields['primary_image'], 'establishments');
    $establishment = $this->EstablishmentRepository->store($fields);
    if ($request->hasFile('images')){
        foreach ($request->file('images') as $image){
            $imagePath = $this->ImageService->saveImage($image, 'establishments');
            $establishment->images()->create(['image' => $imagePath]);  
        }
    }
    return ApiResponseClass::sendResponse($establishment,'establishment saved successfully.');
    } catch (Exception $e) {
        return ApiResponseClass::sendError('Error save establishment: ' . $e->getMessage());
    }
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
