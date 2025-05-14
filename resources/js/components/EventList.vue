<template>
    <div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <EventCard 
          v-for="event in events.data" 
          :key="event.id" 
          :event="event" 
        />
      </div>
      <Pagination :links="events.links" class="mt-6" />
    </div>
  </template>