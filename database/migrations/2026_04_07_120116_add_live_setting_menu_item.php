<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Skip if already inserted
        if (DB::table('menus')->where('route', 'live_setting')->exists()) {
            return;
        }

        // Shift all menu items at seq_no >= 10 up by 1 to make room
        DB::table('menus')
            ->where('seq_no', '>=', 10)
            ->orderByDesc('seq_no')
            ->each(function ($menu) {
                DB::table('menus')
                    ->where('id', $menu->id)
                    ->update(['seq_no' => $menu->seq_no + 1]);
            });

        // Insert Live Setting menu item at position 10 (after Settings)
        DB::table('menus')->insert([
            'name'       => 'Live Setting',
            'route'      => 'live_setting',
            'image'      => 'fa-tower-broadcast',
            'seq_no'     => 10,
            'enable'     => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('menus')->where('route', 'live_setting')->delete();

        DB::table('menus')
            ->where('seq_no', '>', 10)
            ->orderBy('seq_no')
            ->each(function ($menu) {
                DB::table('menus')
                    ->where('id', $menu->id)
                    ->update(['seq_no' => $menu->seq_no - 1]);
            });
    }
};
