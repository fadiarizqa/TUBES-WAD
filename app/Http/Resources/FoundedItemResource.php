<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoundedItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'posting_type' => $this->posting_type,
            'full_name' => $this->full_name,
            'found_item_name' => $this->found_item_name,
            'item_type' => $this->item_type,
            'item_description' => $this->item_description,
            'phone_number' => $this->phone_number,
            'social_media' => $this->social_media,
            'item_photo_url' => asset('storage/' . $this->item_photo), // URL publik
            'found_location' => $this->found_location,
            'found_date' => $this->found_date,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}