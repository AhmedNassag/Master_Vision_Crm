<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('amount_paid', 10, 2)->default(0); // Amount paid initially set to 0
            $table->decimal('debt', 10, 2); // Debt is the remaining amount to be paid
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('activity_id');
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'sent', 'paid', 'void'])->default('void');
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
        Schema::dropIfExists('invoices');
    }
}
