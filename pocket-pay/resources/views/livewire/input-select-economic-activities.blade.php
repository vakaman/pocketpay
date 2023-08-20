<div>
    <div class="mt-4">
        <x-input-label for="economicActivitie" :value="__('Economic Activitie')" />

        <select name="economicActivities" id="economicActivities" required autofocus
            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option selected="selected">Select an economic activity</option>
            @foreach ($economicActivities as $economicActivitie)
                <option value="{{ $economicActivitie->id }}" @selected(old('economicActivitie') == $economicActivitie->id)>
                    {{ $economicActivitie->code }} | {{ $economicActivitie->name }}
                </option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('economicActivitie')" class="mt-2" />
    </div>

</div>
