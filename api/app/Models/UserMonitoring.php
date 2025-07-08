<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UserMonitoring extends Model
{
    /** @use HasFactory<\Database\Factories\UserMonitoringFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'part_of_page',
        'timestamp',
        'token',
        'reference_id',
    ];

    static public function calculateAverageUsageByPartOfPage(): Collection
    {
        $usageData = self::calculateAverageUsage();

        $groupedByPath = $usageData->groupBy('part_of_path')->map(function ($items, $path) {
            return [
                'part_of_path' => $path,
                'average_usage' => $items->avg('average_usage'),
                'total_tokens' => $items->count(),
                'details' => $items->toArray() // Opcional: mantém os detalhes por token
            ];
        })->values();

        return $groupedByPath;
    }

    static private function calculateAverageUsage(): Collection
    {
        $records = UserMonitoring::orderBy('token')
            ->orderBy('part_of_page')
            ->orderBy('timestamp')
            ->get()
            ->map(function ($item) {
                // Converte timestamp string para Carbon se necessário
                $item->timestamp = is_string($item->timestamp)
                    ? \Carbon\Carbon::parse($item->timestamp)
                    : $item->timestamp;
                return $item;
            });

        $grouped = $records->groupBy(['token', 'part_of_page']);

        $results = collect();

        foreach ($grouped as $token => $paths) {
            foreach ($paths as $path => $entries) {
                $total = 0;
                $count = 0;
                $previous = null;

                foreach ($entries as $entry) {
                    if ($previous) {
                        $diff = $entry->timestamp->diffInSeconds($previous->timestamp);

                        if ($diff <= 4) {
                            $total += $diff;
                            $count++;
                        }
                    }
                    $previous = $entry;
                }

                $average = $count > 0 ? $total / $count : 0;

                $results->push([
                    'token' => $token,
                    'part_of_page' => $path,
                    'average_usage' => $average,
                    'valid_intervals' => $count
                ]);
            }
        }

        return $results;
    }
}
