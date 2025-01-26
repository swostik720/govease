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
        Schema::create('birth_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('birthcertificate_number')->unique();
            $table->string('name');
            $table->string('token')->nullable();
            $table->date('issue_date');
            $table->string('address');
            $table->string('father_name');
            $table->string('mother_name');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('birth_date_in_words');
            $table->date('birth_date_in_digits');
            $table->string('birth_time');
            $table->string('gender');
            $table->string('religion');
            $table->string('caste');
            $table->string('registrar_name');
            $table->date('registration_date');
            $table->text('remarks')->nullable();
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
        Schema::table('birth_certificates', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('token');
        });
    }
};
