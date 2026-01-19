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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();$table->string('nombres', 50);
            $table->string('apellidos', 50);
            $table->string('birthdate', 10);
            $table->string('celular', 10);
            $table->string('genero', 10);
            $table->string('photo', 255)->nullable();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('role')->default('administrador');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
