<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150', 'style' => 'border-color: #6c757d; color: #6c757d;']) }}
    onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='white';" 
    onmouseout="this.style.backgroundColor='white'; this.style.color='#6c757d';">
    {{ $slot }}
</button>
