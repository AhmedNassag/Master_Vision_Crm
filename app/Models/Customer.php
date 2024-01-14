<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use App\Services\PointsCalculationService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Customer extends Model
{
    use SoftDeletes;

	protected $table = 'customers';

	protected $hidden = [

    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('branch', function (Builder $builder) {
            if (auth()->user()->type == "Employee" && auth()->user()->employee->has_branch_access != 1 ) {
                $builder->where(function ($query) {
                    $query->orWhere('created_by', auth()->user()->context_id);
                });
            }
        });
    }

	public function jobTitle()
    {
        return $this->belongsTo(Job_title::class, 'job_title_id');
    }

    public function customerCategory()
    {
        return $this->belongsTo(Contact_category::class, 'contact_category_id');
    }

    public function customerSource()
    {
        return $this->belongsTo(Contact_source::class, 'contact_source_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
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

	public function invoices()
	{
		return $this->hasMany(Invoice::class);
	}

    public function reminders()
	{
		return $this->hasMany(ReorderReminder::class);
	}

    public function attachments()
    {
		return $this->hasMany(Attachment::class);

    }

    public function parent()
    {
		return $this->belongsTo(Customer::class,'parent_id');
    }

    public function related_customers()
    {
		return $this->hasMany(Customer::class,'parent_id');
    }

    public function points()
    {
        return $this->hasMany(Point::class, 'customer_id');
    }

    public function calculateSumOfPoints()
    {
        return $this->points()->where('expiry_date','>=',Carbon::today()->format('Y-m-d'))->sum('points');
    }

    public function calculatePointsValue()
    {
        $service = new PointsCalculationService();
        return $service->getPointsValue($this->id);

    }
}
