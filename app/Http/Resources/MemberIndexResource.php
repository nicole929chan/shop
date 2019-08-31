<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => url('storage/'.$this->logo),
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'qrcode' => $this->qrcode
        ];
    }
}
