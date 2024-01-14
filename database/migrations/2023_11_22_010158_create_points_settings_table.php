<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ## Conversion Rate: The conversion_rate typically represents the ratio or factor used to convert points into a monetary currency. It determines the value of each point in terms of the currency. For example, if the conversion rate is 0.01, it means that each point is equivalent to 0.01 units of the currency. This rate is used when calculating the monetary value of points earned or redeemed.

        ## Sales Conversion Rate: On the other hand, the sales_conversion_rate is specific to the conversion of sales into points. It represents the ratio or factor used to convert the value of a purchase or sale into points. For instance, if the sales conversion rate is 10, it means that for every unit of currency spent on a purchase, the customer earns 10 points. This rate is used when calculating the points earned based on sales or purchases.
        Schema::create('points_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('sub_activity_id')->nullable();
            $table->decimal('conversion_rate', 8, 2);
            $table->decimal('sales_conversion_rate', 8, 2);
            $table->integer('points');
            $table->integer('expiry_days');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('points_settings');
    }
}
