<div>
    <!-- Input field and button to generate image -->
    <input type="text" wire:model="textInput" placeholder="Enter your text">
    <button wire:click="generateImage">Convert to Image</button>

    <!-- Display the generated image -->
    @if($image)
        <img src="{{ $image }}" alt="Converted Image">
        <!-- Button to trigger download -->
        <button onclick="downloadImage('{{ $image }}')">Download Image</button>
    @endif
</div>

<script>
    function downloadImage(imageUrl) {
        // Create a temporary anchor element
        var a = document.createElement("a");
        a.href = imageUrl;
        a.download = "image.png"; // Set the filename for download
        document.body.appendChild(a);
        a.click(); // Trigger the click event to start download
        document.body.removeChild(a); // Clean up
    }
</script>
