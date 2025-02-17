<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsEvent;

class NewsEventController extends Controller
{

    // getNewsEvents
    public function getNewsEvents(Request $request)
    {
        $data['news_events'] = NewsEvent::with('attachments')
            ->orderBy('id', 'desc')
            ->where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))
            ->where('status', 1)
            ->get();
    
        foreach ($data['news_events'] as $key => $news_event) {
            // remove html tags from description show only 100 characters
            $data['news_events'][$key]->description = strip_tags($news_event->description);
            $data['news_events'][$key]->description = substr($data['news_events'][$key]->description, 0, 100);
            $data['news_events'][$key]->date = date('d', strtotime($news_event->event_date));
            $data['news_events'][$key]->month = date('M', strtotime($news_event->event_date));
            // add year
            $data['news_events'][$key]->year = date('Y', strtotime($news_event->event_date));
            // create new_event_date field via concatenate the date, month and year
            $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($news_event->event_date));
            $data['news_events'][$key]->attachments->map(function ($attachment) {
                $attachment->path = url('/', $attachment->path);
            });
    
            if ($news_event->type == "Recurring") {
                if ($news_event->recurring_type == "Daily") {
                    $data['news_events'][$key]->date = date('d');
                    $data['news_events'][$key]->month = date('M');
                    // add year
                    $data['news_events'][$key]->year = date('Y');
                    // create new_event_date field via concatenate the date, month and year
                    $data['news_events'][$key]->new_event_date = date('Y-m-d');
                    // when the event date is greater then add current day and month
                    if (strtotime(date('Y-m-d')) < strtotime($news_event->event_date)) {
                        $data['news_events'][$key]->date = date('d', strtotime($news_event->event_date));
                        $data['news_events'][$key]->month = date('M', strtotime($news_event->event_date));
                        // add year
                        $data['news_events'][$key]->year = date('Y', strtotime($news_event->event_date));
                        // create new_event_date field via concatenate the date, month and year
                        $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($news_event->event_date));
                    }
                } elseif ($news_event->recurring_type == "Weekly") {
                    $repeat_on_day = $news_event->repeat_on ? json_decode($news_event->repeat_on, true) : [];
                    // first check even_date is greater then current date then add current date and month
                    if (strtotime(date('Y-m-d')) < strtotime($news_event->event_date)) {
                        $data['news_events'][$key]->date = date('d', strtotime($news_event->event_date));
                        $data['news_events'][$key]->month = date('M', strtotime($news_event->event_date));
                        // add year
                        $data['news_events'][$key]->year = date('Y', strtotime($news_event->event_date));
                        // create new_event_date field via concatenate the date, month and year
                        $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($news_event->event_date));
                    }else{
                        if (!in_array(date('D'), $repeat_on_day)) {
                            $next_day = $this->getNextDayFromRepeatOn($repeat_on_day);
                            $data['news_events'][$key]->date = date('d', strtotime('next ' . $next_day));
                            $data['news_events'][$key]->month = date('M', strtotime('next ' . $next_day));
                            // add year
                            $data['news_events'][$key]->year = date('Y', strtotime('next ' . $next_day));
                            // create new_event_date field via concatenate the date, month and year
                            $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime('next ' . $next_day));
                        } else {
                            $data['news_events'][$key]->date = date('d');
                            $data['news_events'][$key]->month = date('M');
                            // add year
                            $data['news_events'][$key]->year = date('Y');
                            // create new_event_date field via concatenate the date, month and year
                            $data['news_events'][$key]->new_event_date = date('Y-m-d');
                        }
                    }
                    
                    // // when the event date is greater than the end date then remove the event
                    // if (strtotime(date('Y-m-d', strtotime('next ' . $next_day))) > strtotime($news_event->end_date)) {
                    //     unset($data['news_events'][$key]);
                    // }
                } 
                elseif ($news_event->recurring_type == "Monthly") {
                    $event_day = date('d', strtotime($news_event->event_date));
                    $current_month_days = date('t'); // Total days in the current month
                
                    if ($event_day <= $current_month_days && $event_day >= date('d')) {
                        // Event occurs later this month
                        $next_date = date('Y-m') . '-' . str_pad($event_day, 2, '0', STR_PAD_LEFT);
                    } else {
                        // Event occurs in the next month
                        $next_month = date('Y-m-d', strtotime('first day of next month'));
                        $next_month_days = date('t', strtotime($next_month)); // Total days in the next month
                
                        if ($event_day > $next_month_days) {
                            // Adjust to the last day of the next month if `event_day` exceeds it
                            $next_date = date('Y-m-t', strtotime($next_month));
                        } else {
                            $next_date = date('Y-m', strtotime($next_month)) . '-' . str_pad($event_day, 2, '0', STR_PAD_LEFT);
                        }
                    }
                
                    $data['news_events'][$key]->date = date('d', strtotime($next_date));
                    $data['news_events'][$key]->month = date('M', strtotime($next_date));
                    // add year
                    $data['news_events'][$key]->year = date('Y', strtotime($next_date));
                    // create new_event_date field via concatenate the date, month and year
                    $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($next_date));
                    // when the event date is greater than the end date then remove the event
                    if (strtotime($next_date) > strtotime($news_event->end_date)) {
                        unset($data['news_events'][$key]);
                    }
                }
                
                elseif ($news_event->recurring_type == "Yearly") {
                    $event_month_day = date('m-d', strtotime($news_event->event_date));
                    $current_year = date('Y');
                    $event_date = "$current_year-$event_month_day";
    
                    if (strtotime($event_date) < strtotime(date('Y-m-d'))) {
                        // Get next year's occurrence
                        $event_date = date('Y-m-d', strtotime("+1 year", strtotime($event_date)));
                    }
                    $data['news_events'][$key]->date = date('d', strtotime($event_date));
                    $data['news_events'][$key]->month = date('M', strtotime($event_date));
                    // add year
                    $data['news_events'][$key]->year = date('Y', strtotime($event_date));
                    // create new_event_date field via concatenate the date, month and year
                    $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($event_date));
                    // when the event date is greater than the end date then remove the event
                    if (strtotime($event_date) > strtotime($news_event->end_date)) {
                        unset($data['news_events'][$key]);
                    }
                }
            } elseif ($news_event->type == 'Non-Recurring') {
                // show event when event date is equal to current date and smaller than event date
                if (strtotime(date('Y-m-d')) <= strtotime($news_event->event_date)) {
                    $data['news_events'][$key]->date = date('d', strtotime($news_event->event_date));
                    $data['news_events'][$key]->month = date('M', strtotime($news_event->event_date));
                    // add year
                    $data['news_events'][$key]->year = date('Y', strtotime($news_event->event_date));
                    // create new_event_date field via concatenate the date, month and year
                    $data['news_events'][$key]->new_event_date = date('Y-m-d', strtotime($news_event->event_date));
                }else{
                    unset($data['news_events'][$key]);
                }
                // if ($news_event->event_date != date('Y-m-d')) {
                //     unset($data['news_events'][$key]);
                // }
            }
        }
        $events = $data['news_events']->toArray();
        // Sort events by 'new_event_date' in ascending order
        usort($events, function ($a, $b) {
            return strtotime($a['new_event_date']) - strtotime($b['new_event_date']);
        });
        $events['news_events'] = $events;

        $collection = collect($events);
        $events['first_news_events'] = $collection->first();
        // $first_index = $collection->keys()->first();
        // unset($events['news_events'][$first_index]);
        return response()->json(['status' => 200, 'data' => $events]);
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
        return response()->json(['status' => 200, 'data' => $data]);
    }
    
}
