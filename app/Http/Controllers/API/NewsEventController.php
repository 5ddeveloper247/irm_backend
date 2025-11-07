<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsEvent;

class NewsEventController extends Controller
{

    public function getNewsEvents(Request $request)
    {
        $data['news_events'] = NewsEvent::with('attachments')
            ->orderBy('id', 'desc')
            // Show events that haven't ended yet
            ->where('end_date', '>=', date('Y-m-d'))
            ->where('status', 1)
            ->get();

        foreach ($data['news_events'] as $key => $news_event) {

            $data['news_events'][$key]->description = strip_tags($news_event->description);
            $data['news_events'][$key]->description = substr($data['news_events'][$key]->description, 0, 100);
            $data['news_events'][$key]->date = date('d', strtotime($news_event->event_date));
            $data['news_events'][$key]->month = date('M', strtotime($news_event->event_date));
            $data['news_events'][$key]->year = date('Y', strtotime($news_event->event_date));
            $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($news_event->event_date));
            $data['news_events'][$key]->attachments->map(function ($attachment) {
                $attachment->path = str_replace('%2F', '/', url('/', $attachment->path));
            });

            if ($news_event->type == "Recurring") {
                if ($news_event->recurring_type == "Daily") {
                    $data['news_events'][$key]->date = date('d');
                    $data['news_events'][$key]->month = date('M');
                    $data['news_events'][$key]->year = date('Y');
                    $data['news_events'][$key]->new_event_date = date('Y-m-d');

                    if (strtotime(date('Y-m-d')) < strtotime($news_event->event_date)) {
                        $data['news_events'][$key]->date = date('d', strtotime($news_event->event_date));
                        $data['news_events'][$key]->month = date('M', strtotime($news_event->event_date));
                        $data['news_events'][$key]->year = date('Y', strtotime($news_event->event_date));
                        $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($news_event->event_date));
                    }
                } elseif ($news_event->recurring_type == "Weekly") {
                    $repeat_on_day = $news_event->repeat_on ? json_decode($news_event->repeat_on, true) : [];

                    if (strtotime(date('Y-m-d')) < strtotime($news_event->event_date)) {
                        $data['news_events'][$key]->date = date('d', strtotime($news_event->event_date));
                        $data['news_events'][$key]->month = date('M', strtotime($news_event->event_date));
                        $data['news_events'][$key]->year = date('Y', strtotime($news_event->event_date));
                        $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($news_event->event_date));
                    } else {
                        if (!in_array(date('D'), $repeat_on_day)) {
                            $next_day = $this->getNextDayFromRepeatOn($repeat_on_day);
                            $data['news_events'][$key]->date = date('d', strtotime('next ' . $next_day));
                            $data['news_events'][$key]->month = date('M', strtotime('next ' . $next_day));
                            $data['news_events'][$key]->year = date('Y', strtotime('next ' . $next_day));
                            $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime('next ' . $next_day));
                        } else {
                            $data['news_events'][$key]->date = date('d');
                            $data['news_events'][$key]->month = date('M');
                            $data['news_events'][$key]->year = date('Y');
                            $data['news_events'][$key]->new_event_date = date('Y-m-d');
                        }
                    }
                } elseif ($news_event->recurring_type == "Bi-Weekly") {
                    $repeat_on_day = $news_event->repeat_on ? json_decode($news_event->repeat_on, true) : [];

                    if (strtotime(date('Y-m-d')) < strtotime($news_event->event_date)) {
                        $data['news_events'][$key]->date = date('d', strtotime($news_event->event_date));
                        $data['news_events'][$key]->month = date('M', strtotime($news_event->event_date));
                        $data['news_events'][$key]->year = date('Y', strtotime($news_event->event_date));
                        $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($news_event->event_date));
                    } else {
                        $next_day = $this->getNextBiWeeklyDay($news_event->event_date, $repeat_on_day);
                        $data['news_events'][$key]->date = date('d', strtotime($next_day));
                        $data['news_events'][$key]->month = date('M', strtotime($next_day));
                        $data['news_events'][$key]->year = date('Y', strtotime($next_day));
                        $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($next_day));
                    }
                } // REPLACE the Monthly recurring section in getNewsEvents method (around line 81-95)

                elseif ($news_event->recurring_type == "Monthly") {
                    $current_date = date('Y-m-d');
                    $event_date = date('Y-m-d', strtotime($news_event->event_date));

                    // If the original event_date hasn't passed yet, use it
                    if (strtotime($current_date) <= strtotime($event_date)) {
                        $data['news_events'][$key]->date = date('d', strtotime($news_event->event_date));
                        $data['news_events'][$key]->month = date('M', strtotime($news_event->event_date));
                        $data['news_events'][$key]->year = date('Y', strtotime($news_event->event_date));
                        $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($news_event->event_date));
                    } else {
                        // Original event_date has passed, calculate next month's occurrence
                        $next_date = $this->calculateMonthlyRecurrence($news_event);

                        $data['news_events'][$key]->date = date('d', strtotime($next_date));
                        $data['news_events'][$key]->month = date('M', strtotime($next_date));
                        $data['news_events'][$key]->year = date('Y', strtotime($next_date));
                        $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($next_date));
                    }

                    // Check if calculated date exceeds end_date
                    if (strtotime($data['news_events'][$key]->new_event_date) > strtotime($news_event->end_date)) {
                        unset($data['news_events'][$key]);
                    }
                } elseif ($news_event->recurring_type == "Yearly") {
                    $current_date = date('Y-m-d');
                    $event_date = date('Y-m-d', strtotime($news_event->event_date));

                    // If the original event_date hasn't passed yet, use it
                    if (strtotime($current_date) <= strtotime($event_date)) {
                        $data['news_events'][$key]->date = date('d', strtotime($news_event->event_date));
                        $data['news_events'][$key]->month = date('M', strtotime($news_event->event_date));
                        $data['news_events'][$key]->year = date('Y', strtotime($news_event->event_date));
                        $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($news_event->event_date));
                    } else {
                        // Original event_date has passed, calculate next year's occurrence
                        $next_date = $this->calculateYearlyRecurrence($news_event);

                        $data['news_events'][$key]->date = date('d', strtotime($next_date));
                        $data['news_events'][$key]->month = date('M', strtotime($next_date));
                        $data['news_events'][$key]->year = date('Y', strtotime($next_date));
                        $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($next_date));
                    }

                    // Check if calculated date exceeds end_date
                    if (strtotime($data['news_events'][$key]->new_event_date) > strtotime($news_event->end_date)) {
                        unset($data['news_events'][$key]);
                    }
                }
            } elseif ($news_event->type == 'Non-Recurring') {
                if (strtotime(date('Y-m-d')) <= strtotime($news_event->event_date)) {
                    $data['news_events'][$key]->date = date('d', strtotime($news_event->event_date));
                    $data['news_events'][$key]->month = date('M', strtotime($news_event->event_date));
                    $data['news_events'][$key]->year = date('Y', strtotime($news_event->event_date));
                    $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($news_event->event_date));
                } else {
                    unset($data['news_events'][$key]);
                }
            }
        }


        $events = $data['news_events']->values()->toArray();
        usort($events, function ($a, $b) {
            return strtotime($a['new_event_date']) - strtotime($b['new_event_date']);
        });


        $response = [
            'news_events' => $events,
            'first_news_events' => !empty($events) ? $events[0] : null
        ];

        return response()->json(['status' => 200, 'data' => $response]);
    }

    private function getNextDayFromRepeatOn(array $repeat_on_day)
    {
        if (empty($repeat_on_day)) {
            return null;
        }

        $current_day_index = array_search(date('D'), ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']);
        $next_day_index = null;

        foreach ($repeat_on_day as $day) {
            $day_index = array_search($day, ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']);
            if ($day_index > $current_day_index) {
                $next_day_index = $day_index;
                break;
            }
        }

        if (is_null($next_day_index)) {
            $next_day_index = array_search($repeat_on_day[0], ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']);
        }

        return ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][$next_day_index];
    }

    private function getNextBiWeeklyDay($event_date, array $repeat_on_day)
    {
        $event_timestamp = strtotime($event_date);
        $current_timestamp = strtotime(date('Y-m-d'));
        $weeks_passed = floor(($current_timestamp - $event_timestamp) / (14 * 24 * 60 * 60));

        // Calculate next bi-weekly cycle
        $next_cycle_start = date('Y-m-d', $event_timestamp + (($weeks_passed + 1) * 14 * 24 * 60 * 60));

        // Find the next matching day in the bi-weekly cycle
        foreach ($repeat_on_day as $day) {
            $next_day = date('Y-m-d', strtotime('next ' . $day, strtotime($next_cycle_start)));
            if (strtotime($next_day) >= $current_timestamp) {
                return $next_day;
            }
        }

        return $next_cycle_start;
    }

    private function calculateMonthlyRecurrence($news_event)
    {
        $monthly_week = $news_event->monthly_week;
        $repeat_on_day = $news_event->repeat_on ? json_decode($news_event->repeat_on, true) : [];

        if (empty($repeat_on_day)) {
            return date('Y-m-d', strtotime('first day of next month'));
        }

        $current_year = date('Y');
        $current_month = date('m');

        // Calculate which week we're in this month
        $current_week = ceil(date('d') / 7);
        $current_day = date('D');

        // Handle "last" week
        if ($monthly_week == 'last') {
            $last_day_of_month = date('t'); // Total days in current month
            $target_week = ceil($last_day_of_month / 7);
        } else {
            $target_week = (int)$monthly_week;
        }

        // Check if we should show today
        if ($current_week == $target_week && in_array($current_day, $repeat_on_day)) {
            return date('Y-m-d');
        }

        // Find next occurrence
        if ($current_week < $target_week) {
            // Still in current month
            $target_day = $repeat_on_day[0];
            $first_day_of_month = date('Y-m-01');
            $first_occurrence = date('Y-m-d', strtotime("first $target_day of " . date('F Y')));
            $target_date = date('Y-m-d', strtotime('+' . (($target_week - 1) * 7) . ' days', strtotime($first_occurrence)));

            if (strtotime($target_date) >= strtotime(date('Y-m-d'))) {
                return $target_date;
            }
        }

        // Move to next month
        $next_month = date('Y-m-d', strtotime('first day of next month'));
        $next_month_year = date('Y', strtotime($next_month));
        $next_month_num = date('m', strtotime($next_month));

        // Handle "last" week for next month
        if ($monthly_week == 'last') {
            $last_day_of_next_month = date('t', strtotime($next_month));
            $target_week = ceil($last_day_of_next_month / 7);
        }

        $target_day = $repeat_on_day[0];
        $first_occurrence = date('Y-m-d', strtotime("first $target_day of " . date('F Y', strtotime($next_month))));
        return date('Y-m-d', strtotime('+' . (($target_week - 1) * 7) . ' days', strtotime($first_occurrence)));
    }
    private function calculateYearlyRecurrence($news_event)
    {
        $yearly_week = $news_event->yearly_week;
        $repeat_on_day = $news_event->repeat_on ? json_decode($news_event->repeat_on, true) : [];
        $event_month_day = date('m-d', strtotime($news_event->event_date));
        $current_year = date('Y');

        if (empty($repeat_on_day)) {
            $event_date = "$current_year-$event_month_day";
            if (strtotime($event_date) < strtotime(date('Y-m-d'))) {
                $event_date = date('Y-m-d', strtotime("+1 year", strtotime($event_date)));
            }
            return $event_date;
        }

        // Get the month from event_date
        $event_month = date('m', strtotime($news_event->event_date));
        $target_year_month = "$current_year-$event_month";

        // If this month has passed, use next year
        if (strtotime($target_year_month . '-01') < strtotime(date('Y-m-01'))) {
            $target_year_month = date('Y-m', strtotime("+1 year", strtotime($target_year_month . '-01')));
        }

        // Handle "last" week
        if ($yearly_week == 'last') {
            $last_day_of_month = date('t', strtotime($target_year_month . '-01'));
            $target_week = ceil($last_day_of_month / 7);
        } else {
            $target_week = (int)$yearly_week;
        }

        // Find the target day in the target week
        $target_day = $repeat_on_day[0];
        $first_occurrence = date('Y-m-d', strtotime("first $target_day of " . date('F Y', strtotime($target_year_month . '-01'))));
        $target_date = date('Y-m-d', strtotime('+' . (($target_week - 1) * 7) . ' days', strtotime($first_occurrence)));

        // If the target date has passed, move to next year
        if (strtotime($target_date) < strtotime(date('Y-m-d'))) {
            $next_year_month = date('Y-m', strtotime("+1 year", strtotime($target_year_month . '-01')));

            // Recalculate for next year
            if ($yearly_week == 'last') {
                $last_day_of_month = date('t', strtotime($next_year_month . '-01'));
                $target_week = ceil($last_day_of_month / 7);
            }

            $first_occurrence = date('Y-m-d', strtotime("first $target_day of " . date('F Y', strtotime($next_year_month . '-01'))));
            $target_date = date('Y-m-d', strtotime('+' . (($target_week - 1) * 7) . ' days', strtotime($first_occurrence)));
        }

        return $target_date;
    }

    // getSpecificNewsEvent
    public function getSpecificNewsEvent(Request $request)
    {
        $data['news_event'] = NewsEvent::with('attachments')
            ->where('id', $request->id)
            ->first();
        $data['news_event']->attachments->map(function ($attachment) {
            $attachment->path = url('/', $attachment->path);
        });
        // get first attachment if exist
        $data['news_event']->image = $data['news_event']->attachments->first()->path;
        $data['news_event']->new_event_date = $data['news_event']->event_date
            ? date('Y-m-d', strtotime($data['news_event']->event_date))
            : null;
        return response()->json(['status' => 200, 'data' => $data]);
    }
}
