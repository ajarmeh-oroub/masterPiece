<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("pharmacies", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("address");
            $table->integer("phone");
            $table->string("email")->unique();
            $table->string("logo"  , 255);
            $table->string("password");
            $table->string("pharm_phone");
            $table->string("pharm_email");
            $table->string("owner_phone");
            $table->string("owner_email");   
            $table->string("description");
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->boolean('active')->default(true);
            $table->string('facebook')->nullable();  
            $table->string('instagram')->nullable(); 
            $table->string('twitter')->nullable(); 
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean("delivers")->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacies');
    }
};
