<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use App\Observers\ContactDataObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use stdClass;

class Contact extends Model
{
    use SoftDeletes;


	protected $table = 'contacts';

	protected $hidden = [

    ];

	protected $guarded = [];

	protected $dates = ['deleted_at','birth_date'];


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('assigned', function (Builder $builder) {
            if (auth()->user()->type == "Employee" && auth()->user()->employee->has_branch_access == 0 ) {
                $builder->where(function ($query) {
                    $query->where('employee_id', auth()->user()->context_id)
                            ->orWhere(function ($query) {
                                // Add the condition to filter records related to branch employees here

                                    $query->whereNull('employee_id')->where('created_by', auth()->user()->context_id);

                            });
                });
            } elseif (auth()->user()->type == "Employee" && auth()->user()->employee->has_branch_access == 1) {
                $builder->where(function ($query) {
                    $query->where('employee_id', auth()->user()->context_id)
                        ->orWhere(function ($query) {
                            // Add the condition to filter records related to branch employees here
                            $query->whereIn('employee_id', function ($subQuery) {
                                $subQuery->select('id')
                                    ->from('employees')
                                    ->where('branch_id', auth()->user()->employee->branch_id);
                            });
                        })->orWhere(function ($query) {
                            // Add the condition to filter records related to branch employees here
                            $query->whereIn('created_by', function ($subQuery) {
                                $subQuery->select('id')
                                    ->from('employees')
                                    ->where('branch_id', auth()->user()->employee->branch_id);
                            })->whereIn('employee_id', function ($subQuery) {
                                $subQuery->select('id')
                                    ->from('employees')
                                    ->where('branch_id', auth()->user()->employee->branch_id);
                            });
                        })->orWhere(function ($query) {
                            // Add the condition to filter records related to branch employees here
                            $query->whereIn('created_by', function ($subQuery) {
                                $subQuery->select('id')
                                    ->from('employees')
                                    ->where('branch_id', auth()->user()->employee->branch_id);
                            })->whereNull('employee_id')->where('created_by', auth()->user()->context_id);
                        })->orWhere(function ($query) {
                            $query->whereNull('employee_id')->where('created_by', auth()->user()->context_id);
                        });
                });
            }
        });
    }

	public function customer()
    {
        return $this->hasOne(Customer::class,'id','customer_id');
    }

    public function completions()
    {
        return $this->hasMany(ContactCompletion::class);
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Contact_category','lead_cteagories','contact_id','contact_category_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class,'id','employee_id');
    }



    public function jobTitle()
    {
        return $this->belongsTo(Job_title::class, 'job_title_id');
    }



    public function contactSource()
    {
        return $this->belongsTo(Contact_source::class, 'contact_source_id');
    }


    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activate::class, 'activity_id');
    }

    public function sub_activity()
    {
        return $this->belongsTo(Interest::class, 'interest_id');

    }

	public function leadHistories()
	{
		return $this->hasMany(LeadHistory::class);
	}


	public function getStatusInfoAttribute()
	{
		$statusClass = '';
		switch($this->status) {
			case 'new':
				$statusClass = 'badge bg-primary';
				break;
			case 'contacted':
				$statusClass = 'badge bg-success';
				break;
			case 'qualified':
				$statusClass = 'badge bg-warning';
				break;
			case 'converted':
				$statusClass = 'badge bg-info';
				break;
			default:
				$statusClass = 'badge bg-secondary';
				break;
		}
		return ['class'=> $statusClass,'status'=>trans('admin.'.ucfirst($this->status))];
	}

    public function getContactCategoryAttribute()
    {
        $categoryString = new stdClass();
        $categoryString->name = "";
        foreach ($this->categories as $category) {
            $categoryString->name .= ", ".$category->name;
        }
        return $categoryString;
    }


    public function getCompletionPercentageAttribute()
    {
        $contactObserver = new ContactDataObserver();
        $totalFields = count($contactObserver->trackedFields);
        $completedFields = ContactCompletion::where('contact_id', $this->id)->count();

        if ($totalFields === 0) {
            return 0; // Avoid division by zero
        }

        $percentage = ($completedFields / $totalFields) * 100;
        return round($percentage);
    }

    public function setCustomAttributesAttribute($value)
    {
        $this->attributes['custom_attributes'] = json_encode($value);
    }

    public function getCustomAttributesAttribute($value)
    {
        return json_decode($value, true);
    }



}
