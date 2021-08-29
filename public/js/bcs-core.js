$(document).on('change', '.file-input', function(e) {
    const  inputs = e.target;
    if (inputs.files) {
        var filesAmount = inputs.files.length;
        $this = $(this);
        $this.parents('.input-group').next('.file-preview').html('');
        for (let i= 0; i < filesAmount; i++) {
            var reader = new FileReader();
            reader.onload = function(readData) {
                let imagePvr = `<div class="d-flex justify-content-between align-items-center mx-1 file-preview-item"
                                    title="${inputs.files[i].name}">
                                    <div class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                        <img src="${readData.target.result}"
                                            class="img-fit">
                                    </div>
                                    <div class="col body">
                                        <h6 class="d-flex">
                                            <span class="text-truncate title">${inputs.files[i].name}</span>
                                            <span class="ext">${inputs.files[i].type.split('/')[1]}</span>
                                        </h6>
                                        <p>${(inputs.files[i].size/1024).toFixed(2)} Kb</p>
                                    </div>
                                </div>`;
                $this.parents('.input-group').next('.file-preview').append(imagePvr);
            }
            reader.readAsDataURL(inputs.files[i]);
        }
    }
});
