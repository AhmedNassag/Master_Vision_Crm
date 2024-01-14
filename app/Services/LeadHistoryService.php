<?php 
namespace App\Services;
use App\DTOs\LeadHistoryData;
use App\Models\Contact;
use App\Models\LeadHistory;

class LeadHistoryService 
{
    public function logAction(LeadHistoryData $data)
    {
        LeadHistory::create([
            'contact_id' => $data->contactId,
            'action' => $data->action,
            'related_model_id' => $data->relatedModelId,
            'placeholders' => json_encode($data->placeholders),
            'created_by' => $data->createdBy,
        ]);
    }

    public function organizeLeadHistoryForTimeline(Contact $contact)
    {
        $leadHistory = $contact->leadHistories()->orderBy('created_at','desc')->get();

        $timelineData = [];

        foreach ($leadHistory as $record) {
            $date = $record->created_at->toDateString();

            if (!isset($timelineData[$date])) {
                $timelineData[$date] = [];
            }

            $timelineData[$date][] = $record;
        }

        return $timelineData;
    }
}
