<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->isOrganization()){
            return $this->organizationDashboard();
        }

        return $this->volunteerDashboard();
    }

    private function organizationDashboard(){
        $events = Event::where('user_id', auth()-id())-withCount(['registrations'=>function($query){
            $query->where('status', 'confirmed');
        }])->latest()->paginate(5);


        return Inertia::render('Dashboard/Organization', [
            'events'=>$events,
        ]);
    }


    private function volunteerDashboard()
    {
        $registrations = Registration::where('user_id', auth()->id())
            ->with('event')
            ->latest()
            ->paginate(5);

        $upcomingEvents = Event::whereHas('registrations', function ($query) {
                $query->where('user_id', auth()->id())
                    ->where('status', 'confirmed');
            })
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->get();

        return Inertia::render('Dashboard/Volunteer', [
            'registrations' => $registrations,
            'upcomingEvents' => $upcomingEvents,
        ]);
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
        //
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
