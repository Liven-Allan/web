<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150', 'style' => 'background-color: #28a745; border-color: #28a745; color: white;']) }} 
    onmouseover="this.style.backgroundColor='#218838'" 
    onmouseout="this.style.backgroundColor='#28a745'"
    onfocus="this.style.backgroundColor='#218838'"
    onblur="this.style.backgroundColor='#28a745'">
    {{ $slot }}
</button>
