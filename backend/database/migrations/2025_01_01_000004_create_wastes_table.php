Schema::create('wastes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->decimal('plastic_kg', 8, 2)->default(0);
    $table->decimal('paper_kg', 8, 2)->default(0);
    $table->decimal('organic_kg', 8, 2)->default(0);
    $table->date('recorded_at');
    $table->timestamps();
});