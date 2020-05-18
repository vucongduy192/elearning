<template>
    <div>
        <!-- Modal -->
        <div id="delModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete confirm</h4>
                    </div>
                    <div class="modal-body">
                        <p>{{ this.$i18n.t('textConfirmDelete') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </button>

                        <button
                            type="button"
                            class="btn btn-primary"
                            data-dismiss="modal"
                            @click="submit()"
                        >
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'AppModal',
    methods: {
        submit() {
            let delEntity = this.$store.state.storeNotify;
            this.$store.dispatch(delEntity.entityAction, { vue: this, id: delEntity.entity.id })
            this.$store.dispatch('pushSuccessNotify', {msg: delEntity.entityNotify})
        },
    },
};
</script>
