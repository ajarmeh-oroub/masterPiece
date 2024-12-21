<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // Name of the person submitting the contact form
            $table->string('email');             // Email of the person
            $table->string('subject');           // Subject of the message
            $table->text('message');             // The actual message from the contact form
            $table->enum('status', ['unread', 'read', 'responded'])->default('unread'); // Status of the message
            $table->timestamps();                // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
