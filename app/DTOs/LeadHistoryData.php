<?php
namespace App\DTOs;

class LeadHistoryData
{
    public $contactId;
    public $action;
    public $relatedModelId;
    public $placeholders;
    public $createdBy;

    public function __construct($contactId, $action, $relatedModelId, $placeholders, $createdBy)
    {
        $this->contactId = $contactId;
        $this->action = $action;
        $this->relatedModelId = $relatedModelId;
        $this->placeholders = $placeholders;
        $this->createdBy = $createdBy;
    }
}