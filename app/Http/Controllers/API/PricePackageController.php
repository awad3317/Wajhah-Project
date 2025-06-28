<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\Rule;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Repositories\PricePackageRepository;

class PricePackageController extends Controller
{
     /**
     * Create a new class instance.
     */
    public function __construct(private PricePackageRepository $PricePackageRepository)
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
            //code...
        } catch (Exception $e) {
            //throw $th;
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
