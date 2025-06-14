<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturnCommentResource extends JsonResource
{
    public $status;
    public $message;
    // $this->resource sudah disediakan oleh parent::__construct

    public function __construct($status, $message, $resource)
    {
        parent::__construct($resource); // Ini akan mengisi $this->resource dengan data yang sebenarnya
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => $this->status,  // <-- KOREKSI DI SINI!
            'message' => $this->message, // <-- KOREKSI DI SINI!
            'data' => $this->resource,   // <-- KOREKSI DI SINI! (ini adalah data yang Anda teruskan ke konstruktor parent)
        ];
    }
}