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
        Schema::table('guests', function (Blueprint $table) {
            // Participation type
            $table->enum('participation_type', ['attendee', 'speaker', 'sponsor', 'volunteer', 'vip'])->default('attendee')->after('event_id');
            
            // Registration tracking
            $table->enum('registration_status', ['pending', 'confirmed', 'cancelled', 'attended'])->default('pending')->after('status');
            
            // Check-in for event day
            $table->boolean('checked_in')->default(false)->after('registration_status');
            $table->timestamp('checked_in_at')->nullable()->after('checked_in');
            
            // User relationship (if registered user)
            $table->unsignedBigInteger('user_id')->nullable()->after('email');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            
            // Additional info
            $table->text('dietary_requirements')->nullable()->after('notes');
            $table->string('company')->nullable()->after('notes');
            $table->string('position')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'participation_type',
                'registration_status',
                'checked_in',
                'checked_in_at',
                'user_id',
                'dietary_requirements',
                'company',
                'position',
            ]);
        });
    }
};
