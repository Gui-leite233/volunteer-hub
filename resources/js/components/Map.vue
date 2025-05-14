<template>
    <div ref="mapContainer" class="h-full w-full"></div>
  </template>
  
  <script setup>
  import { ref, onMounted, watch } from 'vue';
  import L from 'leaflet';
  import 'leaflet/dist/leaflet.css';
  
  const props = defineProps({
    latitude: {
      type: Number,
      required: true
    },
    longitude: {
      type: Number,
      required: true
    },
    locationName: {
      type: String,
      required: true
    }
  });
  
  const mapContainer = ref(null);
  let map = null;
  
  onMounted(() => {
    initMap();
  });
  
  function initMap() {
    map = L.map(mapContainer.value).setView([props.latitude, props.longitude], 13);
  
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
  
    L.marker([props.latitude, props.longitude])
      .addTo(map)
      .bindPopup(props.locationName)
      .openPopup();
  }
  
  watch([() => props.latitude, () => props.longitude], () => {
    if (map) {
      map.setView([props.latitude, props.longitude], 13);
      L.marker([props.latitude, props.longitude])
        .addTo(map)
        .bindPopup(props.locationName)
        .openPopup();
    }
  });
  </script>