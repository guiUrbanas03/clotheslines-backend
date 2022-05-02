<?php

use App\Enums\UserRoles;
use App\Enums\UserStatus;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 320)->unique();
            $table->string('password', 999);
            $table->enum('status', [
                UserStatus::ACTIVE,
                UserStatus::BANNED,
                UserStatus::DELETED
            ])->default(UserStatus::ACTIVE);
            $table->enum('role', [
                UserRoles::BASIC_USER,
                UserRoles::ADMIN_USER
            ])->default(UserRoles::BASIC_USER);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
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
};
