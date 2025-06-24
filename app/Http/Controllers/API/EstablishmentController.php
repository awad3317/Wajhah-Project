<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Repositories\EstablishmentRepository;

class EstablishmentController extends Controller
{
    /**
     * Create a new class instance.
     */
    public function __construct(private EstablishmentRepository $EstablishmentRepository)
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
        'region_id' => ['required',Rule::exists('regions', 'id')],
        'name' => ['required','string','max:255'],
        'description' => ['nullable','string'],
        'primary_image' => ['required','image','max:2048'],
        'latitude' => ['nullable','numeric'],
        'longitude' => ['nullable','numeric'],
    ]);
    try {
    $user = auth('sanctum')->user();
    if ($user->user_type !== 'owner') {
        return ApiResponseClass::sendError('Only users with owner type can create establishments',null,403);
    }
    $fields['owner_id'] = $user->id;
    $establishment = $this->EstablishmentRepository->store($fields);
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
