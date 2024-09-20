<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePredictionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->integer('prediction');
            $table->string('token');
            $table->timestamps();
        });

        // Generate 100 dummy data
        $predictions = [];
        $startDate = now()->subDays(10);

        for ($i = 52444; $i <= 52999; $i++) {
            $predictions[] = [
                'prediction' => $i,
                'token' => $startDate->addDay()->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('predictions')->insert($predictions);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predictions');
    }
}
