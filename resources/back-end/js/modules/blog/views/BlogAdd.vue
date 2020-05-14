<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add post</h3>
                </div>
                <form @submit.prevent="saveBlog" @keydown="form.onKeydown($event)">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <alert-error :form="form"></alert-error>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input
                                        v-model="form.title"
                                        type="text"
                                        name="title"
                                        class="form-control"
                                        placeholder="Enter title"
                                    />
                                    <has-error :form="form" field="title"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="">Summary</label>
                                    <textarea
                                        v-model="form.summary"
                                        class="form-control"
                                        placeholder="Enter summary"
                                    />
                                    <has-error :form="form" field="summary"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="">Content</label>
                                    <editor
                                        api-key="3pcas7szukh1ybkajjx487slp3poawo33fs9tw9o1k0ly3jf"
                                        v-model="form.content"
                                        :init="tinymce_init"
                                    />
                                    <has-error :form="form" field="content"></has-error>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Thumbnail</label>
                                    <input type="file" name="thumbnail" @change="selectThumbnail" />
                                    <img
                                        src="/images/image_placeholder.png"
                                        alt=""
                                        class="preview"
                                    />
                                    <has-error :form="form" field="thumbnail"></has-error>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button :disabled="form.busy" type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</template>

<script>
// https://github.com/tinymce/tinymce/issues/2836
import { Form, HasError, AlertError } from 'vform';
import { objectToFormData } from 'object-to-formdata';
import Editor from '@tinymce/tinymce-vue';
import axios from 'axios';

export default {
    name: 'BlogAdd',
    components: {
        Form,
        HasError,
        AlertError,
        Editor,
    },
    data() {
        return {
            form: new Form({
                title: '',
                summary: '',
                thumbnail: null,
                content: '',
            }),
            tinymce_init: {
                height: 500,
                menubar: false,
                content_css: '//www.tiny.cloud/css/codepen.min.css',
                plugins: [
                    'advlist autolink lists link image code charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount',
                ],
                menubar: 'file edit view insert format tools table tc help',
                toolbar:
                    'undo redo | formatselect | bold italic backcolor | \
                         alignleft aligncenter alignright alignjustify | \
                         bullist numlist outdent indent | removeformat | help',
                automatic_uploads: true,
                // override default upload handler to simulate successful upload
                images_upload_handler: function (blobInfo, success, failure, folderName) {
                    let formData = new FormData();
                    formData.append('image_post', blobInfo.blob(), blobInfo.filename());
                    axios({
                        method: 'POST',
                        url: '/blogs/upload_image',
                        data: formData,
                    }).then((res) => {
                        tinymce.activeEditor.insertContent(
                            `<img class="content-img" style="width: 80%; margin-left: 10%" src="${res.data.path}"/>`
                        );
                        $('.tox-dialog-wrap').css('display', 'none');
                    });
                },
                setup: function (editor) {
                    editor.on('KeyDown', (e) => {
                        if ((e.keyCode == 8 || e.keyCode == 46) && tinymce.activeEditor.selection) {
                            // delete & backspace keys
                            var selectedNode = tinymce.activeEditor.selection.getNode(); // get the selected node (element) in the editor
                            if (selectedNode && selectedNode.nodeName == 'IMG') {
                                this.removeImage(selectedNode.src);
                            } else if (selectedNode = selectedNode.getElementsByTagName('img')[0]) {
                                this.removeImage(selectedNode.src);
                            }
                        }
                    });
                },
                removeImage(src) {
                    let img_path = src.split(`${window.location.hostname}:${window.location.port}`)[1];
                    axios({
                        method: 'POST',
                        url: '/blogs/remove_image',
                        data: {path: decodeURI(img_path)},
                    }).then((res) => {});
                },
            },
        };
    },
    methods: {
        selectThumbnail(e) {
            if (e.target.files && e.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);

                this.form.thumbnail = e.target.files[0];
            }
        },
        async saveBlog() {
            this.$store.dispatch('setAdminMainLoading', { show: true });
            try {
                const { data } = await this.form.post('/blogs', {
                    // Transform form data to FormData
                    transformRequest: [
                        function (data, headers) {
                            return objectToFormData(data);
                        },
                    ],
                });
            } catch (error) {
                this.$store.dispatch('setAdminMainLoading', { show: false });
                return;
            }
            this.$store.dispatch('setAdminLoading', { show: false });
            this.$router.push({ name: 'main.blog' });
        },
    },
};
</script>
