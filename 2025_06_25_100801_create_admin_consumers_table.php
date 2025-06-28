<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admin_consumers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('meter_no')->unique(); // Added meter number field
            $table->string('contact_number');
            $table->text('address')->nullable();
            $table->enum('consumer_type', ['residential', 'commercial', 'institutional']);
            $table->enum('status', ['active', 'inactive', 'disconnected', 'cut']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_consumers');
    }
};