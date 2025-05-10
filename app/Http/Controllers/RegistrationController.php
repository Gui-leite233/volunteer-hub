<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('register', $event);

        $existingRegistration = $event->registrations()->where('user_id', auth()->id())->first();


        if($existingRegistration){
            return back()->with('error', 'You are already registered for this event.');
        }

        $status = $event->isAtCapacity() ? 'waitlisted' : 'confirmed';

        $registration = Registration::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'status' => $status,
        ]);

        return back()->with('success', $status === 'confirmed' ? 'You have successfully for this event.' : 'You have been added to the waitlist for this event.');
    }

    public function cancel(Registration $registration){
        $this-> authorize('cancel', $registration);

        $registration->delete();

        if($registration->status === 'confirmed'){
            $waitlisted = Registration::where('event_id', $registration->event_id)->where('status', 'waitlisted')->orderBy('created_at')->first();

            if($waitlisted){
                $waitlisted->update(['status'=>'confirmed']);
            }
        }

        return back()->with('success', 'Registration canceled successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
