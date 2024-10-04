<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $statuses = ['hadir', 'izin', 'alpa', 'libur'];
        $startDate = \Carbon\Carbon::now()->startOfYear();
        $endDate = \Carbon\Carbon::now()->endOfYear();

        $period = \Carbon\CarbonPeriod::create($startDate, '1 day', $endDate);

        foreach ($period as $date) {
            Attendance::create([
                'date' => $date,
                'status' => $statuses[array_rand($statuses)],
            ]);
        }
    }
}
