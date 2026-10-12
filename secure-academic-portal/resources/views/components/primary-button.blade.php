<button {{ $attributes->merge(['type' => 'submit', 'class' => 'lab-button focus:ring-2 focus:ring-cyan-600 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
