<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{

    /**
     * get a user wise card statistics.
     */
    public function usersCardStatistics(): JsonResponse
    {
        $userWithTask = User::query()->withCount('tasks')->get();

        $userChartData['labels'] = collect($userWithTask)->pluck('name')->toArray();
        $userChartData['datasets'] = [
            'label' => 'card',
            'data'            => collect($userWithTask)->pluck('tasks_count')->toArray(),
            'backgroundColor' => [
                'rgba(244, 122, 31)',
                'rgba(253, 187, 47)',
                'rgba(55, 123, 43)',
                'rgba(122, 193, 66)',
                'rgba(0, 124, 195)',
            ],
            'borderWidth'     => 1
        ];


        return new JsonResponse([
            "code" => 200,
            "status" => "success",
            "message" => "Phase delete successfully.!",
            "data" => $userChartData ?? []
        ]);
    }

    /**
     * get a completed task statistics.
     */
    public function completedCardStatistics(): JsonResponse
    {
        $weekCompletedTask = Task::query()->whereDate('completed_at', '>=', Carbon::now()->subWeek())->count();
        $monthCompletedTask = Task::query()->whereDate('completed_at', '>=', Carbon::now()->subMonth())->count();

        $taskChartData['labels'] = ["month" , "week"];
        $taskChartData['datasets'] = [
            'label' => 'card',
            'data'            => [$monthCompletedTask, $weekCompletedTask],
            'backgroundColor' => [
                'rgba(244, 122, 31)',
                'rgba(253, 187, 47)',
            ],
            'borderWidth'     => 1
        ];


        return new JsonResponse([
            "code" => 200,
            "status" => "success",
            "message" => "Phase delete successfully.!",
            "data" => $taskChartData ?? []
        ]);
    }
}
