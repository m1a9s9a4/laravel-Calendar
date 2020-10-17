<?php

namespace App\Http\Controllers;

use App\Services\Google;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Mkato\Library\Calendar\Calendar;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $google;
    protected $calendar;

    public function __construct(
        Google $google,
        Calendar $calendar
    )
    {
        $this->google = $google;
        $this->calendar = $calendar;
    }

    public function index()
    {
        $this->google->setAuthCode();
        // set your emails to this. need to authenticate via login page.
        $ids = ['example@example.com'];
        $this->calendar->setClient($this->google->getClient());

        $from = Carbon::today(config('app.timezone'));
        $to = Carbon::today(config('app.timezone'))->addDays(7);
        $free_time = $this->calendar->getFreeTimes($ids, $from, $to);
        $busy_time = $this->calendar->getBusyTimes($ids, $from, $to);
    }
}
