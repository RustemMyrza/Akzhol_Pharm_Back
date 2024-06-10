<script>
    let loadFile = function (event) {
        let reader = new FileReader();
        reader.onload = function () {
            let output = document.getElementById('image-preview');
            output.style.display = 'block'
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };

    let loadFile2 = function (event, name) {
        let reader = new FileReader();
        reader.onload = function () {
            let output = document.getElementById('image-preview-' + name);
            output.style.display = 'block'
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };

    let loadFile3 = function (event) {
        let input = event.target;
        let reader = new FileReader();
        reader.onload = function () {
            let output = input.closest('.form-group').querySelector('img.product-edit-image');
            if (output) {
                output.style.display = 'block';
                output.src = reader.result;
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
