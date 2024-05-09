<?php

namespace App\Http\Controllers;

use App\Models\DateRun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimetableController extends Controller
{
    public function index()
    {
        $profileId = session()->get('profile_id');
        $clubManageId = session()->get('club_managed_id');
        session()->put('page_is_active', 'timetable');

        $dateRun = DateRun::select('date')->where('profile_id', $profileId)->first();

        $data['profileId'] = $profileId;
        $data['clubManagedId'] = session()->get('club_managed_id');
        $data['timetable'] = DB::table('timetables')
            ->join('divisions', 'divisions.id', '=', 'timetables.division_id')
            ->select(
                'timetables.profile_id',
                'timetables.division_id',
                'divisions.name as division_name',
                'timetables.period',
                'timetables.date',
                'timetables.home_id',
                'timetables.home_name',
                'timetables.away_id',
                'timetables.away_name',
                'timetables.is_play',
                'timetables.score_home',
                'timetables.score_away'
            )
            ->where('timetables.period', date('Y', $dateRun->date))
            ->where('timetables.profile_id', $profileId)
            ->Where('timetables.home_id', '=', $clubManageId)
            ->orWhere('timetables.away_id', '=', $clubManageId)
            ->orderBy('timetables.date')
            ->get();

        return view('timetable.index', $data);
    }
}
