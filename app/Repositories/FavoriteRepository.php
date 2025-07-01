<?php

namespace App\Repositories;
use App\Interfaces\RepositoriesInterface;
use App\Models\Favorite;
use Illuminate\Support\Facades\DB;

class FavoriteRepository implements RepositoriesInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index($userId)
    {
        return Favorite::with(['establishment.region'])->where('user_id','=',$userId)->paginate(10);
    }

    /**
     * Retrieve a Favorite by ID.
     */
    public function getById($id): Favorite
    {
        return Favorite::find($id);
    }

    /**
     * Store a new Favorite.
     */
    public function store(array $data): Favorite
    {
        return Favorite::create($data);
    }

    /**
     * Update an existing Favorite.
     */
    public function update(array $data, $id): Favorite
    {
        $Favorite = Favorite::findOrFail($id);
        $Favorite->update($data);
        return $Favorite;
    }

    /**
     * Delete a Favorite by ID.
     */
    public function delete($id): bool
    {
        return Favorite::where('id', $id)->delete() > 0;
    }
    
}
