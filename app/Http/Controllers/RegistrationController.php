<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrations = Auth::user()->registrations()->with(['event', 'status'])->paginate(10);

        return Inertia::render('Registration/Index', [
            'registrations' => $registrations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Registration/Create', [
            'event' => $event
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $existingRegsitration = Registratio::where('user_id', Auth::id()) ->where('event_id', $event->id) - first();

        if($existingRegsitration){
            return back()->with('erro', 'Você já se registrou para este evento');
        }

        $confirmedCount  = Registration::where('event_id', $event->id) ->where('status_id', 1) ->count();

        $statusId = $confirmedCount < $event->capacity ? 1:2;

        $validated = $request->validate([
            'review' => 'nullable|string'
        ]);

        return redirect()->route('events.show', $event)->with('sucesso', $statusId == 1 ? 'Você se registrou neste evento com sucesso' : 'Você foi adicionado(a) a fila de espera');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        this->authorize('view', $registration);
        
        $registration->load(['event', 'status']);
        
        return Inertia::render('Registrations/Show', [
            'registration' => $registration
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update', $registration);
        
        $validated = $request->validate([
            'review' => 'nullable|string',
        ]);

        $registration->update([
            'review' => $validated['review'] ?? $registration->review,
        ]);

        return back()->with('sucesso', 'Registro atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', $registration);

        $eventId = $registration->event_id;
        $registration->delete();

        if($registration->status_id == 1){
            $waitlist = Registration::where('event_id', $eventId)->where('status_id', 2)->orderBy('created_at')->first();

            if($waitlist){
                $waitlist->update(['status_id' => 1]);
            }
        }

        return redirect()->route('registration.index')->with('sucesso', 'Registro deletado com sucesso');
    }
}
