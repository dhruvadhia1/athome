<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('bookings')) {
            Schema::create('bookings', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('service_id');
                $table->unsignedBigInteger('customer_id');
                $table->unsignedBigInteger('provider_id');
                $table->date('date');
                $table->time('time');
                $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
                $table->decimal('price', 10, 2);
                $table->timestamps();
                
                $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
                $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }


    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};