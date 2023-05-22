<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->integer('state')->default(1);
            $table->integer('children_count')->default(0);
            $table->integer('store_id');
            $table->dateTime('lock_end_time')->nullable();
            $table->timestamps();
            $table->index('code');
            $table->index('lock_end_time');
            $table->index('store_id');
            // $table->primary(['code', 'store_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_codes');
    }
}
