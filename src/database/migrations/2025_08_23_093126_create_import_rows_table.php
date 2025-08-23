<?php

use DamichiXL\Import\Models\ImportBatch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('import_rows', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ImportBatch::class)->constrained('import_batches');
            $table->json('data');
            $table->boolean('success')->default(false);
            $table->string('message')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('import_rows');
    }
};
