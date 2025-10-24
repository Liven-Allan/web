<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150', 'style' => 'background-color: #C41230; border-color: #C41230;']) }}
    onmouseover="this.style.backgroundColor='#a10e28'" 
    onmouseout="this.style.backgroundColor='#C41230'"
    onfocus="this.style.backgroundColor='#a10e28'"
    onblur="this.style.backgroundColor='#C41230'">
    {{ $slot }}
</button>
