<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EventController extends Controller
{

    public function index(Request $request)
    {
        $events = Event::all();

        // Devolver los eventos con el campo 'description'
        $eventsData = $events->map(function ($event) {
            return [
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'allDay' => $event->all_day,
                'description' => $event->description,  // Asegúrate de incluir 'description'
            ];
        });

        return response()->json($eventsData);
    }

    public function store(Request $request)
    {
        // Convertir all_day a booleano
        $request->merge([
            'all_day' => filter_var($request->input('all_day'), FILTER_VALIDATE_BOOLEAN)
        ]);
    
        // Validar los datos
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'description' => 'nullable|string',
            'all_day' => 'required|boolean',
            'repetition' => 'required|string',
            'start_time' => 'required_if:all_day,false|nullable|date_format:H:i',
            'end_time' => 'required_if:all_day,false|nullable|date_format:H:i|after:start_time',
        ]);
    
        // Combinar la fecha con la hora si no es un evento de todo el día
        if (!$validatedData['all_day']) {
            $startDateTime = Carbon::parse($validatedData['start'] . ' ' . $validatedData['start_time']);
            $endDateTime = Carbon::parse($validatedData['start'] . ' ' . $validatedData['end_time']);
        } else {
            $startDateTime = Carbon::parse($validatedData['start']);
            $endDateTime = $startDateTime->copy()->endOfDay(); // 23:59 PM para eventos de todo el día
        }
    
        // Crear el evento inicial
        $event = Event::create([
            'title' => $validatedData['title'],
            'start' => $startDateTime,
            'end' => $endDateTime,
            'description' => $validatedData['description'],
            'all_day' => $validatedData['all_day'],
        ]);
    
        // Repetición mensual (sin cambios)
        if ($validatedData['repetition'] == 'monthly') {
            $startDate = Carbon::parse($validatedData['start']);
    
            // Crear eventos cada mes por los próximos 12 meses
            for ($i = 1; $i <= 12; $i++) {
                $newStartDateTime = $startDate->copy()->addMonthsNoOverflow($i);
    
                // Asignar horas solo si no es un evento de todo el día
                if (!$validatedData['all_day']) {
                    $newStartDateTime->setTimeFromTimeString($validatedData['start_time']);
                    $newEndDateTime = $newStartDateTime->copy()->setTimeFromTimeString($validatedData['end_time']);
                } else {
                    $newEndDateTime = $newStartDateTime->copy()->endOfDay();
                }
    
                // Crear el evento mensual
                Event::create([
                    'title' => $validatedData['title'],
                    'start' => $newStartDateTime,
                    'end' => $newEndDateTime,
                    'description' => $validatedData['description'],
                    'all_day' => $validatedData['all_day'],
                ]);
            }
        }
    
        // Repetición de lunes a viernes
        if ($validatedData['repetition'] == 'weekdays') {
            $startDate = Carbon::parse($validatedData['start']);
            $endDate = $startDate->copy()->endOfWeek(Carbon::FRIDAY); // Termina el viernes de esa misma semana
    
            // Crear eventos solo para los días laborables (lunes a viernes)
            for ($date = $startDate->copy()->addDay(); $date->lte($endDate); $date->addDay()) {
                if ($date->isWeekday()) {
                    $newStartDateTime = $date->copy();
                    $newEndDateTime = $date->copy();
    
                    // Solo asignar horas si no es un evento de todo el día
                    if (!$validatedData['all_day']) {
                        $newStartDateTime->setTimeFromTimeString($validatedData['start_time']);
                        $newEndDateTime->setTimeFromTimeString($validatedData['end_time']);
                    } else {
                        $newEndDateTime = $newStartDateTime->copy()->endOfDay(); // 23:59 PM para eventos de todo el día
                    }
    
                    Event::create([
                        'title' => $validatedData['title'],
                        'start' => $newStartDateTime,
                        'end' => $newEndDateTime,
                        'description' => $validatedData['description'],
                        'all_day' => $validatedData['all_day'],
                    ]);
                }
            }
        }
    
        return response()->json(['success' => true, 'event' => $event]);
    }

    public function update(Request $request, $id)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'description' => 'nullable|string',
            'all_day' => 'required|boolean',
            'repetition' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
        ]);
    
        // Buscar el evento por ID y actualizarlo
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['success' => false, 'message' => 'Evento no encontrado'], 404);
        }
    
        // Actualizar el evento
        $event->update([
            'title' => $validatedData['title'],
            'start' => $validatedData['start'] . ' ' . ($validatedData['start_time'] ?? '00:00:00'),
            'end' => $validatedData['end_time'] ? $validatedData['start'] . ' ' . $validatedData['end_time'] : null,
            'description' => $validatedData['description'],
            'all_day' => $validatedData['all_day'],
        ]);
    
        return response()->json(['success' => true, 'event' => $event]);
    }
    
    public function destroy($id)
    {
        // Buscar el evento y eliminarlo
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['success' => false, 'message' => 'Evento no encontrado'], 404);
        }
    
        $event->delete();
        return response()->json(['success' => true]);
    }
    
}
