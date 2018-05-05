<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'exams', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('department_id');
                $table->string('session', 15);
                $table->string('levelTerm', 20);
                $table->unsignedInteger('subject_id');
                $table->unsignedInteger('students_id');
                $table->string('exam');
                $table->decimal('raw_score', 6, 2)->default(0.00);
                $table->decimal('percentage', 6, 2)->default(0.00);
                $table->decimal('weight', 6, 2)->default(0.00);
                $table->decimal('percentage_x_weight', 6, 2)->default(0.00);
                $table->timestamps();
                $table->softDeletes();
                $table->foreign('subject_id')
                    ->references('id')
                    ->on('subject');
                $table->foreign('students_id')
                    ->references('id')
                    ->on('students');
                $table->foreign('department_id')
                    ->references('id')
                    ->on('department');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exams');
    }
}
