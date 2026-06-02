<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books_library', function (Blueprint $table) {
            $table->string('slug', 200)->nullable()->unique()->after('title');
            $table->string('currency', 10)->default('PKR')->after('price');
            $table->decimal('delivery_charge_local', 10, 2)->default(0)->after('currency');
            $table->decimal('delivery_charge_international', 10, 2)->default(0)->after('delivery_charge_local');
        });

        $books = DB::table('books_library')->orderBy('id')->get();
        $usedSlugs = [];

        foreach ($books as $book) {
            $base = Str::slug($book->title ?? 'book');
            if ($base === '') {
                $base = 'book';
            }

            $slug = $base;
            $counter = 1;

            while (in_array($slug, $usedSlugs, true)) {
                $slug = $base . '-' . $counter;
                $counter++;
            }

            $usedSlugs[] = $slug;

            DB::table('books_library')->where('id', $book->id)->update([
                'slug' => $slug,
                'currency' => 'PKR',
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('books_library', function (Blueprint $table) {
            $table->dropColumn(['slug', 'currency', 'delivery_charge_local', 'delivery_charge_international']);
        });
    }
};
