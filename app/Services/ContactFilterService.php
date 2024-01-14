<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class ContactFilterService
{
    private $filterQueryBuilder;
    public function filter(array $filters)
    {
        $filters = array_filter($filters, function ($value) {
            // Keep only non-null and non-empty values
            return !is_null($value) && $value !== "";
        });

        $this->filterQueryBuilder =  Contact::query()
            ->when(isset($filters['gender']), function ($query) use ($filters) {
                $query->where('gender', $filters['gender']);
            })
            ->when(isset($filters['status']), function ($query) use ($filters) {
                if($filters['status'] == "trashed")
                {
                    $query->where('is_trashed',1);
                }elseif($filters['status'] == "inactive"){
                    $query->where('is_active',0);
                }else{
                    $query->where('status', $filters['status'])->where('is_active',1)->where('is_trashed',0);
                }
            })
            ->when(!isset($filters['status']), function ($query) use ($filters) {
                $query->where('is_active',1)->where('is_trashed',0);
            })
            ->when(isset($filters['name']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(isset($filters['mobile']), function ($query) use ($filters) {
                $query->where('mobile', 'like', '%' . $filters['mobile'] . '%');
            })
            ->when(isset($filters['mobile2']), function ($query) use ($filters) {
                $query->where('mobile2', 'like', '%' . $filters['mobile2'] . '%');
            })
            ->when(isset($filters['email']), function ($query) use ($filters) {
                $query->where('email', 'like', '%' . $filters['email'] . '%');
            })
            ->when(isset($filters['company_name']), function ($query) use ($filters) {
                $query->where('company_name', 'like', '%' . $filters['company_name'] . '%');
            })
            ->when(isset($filters['job_title_id']), function ($query) use ($filters) {
                $query->where('job_title_id', $filters['job_title_id']);
            })
            ->when(isset($filters['campaign_id']), function ($query) use ($filters) {
                $query->where('campaign_id', $filters['campaign_id']);
            })
            ->when(isset($filters['contact_category_id']), function ($query) use ($filters) {
                if(is_array($filters['contact_category_id']) && count($filters['contact_category_id']) > 0)
                {
                    $query->whereHas('categories', function ($query) use ($filters) {
                        $query->whereIn('contact_categories.id', $filters['contact_category_id']);
                    });
                }
            })
            ->when(isset($filters['contact_source_id']), function ($query) use ($filters) {
                $query->where('contact_source_id', $filters['contact_source_id']);
            })
            ->when(isset($filters['city_id']), function ($query) use ($filters) {
                $query->where('city_id', $filters['city_id']);
            })
            ->when(isset($filters['area_id']), function ($query) use ($filters) {
                $query->where('area_id', $filters['area_id']);
            })
            ->when(isset($filters['industry_id']), function ($query) use ($filters) {
                $query->where('industry_id', $filters['industry_id']);
            })
            ->when(isset($filters['major_id']), function ($query) use ($filters) {
                $query->where('major_id', $filters['major_id']);
            })
            ->when(isset($filters['activity_id']), function ($query) use ($filters) {
                $query->where('activity_id', $filters['activity_id']);
            })
            ->when(isset($filters['interest_id']), function ($query) use ($filters) {
                $query->where('interest_id', $filters['interest_id']);
            })
            ->when(isset($filters['national_id']), function ($query) use ($filters) {
                $query->where('national_id', $filters['national_id']);
            })

            ->when(isset($filters['notes']), function ($query) use ($filters) {
                $query->where('notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(isset($filters['assignment_type']), function ($query) use ($filters) {
                if($filters['assignment_type'] == 'assigned')
                {
                    $query->whereNotNull('employee_id');
                }else
                {
                    $query->whereNull('employee_id');
                }
            })
            ->when((isset($filters['from_date']) && isset($filters['to_date'])), function ($query) use ($filters) {
                // Logic for dateBetween when both from_date and to_date are provided
                $query->where(DB::raw('DATE(created_at)'), '>=', $filters['from_date'])
                ->where(DB::raw('DATE(created_at)'), '<=', $filters['to_date']);
            })
            ->when(isset($filters['search_employee_id']),function($query) use($filters){
                $query->where('employee_id',$filters['search_employee_id']);
            })
            ->when(isset($filters['search_branch_id']),function($query) use($filters){
                if(!isset($filters['search_employee_id']) || $filters['search_employee_id'] == null || $filters['search_employee_id'] == "")
                {
                    $employeesOfBranch = Employee::where('branch_id',$filters['search_branch_id'])->get()->pluck('id')->toArray();

                        $query->whereIn('employee_id',$employeesOfBranch ??[]);

                }
            })
            ->orderBy('id','desc');




        return $this;
    }

    public function apply($page = 1,$limit = 10)
    {
        $pageNumber = $page;
        $contacts =  $this->filterQueryBuilder->paginate($limit, ['*'], 'page', $pageNumber);
        $paginationInfo = [
            'total' => $contacts->total(),
            'per_page' => $contacts->perPage(),
            'current_page' => $contacts->currentPage(),
            'last_page' => $contacts->lastPage(),
        ];
        return [
            'results' => $contacts,
            'paginationInfo' => $paginationInfo,
        ];
    }
    public function get()
    {
        return $this->filterQueryBuilder->get();
    }
}
