<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Contact;
use App\Models\Contact_source;
use App\Models\Customer;
use App\Models\Major;

class ContactsImport implements ToCollection
{
    private $columnMappings;
    private $contactSourceId;
    private $activityId;

    private $interest_id;
	private $rowsSaved = 0;
    private $rowsSkipped = 0;

    public function __construct($columnMappings,$contactSourceId,$activityId,$interest_id)
    {
        $this->columnMappings = $columnMappings;
        $this->contactSourceId  = $contactSourceId;
        $this->activityId  = $activityId;
        $this->interest_id = $interest_id;

    }

    public function collection(Collection $rows)
    {
        $skipFirstRow = true;
		$k = 0;
		$all_array = [];
        foreach ($rows->toArray() as $row) {
            $contactData = [];
            $contactData["notes"] = "";
            if ($skipFirstRow) {
                $skipFirstRow = false;
                continue;
            }
            $i = 0;
            // Iterate through the column mappings
            foreach ($this->columnMappings as $excelColumn => $mapping) {

                $contactField = $mapping["contact_field"];


                // Get the value from the Excel column
                $excelValue = $row[$i];

                // Apply your import logic here based on the operator and mapping
                if (!empty($contactField)) {
                    // Handle non-empty contact fields

                    // Check if the contactField corresponds to a model
                    if ($this->isModelField($contactField)) {
                        // Get the model class name (e.g., Contact_source for contact_source_id)
                        $modelClassName = $this->getModelClassName($contactField);

                        // Create or retrieve the model record
                        $modelInstance = $this->createOrRetrieveModel($modelClassName, $excelValue);

                        // Assign the model's ID to the contact data
                        if ($modelInstance) {
                            $contactData[$contactField] = $modelInstance->id;
                        }
                    } else {
                        // Handle other contact fields with equal operator
                        if($contactField =="notes")
                        {
                            $contactData[$contactField] .= " <br /> - <b>".$excelColumn." :</b> ".$excelValue;
                        }else
                        {
                            $contactData[$contactField] = $excelValue;
                        }
                    }

                } else {
                    // Handle empty contact fields (if required)
                }
                $i++;
            }
			//$k++;
			//dd($contactData);
			//$all_array [$k]= $contactData;
            // Create or update the contact record based on your logic
            if ( !empty( $contactData ) &&  $contactData['name'] != null && $contactData['mobile'] != null  ) {
                $contactData['contact_source_id'] = $this->contactSourceId;
                $contactData['activity_id'] = $this->activityId;
                $contactData['interest_id'] = $this->interest_id;

				if(auth()->user()->type != 'Admin' && auth()->user()->employee->has_branch_access !=1){
					$contactData['employee_id'] = auth()->user()->context_id;
				}

                $contactData['created_by'] = auth()->user()->context_id;

                $customer = Customer::where('mobile',$contactData['mobile'])->first();
                if($customer)
                {
                    $contactData['customer_id'] = $customer->id;
                }
				
				//$k++;
				//dd($contactData);
				//$all_array [$k]= $contactData;
				$contact = Contact::where('mobile',$contactData['mobile'])->first();
				if(!$contact){
					Contact::create($contactData);
					$this->rowsSaved++;
				}else{
					$this->rowsSkipped++;
				}

            }
        }
		
		//dd($all_array);
    }
	
	
	public function getRowsSavedCount()
    {
        return $this->rowsSaved;
    }

    public function getRowsSkippedCount()
    {
        return $this->rowsSkipped;
    }

    private function isModelField($field)
    {
        // List the contact fields that correspond to models
        $modelFields = ['contact_source_id', 'city_id', 'area_id', 'job_title_id', 'industry_id', 'major_id'];

        return in_array($field, $modelFields);
    }

    private function getModelClassName($field)
    {
        $models =  ['contact_source_id'=>"Contact_source", 'city_id'=>"City", 'area_id'=>"Area", 'job_title_id'=>"Job_title", 'industry_id'=>"Industry", 'major_id'=>"Major"];
        return $models[$field];
    }

    private function createOrRetrieveModel($modelClassName, $excelValue)
    {
        // Create or retrieve the model instance based on the name field
        $modelClassName = "App\Models\\".$modelClassName;
        return  $modelClassName::firstOrCreate(['name' => trim($excelValue)]);
    }
}
