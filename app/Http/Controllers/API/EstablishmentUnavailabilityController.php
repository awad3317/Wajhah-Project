<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Repositories\EstablishmentRepository;
use App\Repositories\EstablishmentUnavailabilityRepository;

class EstablishmentUnavailabilityController extends Controller
{
      /**
     * Create a new class instance.
     */
    public function __construct(private EstablishmentUnavailabilityRepository $EstablishmentUnavailabilityRepository,private EstablishmentRepository $EstablishmentRepository)
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
            'establishment_id' => ['required',Rule::exists('establishments','id')],
            'unavailable_date' => ['required','date'],
        ]);
        try {
            $user = auth('sanctum')->user();
            $establishment= $this->EstablishmentRepository->getById($fields['establishment_id']);
            if ($establishment->owner_id != $user->id) {
                return ApiResponseClass::sendError('Only the owner of the establishment can add unavailable date. ', null, 403);
            }
            $unavailable_date = $establishment->unavailabilityDays->create(['unavailable_date'=>$fields['unavailable_date']]);
            return ApiResponseClass::sendResponse($unavailable_date, 'Establishment unavailable date saved successfully.');
        } catch (Exception $e) {
            return ApiResponseClass::sendError('Error saving establishment unavailable date: ' . $e->getMessage());
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
