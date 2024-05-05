<img class="mb-3 rounded" id="img-preview"
    src="{{ $mode == 'edit' && $item->image ? asset('storage/' . $item->image) : asset('images/placeholder-image.png') }}"
    style="display: {{ $mode == 'edit' && $item->image ? 'block' : 'none' }}; height: 300px; object-fit: cover; width: 100%">
<div class="mb-3">
    <label for="img-input" class="form-label">Image</label>
    <input class="form-control @error('image') is-invalid @enderror" type="file" id="img-input" name="image"
        accept="image/*">
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<script>
    const imageInput = document.querySelector("#img-input");
    const imagePreview = document.querySelector("#img-preview");

    imageInput.addEventListener("change", (e) => {
        const imageSelected = e.target.files[0];
        const fileReader = new FileReader();
        fileReader.readAsDataURL(imageSelected);
        fileReader.onload = (e) => {
            imagePreview.style.display = "block";
            imagePreview.src = e.target.result;
        };
    });
</script>
