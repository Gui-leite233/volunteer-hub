<template>
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
      <div class="p-6">
        <div class="flex justify-between items-start">
          <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ event.title }}</h3>
          <span 
            class="px-2 py-1 text-xs font-semibold rounded-full" 
            :class="categoryClass"
          >
            {{ event.category }}
          </span>
        </div>
        
        <div class="flex items-center text-gray-500 mb-3">
          <CalendarIcon class="h-4 w-4 mr-1" />
          <span>{{ formatDate(event.event_date) }}</span>
        </div>
        
        <div class="flex items-center text-gray-500 mb-4">
          <MapPinIcon class="h-4 w-4 mr-1" />
          <span>{{ event.location_name }}</span>
        </div>
        
        <p class="text-gray-600 mb-4 line-clamp-3">{{ event.description }}</p>
        
        <div class="flex justify-between items-center">
          <div class="text-sm text-gray-500">
            <span>{{ event.registrations_count || 0 }}/{{ event.capacity }} spots filled</span>
          </div>
          <Link 
            :href="route('events.show', event.id)" 
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-300"
          >
            View Details
          </Link>
        </div>
      </div>
    </div>
  </template>