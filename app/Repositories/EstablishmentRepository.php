<?php

namespace App\Repositories;
use App\Interfaces\RepositoriesInterface;
use App\Models\Establishment;
use Illuminate\Support\Facades\DB;

class EstablishmentRepository implements RepositoriesInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return Establishment::with(['region.parent'])->paginate(10);
    }

    /**
     * Retrieve a Establishment by ID.
     */
    public function getById($id): Establishment
    {
        return Establishment::findOrFail($id);
    }

    /**
     * Store a new Establishment.
     */
    public function store(array $data): Establishment
    {
        return Establishment::create($data);
    }

    /**
     * Update an existing Establishment.
     */
    public function update(array $data, $id): Establishment
    {
        $Establishment = Establishment::findOrFail($id);
        $Establishment->update($data);
        return $Establishment;
    }

    /**
     * Delete a Establishment by ID.
     */
    public function delete($id): bool
    {
        return Establishment::where('id', $id)->delete() > 0;
    }
    
}
