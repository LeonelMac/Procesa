<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::all();
        $eventsData = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'allDay' => $event->all_day,
                'description' => $event->description,
                'repetition_id' => $event->repetition_id,
                'repetition_type' => $event->repetition_type,
            ];
        });
        return response()->json($eventsData);
    }

    public function store(Request $request)
    {
        $request->merge([
            'all_day' => filter_var($request->input('all_day'), FILTER_VALIDATE_BOOLEAN)
        ]);
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'description' => 'nullable|string',
            'all_day' => 'required|boolean',
            'repetition_type' => 'nullable|string',
            'start_time' => 'required_if:all_day,false|nullable|date_format:H:i',
            'end_time' => 'required_if:all_day,false|nullable|date_format:H:i|after:start_time',
        ]);
        $repetitionType = $validatedData['repetition_type'] ?? null;
        if (!$validatedData['all_day']) {
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i', trim($validatedData['start']) . ' ' . trim($validatedData['start_time']));
            $endDateTime = Carbon::createFromFormat('Y-m-d H:i', trim($validatedData['start']) . ' ' . trim($validatedData['end_time']));
        } else {
            $startDateTime = Carbon::parse($validatedData['start']);
            $endDateTime = $startDateTime->copy()->endOfDay();
        }
        $event = Event::create([
            'title' => $validatedData['title'],
            'start' => $startDateTime,
            'end' => $endDateTime,
            'description' => $validatedData['description'],
            'all_day' => $validatedData['all_day'],
            'repetition_type' => $validatedData['repetition_type'],
            'repetition_id' => null,
        ]);
        if ($validatedData['repetition_type'] === 'monthly') {
            $this->createMonthlyEvents($event, $validatedData);
        }
        if ($validatedData['repetition_type'] === 'weekdays') {
            $this->createWeekdayEvents($event, $validatedData);
        }
        return response()->json(['success' => true, 'event' => $event]);
    }

    private function createMonthlyEvents($event, $validatedData)
    {
        $startDate = Carbon::parse($validatedData['start']);
        for ($i = 1; $i <= 12; $i++) {
            $newStartDateTime = $startDate->copy()->addMonthsNoOverflow($i);
            if (!$validatedData['all_day']) {
                $newStartDateTime->setTimeFromTimeString($validatedData['start_time']);
                $newEndDateTime = $newStartDateTime->copy()->setTimeFromTimeString($validatedData['end_time']);
            } else {
                $newEndDateTime = $newStartDateTime->copy()->endOfDay();
            }
            Event::create([
                'title' => $validatedData['title'],
                'start' => $newStartDateTime,
                'end' => $newEndDateTime,
                'description' => $validatedData['description'],
                'all_day' => $validatedData['all_day'],
                'repetition_id' => $event->id,
                'repetition_type' => 'monthly',
            ]);
        }
    }

    private function createWeekdayEvents($event, $validatedData)
    {
        $startDate = Carbon::parse($validatedData['start']);
        $endDate = $startDate->copy()->endOfWeek(Carbon::FRIDAY);
        for ($date = $startDate->copy()->addDay(); $date->lte($endDate); $date->addDay()) {
            if ($date->isWeekday()) {
                $newStartDateTime = $date->copy();
                if (!$validatedData['all_day']) {
                    $newStartDateTime->setTimeFromTimeString($validatedData['start_time']);
                    $newEndDateTime = $newStartDateTime->copy()->setTimeFromTimeString($validatedData['end_time']);
                } else {
                    $newEndDateTime = $newStartDateTime->copy()->endOfDay();
                }
                Event::create([
                    'title' => $validatedData['title'],
                    'start' => $newStartDateTime,
                    'end' => $newEndDateTime,
                    'description' => $validatedData['description'],
                    'all_day' => $validatedData['all_day'],
                    'repetition_id' => $event->id,
                    'repetition_type' => 'weekdays',
                ]);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $request->merge([
            'all_day' => filter_var($request->input('all_day'), FILTER_VALIDATE_BOOLEAN)
        ]);
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'description' => 'nullable|string',
            'all_day' => 'required|boolean',
            'repetition_type' => 'nullable|string',
            'start_time' => 'required_if:all_day,false|nullable|date_format:H:i',
            'end_time' => 'required_if:all_day,false|nullable|date_format:H:i|after:start_time',
        ]);
        $repetitionType = $validatedData['repetition_type'] ?? null;
        if (!$validatedData['all_day']) {
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $validatedData['start'] . ' ' . $validatedData['start_time']);
            $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $validatedData['start'] . ' ' . $validatedData['end_time']);
        } else {
            $startDateTime = Carbon::parse($validatedData['start']);
            $endDateTime = $startDateTime->copy()->endOfDay();
        }
        $event->update([
            'title' => $validatedData['title'],
            'start' => $startDateTime,
            'end' => $endDateTime,
            'description' => $validatedData['description'],
            'all_day' => $validatedData['all_day'],
            'repetition_type' => $validatedData['repetition_type'],
        ]);
        Event::where('repetition_id', $event->id)->delete();
        if ($validatedData['repetition_type'] === 'monthly') {
            $this->createMonthlyEvents($event, $validatedData);
        }
        if ($validatedData['repetition_type'] === 'weekdays') {
            $this->createWeekdayEvents($event, $validatedData);
        }
        return response()->json(['success' => true, 'event' => $event]);
    }

    public function destroy(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $eliminarTodos = $request->input('eliminar_todos', false);
        if ($eliminarTodos) {
            Event::where('repetition_id', $event->id)->orWhere('id', $event->id)->delete();
        } else {
            $event->delete();
        }
        return response()->json(['success' => true]);
    }

    public function checkRepetition($id)
    {
        $event = Event::findOrFail($id);
        $hasRepetition = Event::where('repetition_id', $event->id)->exists() || !is_null($event->repetition_id);
        return response()->json(['hasRepetition' => $hasRepetition]);
    }

    public function getTodayEventsCount()
    {
        $today = Carbon::now()->toDateString();
        $eventsCount = Event::whereDate('start', '=', $today)->count();
        return response()->json(['count' => $eventsCount]);
    }

    public function countUpcomingEvents()
    {
        try {
            $today = Carbon::today();
            $upcomingEvents = Event::where('start', '>=', $today)->count(); 
            return response()->json(['count' => $upcomingEvents], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el conteo de eventos'], 500);
        }
    }
}
