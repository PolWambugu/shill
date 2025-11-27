Schema::create('resource_usages', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->decimal('water_liters', 10, 2);
    $table->decimal('fuel_liters', 10, 2)->nullable();
    $table->date('recorded_at');
    $table->timestamps();
});