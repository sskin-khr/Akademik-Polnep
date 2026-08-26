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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('email');
            }
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->nullable();
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('views')->default(0);
            $table->integer('read_time')->default(0);
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->string('thumbnail')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('struktur_organisasi', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('jabatan')->nullable();
            $table->string('nip')->nullable();
            $table->string('photo')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('struktur_organisasi')->nullOnDelete();
            $table->integer('order_position')->default(0);
        });

        Schema::create('faq', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->text('answer');
            $table->integer('order_position')->default(0);
            $table->timestamps();
        });

        Schema::create('visi_misi', function (Blueprint $table) {
            $table->id();
            $table->string('section_type');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });

        Schema::dropIfExists('visi_misi');
        Schema::dropIfExists('faq');
        Schema::dropIfExists('struktur_organisasi');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('categories');
    }
};
