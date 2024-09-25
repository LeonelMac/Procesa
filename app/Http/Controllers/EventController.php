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

        // Devolver los eventos con el campo 'description', 'repetition_id', y 'repetition_type'
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
        // Convertir all_day a booleano
        $request->merge([
            'all_day' => filter_var($request->input('all_day'), FILTER_VALIDATE_BOOLEAN)
        ]);
    
        // Validar los datos
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date', // Asegúrate de que este campo solo sea una fecha (Y-m-d)
            'description' => 'nullable|string',
            'all_day' => 'required|boolean',
            'repetition_type' => 'nullable|string',  // Validar el tipo de repetición
            'start_time' => 'required_if:all_day,false|nullable|date_format:H:i',
            'end_time' => 'required_if:all_day,false|nullable|date_format:H:i|after:start_time',
        ]);
    
        // Ver qué datos está recibiendo el backend para depurar errores de formato
        // Puedes usar esta línea para revisar qué datos está recibiendo el backend
        Log::info('Datos validados: ', $validatedData);  // Depuración de datos
    
        $repetitionType = $validatedData['repetition_type'] ?? null;  // Usar null si no se envía el campo
    
        // Combinar la fecha con la hora si no es un evento de todo el día
        if (!$validatedData['all_day']) {
            // Revisar el formato antes de combinar
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i', trim($validatedData['start']) . ' ' . trim($validatedData['start_time']));
            $endDateTime = Carbon::createFromFormat('Y-m-d H:i', trim($validatedData['start']) . ' ' . trim($validatedData['end_time']));
        } else {
            $startDateTime = Carbon::parse($validatedData['start']);
            $endDateTime = $startDateTime->copy()->endOfDay(); // 23:59 PM para eventos de todo el día
        }
    
        // Crear el evento principal (el evento principal tiene repetition_id = NULL)
        $event = Event::create([
            'title' => $validatedData['title'],
            'start' => $startDateTime,
            'end' => $endDateTime,
            'description' => $validatedData['description'],
            'all_day' => $validatedData['all_day'],
            'repetition_type' => $validatedData['repetition_type'],  // Tipo de repetición
            'repetition_id' => null, // El evento principal no tiene repetition_id
        ]);
    
        Log::info('Evento principal creado con ID: ' . $event->id); // Log para depuración
    
        // Repetición mensual
        if ($validatedData['repetition_type'] === 'monthly') {
            $this->createMonthlyEvents($event, $validatedData);
        }
    
        // Repetición de lunes a viernes
        if ($validatedData['repetition_type'] === 'weekdays') {
            $this->createWeekdayEvents($event, $validatedData);
        }
    
        return response()->json(['success' => true, 'event' => $event]);
    }
    

    private function createMonthlyEvents($event, $validatedData)
    {
        $startDate = Carbon::parse($validatedData['start']);

        // Crear eventos cada mes por los próximos 12 meses
        for ($i = 1; $i <= 12; $i++) {
            $newStartDateTime = $startDate->copy()->addMonthsNoOverflow($i);

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
                'repetition_id' => $event->id,  // Los eventos repetidos tienen repetition_id del evento principal
                'repetition_type' => 'monthly', // Especificar el tipo de repetición
            ]);

            Log::info('Evento mensual repetido creado con repetition_id: ' . $event->id);
        }
    }

    private function createWeekdayEvents($event, $validatedData)
    {
        $startDate = Carbon::parse($validatedData['start']);
        $endDate = $startDate->copy()->endOfWeek(Carbon::FRIDAY); // Termina el viernes de esa misma semana

        // Crear eventos solo para los días laborables (lunes a viernes)
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
                    'repetition_id' => $event->id,  // Los eventos repetidos tienen repetition_id del evento principal
                    'repetition_type' => 'weekdays', // Especificar el tipo de repetición
                ]);

                Log::info('Evento semanal repetido creado con repetition_id: ' . $event->id);
            }
        }
    }

    public function update(Request $request, $id)
    {
        // Buscar el evento por ID
        $event = Event::findOrFail($id);
    
        // Convertir all_day a booleano
        $request->merge([
            'all_day' => filter_var($request->input('all_day'), FILTER_VALIDATE_BOOLEAN)
        ]);
    
        // Validar los datos de la solicitud
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',  // Asegúrate de que solo sea la fecha (Y-m-d)
            'description' => 'nullable|string',
            'all_day' => 'required|boolean',
            'repetition_type' => 'nullable|string',  // Validar el tipo de repetición
            'start_time' => 'required_if:all_day,false|nullable|date_format:H:i',
            'end_time' => 'required_if:all_day,false|nullable|date_format:H:i|after:start_time',
        ]);
    
        $repetitionType = $validatedData['repetition_type'] ?? null;  // Usar null si no se envía el campo
    
        // Combinar la fecha con la hora si no es un evento de todo el día
        if (!$validatedData['all_day']) {
            // Crear la fecha y la hora en el formato correcto
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $validatedData['start'] . ' ' . $validatedData['start_time']);
            $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $validatedData['start'] . ' ' . $validatedData['end_time']);
        } else {
            $startDateTime = Carbon::parse($validatedData['start']);
            $endDateTime = $startDateTime->copy()->endOfDay(); // 23:59 PM para eventos de todo el día
        }
    
        // Actualizar el evento base
        $event->update([
            'title' => $validatedData['title'],
            'start' => $startDateTime,
            'end' => $endDateTime,
            'description' => $validatedData['description'],
            'all_day' => $validatedData['all_day'],
            'repetition_type' => $validatedData['repetition_type'],  // Actualizar el tipo de repetición
        ]);
    
        // Eliminar los eventos repetidos previamente creados si los hay
        Event::where('repetition_id', $event->id)->delete();
    
        // Repetición mensual
        if ($validatedData['repetition_type'] === 'monthly') {
            $this->createMonthlyEvents($event, $validatedData);
        }
    
        // Repetición de lunes a viernes
        if ($validatedData['repetition_type'] === 'weekdays') {
            $this->createWeekdayEvents($event, $validatedData);
        }
    
        return response()->json(['success' => true, 'event' => $event]);
    }
    

    public function destroy(Request $request, $id)
    {
        // Buscar el evento por ID
        $event = Event::findOrFail($id);

        // Verificar si el usuario quiere eliminar solo el evento o todos los eventos relacionados
        $eliminarTodos = $request->input('eliminar_todos', false);

        if ($eliminarTodos) {
            // Eliminar todos los eventos relacionados
            Event::where('repetition_id', $event->id)->orWhere('id', $event->id)->delete();
        } else {
            // Eliminar solo el evento seleccionado
            $event->delete();
        }

        return response()->json(['success' => true]);
    }

    public function checkRepetition($id)
    {
        // Buscar el evento por ID
        $event = Event::findOrFail($id);

        // Verificar si este evento es parte de una repetición o tiene eventos relacionados
        $hasRepetition = Event::where('repetition_id', $event->id)->exists() || !is_null($event->repetition_id);

        return response()->json(['hasRepetition' => $hasRepetition]);
    }
}
