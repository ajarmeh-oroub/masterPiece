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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price');
            $table->integer('stock');
            $table->foreignId('subcategory_id')->constrained('sub_categories')->cascadeOnDelete();
            $table->tinyInteger('visible')->default(1);
            $table->string("main_image", 255);
            $table->boolean("is_package")->default(false);
            $table->text("warnings")->nullable();
            $table->text("disclaimer")->nullable();
            $table->text("other_ingredients")->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->morphs("created_by");
            // Fields specific to supplements
            $table->text('nutritional_information')->nullable();
            $table->foreignId('brand_id')->constrained("brands")->cascadeOnDelete();
            $table->string('skin_type')->nullable();
            $table->text('active_ingredients')->nullable();
            $table->string('usage_instructions')->nullable();
            $table->decimal('bottle_volume', 8, 2)->nullable(); // Volume in milliliters (ml) or fluid ounces (oz)
            $table->string('bottle_material')->nullable();  // Material of the bottle (e.g., plastic, glass)
            $table->string('bottle_type')->nullable();  // Type of bottle (e.g., bottle, jar, tube)
            $table->string('cap_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
