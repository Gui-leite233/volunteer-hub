<template>
    <AppLayout title="Event Details">
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6">
            <div class="flex justify-between">
              <h1 class="text-2xl font-semibold text-gray-900">{{ event.title }}</h1>
              <EventStatusBadge :status="event.status" />
            </div>
            
            <div class="mt-4 flex flex-wrap gap-4">
              <div class="flex items-center text-gray-600">
                <CalendarIcon class="h-5 w-5 mr-2" />
                <span>{{ formatDate(event.event_date) }}</span>
              </div>
              
              <div class="flex items-center text-gray-600">
                <MapPinIcon class="h-5 w-5 mr-2" />
                <span>{{ event.location_name }}</span>
              </div>
              
              <div class="flex items-center text-gray-600">
                <UserGroupIcon class="h-5 w-5 mr-2" />
                <span>{{ registrationsCount }}/{{ event.capacity }} spots filled</span>
              </div>
            </div>
            
            <div class="mt-6">
              <h2 class="text-lg font-medium text-gray-900">Description</h2>
              <p class="mt-2 text-gray-600">{{ event.description }}</p>
            </div>
            
            <div class="mt-6">
              <h2 class="text-lg font-medium text-gray-900">Location</h2>
              <div class="mt-2 h-64 rounded-lg overflow-hidden">
                <EventMap 
                  :latitude="event.latitude" 
                  :longitude="event.longitude" 
                  :location-name="event.location_name" 
                />
              </div>
            </div>
            
            <div class="mt-8 flex justify-end">
              <template v-if="$page.props.auth.user">
                <template v-if="isRegistered">
                  <button 
                    @click="confirmCancelRegistration" 
                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors duration-300"
                  >
                    Cancel Registration
                  </button>
                </template>
                <template v-else>
                  <button 
                    @click="register" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-300"
                    :disabled="isAtCapacity"
                  >
                    {{ isAtCapacity ? 'Join Waitlist' : 'Register Now' }}
                  </button>
                </template>
              </template>
              <template v-else>
                <Link 
                  :href="route('login')" 
                  class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-300"
                >
                  Login to Register
                </Link>
              </template>
            </div>
          </div>
        </div>
      </div>
    </AppLayout>
  </template>