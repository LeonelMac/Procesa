@props(['value', 'mensaje'])

<button class="bg-transparent border-0" wire:click="verExpediente({{ $value }})" data-toggle="tooltip" data-bs-placement="top" title="Ver expediente">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye"
        viewBox="0 0 16 16">
        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM8 13c-2.833 0-5.448-1.972-6.876-4.813C2.552 5.971 5.167 4 8 4s5.448 1.972 6.876 4.813C13.448 11.028 10.833 13 8 13z"/>
        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5z"/>
    </svg>
</button>

