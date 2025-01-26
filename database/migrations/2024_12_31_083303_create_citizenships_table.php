<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citizenships', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique(); // Citizenship number
            $table->date('dob');
            $table->string('name');
            $table->date('issue_date');
            $table->string('address');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('token')->nullable();
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
        Schema::table('citizenships', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('token');
        });
    }
};
