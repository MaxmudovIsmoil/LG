<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('roles')->insert(
            array(
                [
                    'name' => 'Admin',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Editor',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Promoter',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Supervisor',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
