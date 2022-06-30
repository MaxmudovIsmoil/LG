<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('phone');
            $table->integer('city_id');
            $table->enum('status', [1, 0]);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });


//        \Illuminate\Support\Facades\DB::table('roles')->insert([
//                'full_name' => 'Administration',
//                'username'  => 'admin',
//                'password'  => \Illuminate\Support\Facades\Hash::make('123'),
//                'phone'     => '+998332087090',
//                'rule_id'   => '1',
//                'city_id'   => '1',
//                'status'    => '1',
//                'created_at'=> now(),
//                'updated_at'=> now(),
//        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
