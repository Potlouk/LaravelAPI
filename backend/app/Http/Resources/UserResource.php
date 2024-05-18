<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, 
            'name' => $this->name,
            'email' => $this->email,
            'surname' => $this->surname,
            'contacted_sellers' => $this->contacted_sellers,
            'watched_estates' => $this->watched_estates,
            'reported_estates' => $this->reported_estates,
            'role' => $this->roles->first()->name,
        ];
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }
}
