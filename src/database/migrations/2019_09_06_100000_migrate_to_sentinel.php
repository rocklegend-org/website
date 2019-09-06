<?php
/**
 * Part of the Sentinel package.
 * NOTICE OF LICENSE
 * Licensed under the Cartalyst PSL License.
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package        Sentinels
 * @version        2.0.1
 * @author         Cartalyst LLC
 * @license        Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link           http://cartalyst.com
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MigrateToSentinel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'activations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('code');
            $table->boolean('completed')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        }
        );
        Schema::create(
            'persistences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('code');
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->unique('code');
        }
        );
        Schema::create(
            'reminders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('code');
            $table->boolean('completed')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        }
        );
        Schema::create(
            'roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('name');
            $table->text('permissions')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->unique('slug');
        }
        );
        Schema::create(
            'role_users', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->nullableTimestamps();
            $table->engine = 'InnoDB';
            $table->primary(['user_id', 'role_id']);
        }
        );
        Schema::table(
            'throttle', function (Blueprint $table) {
            $table->string('type')->after('user_id');
            $table->renameColumn('ip_address', 'ip');
            $table->timestamps();
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
        Schema::drop('activations');
        Schema::drop('persistences');
        Schema::drop('reminders');
        Schema::drop('roles');
        Schema::drop('role_users');
    }
}