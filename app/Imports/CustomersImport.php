<?php
namespace App\Imports;

use App\Models\Invoice;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Contact;
use App\Models\Contact_source;
use App\Models\Customer;
use App\Models\Major;
use Carbon\Carbon;

class CustomersImport implements ToCollection
{
    private $columnMappings;
    private $contactSourceId;
    private $activityId;

    public function __construct($columnMappings,$contactSourceId,$activityId)
    {
        $this->columnMappings = $columnMappings;
        $this->contactSourceId  = $contactSourceId;
        $this->activityId  = $activityId;

    }

    public function collection(Collection $rows)
    {
        $skipFirstRow = true;

        foreach ($rows->toArray() as $row) {
            $contactData = [];
            $contactData['notes'] = "";
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

            // Create or update the contact record based on your logic
            if (!empty($contactData) &&  $contactData['name'] != null && $contactData['mobile'] != null ) {
                $contactData['contact_source_id'] = $this->contactSourceId;
                $contactData['activity_id'] = $this->activityId;
				if(auth()->user()->type != 'Admin' && auth()->user()->employee->has_branch_access !=1){
					$contactData['employee_id'] = auth()->user()->context_id;
				}
                $contactData['created_by'] = auth()->user()->context_id;
                $customer = Customer::where('mobile',$contactData['mobile'])->first();
                if(!$customer)
                {
                    $customer = Customer::create($contactData);
                }
                $randomNumber = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
                Invoice::create([
                    'customer_id' => $customer->id,
                    'description'=> "",
                    'status'=>'paid',
                    'amount'=> 0,
                    'invoice_date'=>Carbon::now()->format('Y-m-d'),
                    'total_amount'=>0,
                    'amount_paid'=>0,
                    'invoice_number'=>$randomNumber,
                    'debt'=>0,
                    'activity_id'=>$this->activityId,
                ]);
            }
        }
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
