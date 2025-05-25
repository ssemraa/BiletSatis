<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('ticketmaster_id')->nullable()->unique();
            $table->string('name');
            $table->dateTime('date');
            $table->string('location');
            $table->text('description')->nullable();
            $table->string('type')->default('concert');
            $table->integer('remaining_tickets')->default(0);
            $table->decimal('price', 8, 2)->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('type');
            
        });
    }
};
