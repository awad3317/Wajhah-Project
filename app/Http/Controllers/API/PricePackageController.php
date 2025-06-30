<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Repositories\PricePackageRepository;
use App\Repositories\EstablishmentRepository;

class PricePackageController extends Controller
{
     /**
     * Create a new class instance.
     */
    public function __construct(private PricePackageRepository $PricePackageRepository,private EstablishmentRepository $EstablishmentRepository)
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
        $fields=$request->validate([
            'establishment_id' => ['required',Rule::exists('establishments','id')],
            'name' => ['required','string','max:100'],
            'icon'=>['required','string','max:255'],
            'price' =>['required','numeric','min:0'],
            'features' => ['nullable', 'array'],
            'features.*' => ['required', 'string', 'max:100'],
        ]);

        try {
            $userId= auth('sanctum')->id();
            $establishment=$this->EstablishmentRepository->getById($fields['establishment_id']);
            if (!$establishment || $establishment->owner_id !== $userId) {
                return ApiResponseClass::sendError('Unauthorized. You are not authorized to add Price Package to this establishment.', [], 403);
            }
            $package=$this->PricePackageRepository->store($fields);
            return ApiResponseClass::sendResponse($package, 'Price package created successfully with features stored as JSON.');

        } catch (Exception $e) {
            return ApiResponseClass::sendError('Error saving package: ' . $e->getMessage());
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
