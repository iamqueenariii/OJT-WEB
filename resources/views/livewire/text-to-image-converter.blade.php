{{-- resources/views/livewire/generate-certificate.blade.php --}}

<div>
    <button wire:click="generateCertificate({{ $certificate_id }})">Generate Certificate</button>

    @if($certificate)
        {{-- Display the generated certificate image --}}
        <img src="{{ asset($certificate->image_path) }}" alt="Generated Certificate">
    @endif
</div>
