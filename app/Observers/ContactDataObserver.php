<?php

namespace App\Observers;
use App\Models\Contact;
use App\Models\ContactCompletion;
class ContactDataObserver
{
    public $trackedFields = [
        'name', 'mobile', 'mobile2', 'email', 'company_name', 'city_id', 'area_id', 'contact_source_id', 'job_title_id', 'industry_id', 'major_id', 'notes', 'activity_id', 'gender', 'birth_date',
        'national_id',
    ];
    public function created(Contact $contact)
    {
        $data = $contact->getAttributes();

        foreach ($this->trackedFields as $field) {
            if (isset($data[$field])) {
                ContactCompletion::create([
                    'contact_id' => $contact->id,
                    'property_name' => $field,
                    'completed_by' => auth()->id(),
                ]);
            }
        }
    }

    public function updating(Contact $contact)
    {
        $changes = $contact->getDirty();

        foreach ($changes as $field => $value) {
            if (in_array($field, $this->trackedFields)) {
                $isExist = (ContactCompletion::where('contact_id',$contact->id)->where('property_name',$field)->count() > 0)?true:false;
                if(!$isExist)
                {
                    ContactCompletion::create([
                        'contact_id' => $contact->id,
                        'property_name' => $field,
                        'completed_by' => auth()->id(),
                    ]);
                }

            }
        }
    }
}
