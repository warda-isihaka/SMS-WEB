<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Event') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('events.store') }}" method="POST">
                    @csrf

                    <!-- Event Title -->
                    <div class="mb-4">
                        <label for="title" class="block font-semibold text-sm text-gray-700 mb-1">Event Title *</label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500" 
                               placeholder="e.g., Warda Wedding" 
                               required>
                    </div>

                    <!-- Event Date -->
                    <div class="mb-4">
                        <label for="event_date" class="block font-semibold text-sm text-gray-700 mb-1">Event Date</label>
                        <input type="date" 
                               name="event_date" 
                               id="event_date" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block font-semibold text-sm text-gray-700 mb-1">Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="3" 
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500" 
                                  placeholder="Event notes or summary..."></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:outline-none transition">
                            Save Event
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>