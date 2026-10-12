<div>
    <x-input-label for="judul" value="Judul Rencana Proyek" />
    <x-text-input id="judul" name="judul" type="text" class="mt-1 block w-full" maxlength="150"
                  :value="old('judul', $project->judul ?? '')" required autofocus />
    <x-input-error :messages="$errors->get('judul')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="deskripsi" value="Deskripsi (opsional)" />
    <textarea id="deskripsi" name="deskripsi" rows="5"
              class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi', $project->deskripsi ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="tema_agent" value="Tema / Framework Agent" />
    <x-text-input id="tema_agent" name="tema_agent" type="text" class="mt-1 block w-full" maxlength="50"
                  placeholder="Ollama" :value="old('tema_agent', $project->tema_agent ?? '')" />
    <x-input-error :messages="$errors->get('tema_agent')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="api_key_secure" value="API Key (disimpan terenkripsi)" />
    <x-text-input id="api_key_secure" name="api_key_secure" type="password" class="mt-1 block w-full"
                  autocomplete="off"
                  :placeholder="isset($project) ? 'Kosongkan jika tidak ingin mengganti' : ''" />
    <x-input-error :messages="$errors->get('api_key_secure')" class="mt-2" />
</div>
