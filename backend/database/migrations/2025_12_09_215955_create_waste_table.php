public function up(): void
{
    Schema::create('waste', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->float('plastic_kg')->default(0);
        $table->float('paper_kg')->default(0);
        $table->float('organic_kg')->default(0);
        $table->timestamps();
    });
}
