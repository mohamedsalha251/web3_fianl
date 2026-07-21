<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->string('phone', 30)->nullable()->after('email');
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->string('gender', 20)->nullable()->after('date_of_birth');
            $table->text('address')->nullable()->after('gender');
            $table->string('photo')->nullable()->after('address');
            $table->boolean('status')->default(true)->after('photo');
            $table->text('notes')->nullable()->after('status');

            // These legacy fields are retained for existing routes and data.
            $table->string('first_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
        });

        // Preserve the display name of records created before this migration.
        DB::table('students')
            ->whereNull('name')
            ->orderBy('id')
            ->eachById(function (object $student): void {
                DB::table('students')
                    ->where('id', $student->id)
                    ->update([
                        'name' => trim(($student->first_name ?? '').' '.($student->last_name ?? '')),
                    ]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'phone',
                'date_of_birth',
                'gender',
                'address',
                'photo',
                'status',
                'notes',
            ]);
        });
    }
};
