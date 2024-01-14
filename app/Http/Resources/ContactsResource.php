<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactsResource extends JsonResource
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
            'url'=> route('admin.contacts.show',['contact'=>$this->id]),
            'status_info' => $this->status_info,
            'name' => $this->name,
            'phone' => $this->mobile,
            'is_trashed'=>$this->is_trashed,
            'contact_source' => $this->contactSource->name,
            'city' => $this->city->name??"",
            'area' => $this->area->name??"",
            'category' => $this->contactCategory->name??"",
            'activity' => $this->activity->name??"",
            'sub_activity' => $this->sub_activity->name??"",
            'human_time' => $this->created_at->format('Y-m-d'),
            'employee_name' => $this->employee?$this->employee->name:"",
            'is_assigned'=> $this->employee_id?true:false,
        ];
    }
}
