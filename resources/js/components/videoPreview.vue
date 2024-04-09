<template>
    <div class="video-preview-container">
        <input type="hidden" name="deleted_video" :value="delete_value">
        <div class="row">
            <div class="col-8 text-right">
                <label for="video">
                    <span class="image_uploader_label">
                        انتخاب فایل
                    </span>
                </label>
                <input name="video" id="video" type="file" accept="video/*" @change="handleFileUpload( $event )"
                       hidden/>
            </div>
            <div class="col-4">
                <div class="video_preview--body">
                    <video id="video-preview" controls v-show="file != '' || source !=''">
                        <source :src="source">
                    </video>
                    <div id="delete_video" @click="deleteFile($event)" v-show="file != '' || source !=''">
                        <svg class="times-icon" xmlns="http://www.w3.org/2000/svg" width="0.65em" height="0.65em"
                             preserveAspectRatio="xMidYMid meet" viewBox="0 0 352 512" data-v-3904557e="">
                            <path
                                d="m242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28L75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256L9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"
                                fill="currentColor" data-v-3904557e=""></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['src'],
    name: 'video',
    methods: {
        previewVideo() {
            let video = document.getElementById('video-preview');
            let reader = new FileReader();

            reader.readAsDataURL(this.file);
            reader.addEventListener('load', function () {
                video.src = reader.result;
            });
        },
        handleFileUpload(event) {
            if ((event.target.files.length) === 0) {
                this.deleteFile(event);
                return 0;
            }
            this.file = event.target.files[0];
            this.delete_value = 1;
            this.previewVideo();
        },
        deleteFile(event) {
            let videoInput = document.getElementById('video');
            videoInput.value = null;
            this.file = '';
            this.delete_value = 1;
            this.source = '';
        },
    },
    data() {
        return {
            file: '',
            source: this.src,
            delete_value: 0
        }
    },
}

</script>
