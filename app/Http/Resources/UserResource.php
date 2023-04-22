<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return  collect($this->resource)->merge(
            [
                'current_service' => $this->currentService() ? [
                    'id' => $this->currentService()->id,
                    'name' => $this->currentService()->name,
                    'accounts_limit' => $this->currentService()->accounts_limit,
                    'traffic' => $this->currentService()->traffic,
                    'start_date' => $this->currentService()->pivot->start_date,
                    'end_date' => $this->currentService()->pivot->end_date,
                ] : null,

                'reserved_service' => $this->reservedService() ? [
                    'id' => $this->reservedService()->id,
                    'name' => $this->reservedService()->name,
                    'accounts_limit' => $this->reservedService()->accounts_limit,
                    'traffic' => $this->reservedService()->traffic,
                    'start_date' => $this->reservedService()->pivot->start_date,
                    'end_date' => $this->reservedService()->pivot->end_date,
                ] : null,


            ]
        );
    }
}
