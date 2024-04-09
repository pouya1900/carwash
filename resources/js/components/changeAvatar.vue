<template>
    <input type="file" name="avatar" hidden id="change_avatar" accept="image/*" @change="handleFileUpload">
    <input type="hidden" name="deleted_avatar" :value="delete_value">
    <img id="avatar-preview"  :src="avatar" title="" alt="">
    <label for="change_avatar" class="change_avatar_vue">
        <i class="fa-solid fa-camera"></i> اپلود تصویر
    </label>
</template>

<script>
export default {
    props: ['avatar', 'att_name'],
    name: 'video',
    methods: {
        previewImage() {
            let image = document.getElementById('avatar-preview');
            let reader = new FileReader();

            reader.readAsDataURL(this.file);
            reader.addEventListener('load', function () {
                image.src = reader.result;
            });
        },
        handleFileUpload(event) {
            if ((event.target.files.length) === 0) {
                this.deleteFile(event);
                return 0;
            }
            this.file = event.target.files[0];
            this.delete_value = 1;
            this.previewImage();
        },
        deleteFile(event) {
            let imageInput = document.getElementById('change_avatar');
            imageInput.value = null;
            this.file = '';
            this.delete_value = 1;
            this.source = '';
        },
    },
    data() {
        return {
            file: '',
            source: this.src,
            delete_value: 0,
            name: this.att_name
        }
    },
}

</script>
