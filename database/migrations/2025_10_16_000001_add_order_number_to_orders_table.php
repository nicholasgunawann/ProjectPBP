<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if column already exists
        if (!Schema::hasColumn('orders', 'order_number')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('order_number')->nullable()->after('id');
            });

            // Generate order numbers for existing orders
            $orders = DB::table('orders')->get();
            foreach ($orders as $order) {
                DB::table('orders')
                    ->where('id', $order->id)
                    ->update([
                        'order_number' => 'ORD-' . date('Ymd', strtotime($order->created_at)) . '-' . strtoupper(Str::random(6))
                    ]);
            }

            // Now make it unique
            Schema::table('orders', function (Blueprint $table) {
                $table->string('order_number')->unique()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_number');
        });
    }
};
