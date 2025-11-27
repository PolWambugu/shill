Schema::create('emissions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->decimal('electricity_kwh', 10, 2);
    $table->decimal('mileage_km', 10, 2);
    $table->integer('flights');
    $table->decimal('total_co2', 10, 2);
    $table->timestamp('calculated_at')->useCurrent();
    $table->timestamps();
});