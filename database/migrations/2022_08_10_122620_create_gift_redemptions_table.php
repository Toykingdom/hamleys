<?php

use App\Models\Child;
use App\Models\Gift;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftRedemptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_redemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Gift::class);
            $table->foreignIdFor(Child::class);
            $table->foreignIdFor(User::class);
            $table->integer('cost')->default(0);
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
        Schema::dropIfExists('gift_redemptions');
    }
}
