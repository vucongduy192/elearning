import toastr from 'toastr';

const ADMIN_ENTITY_DELETE_MODAL = 'ADMIN_ENTITY_DELETE';

const state = {
    // only use in delete modal
    entity: null,
    entityAction: '',
    entityNotify: '',
};

const mutations = {
    [ADMIN_ENTITY_DELETE_MODAL](state, { entity, entityAction, entityNotify }) {
        state.entity = entity;
        state.entityAction = entityAction;
        state.entityNotify = entityNotify;
    },
};

const actions = {
    passEntityDeleteModal({ commit }, { entity, entityAction, entityNotify }) {
        commit(ADMIN_ENTITY_DELETE_MODAL, { entity, entityAction, entityNotify });
    },
    pushSuccessNotify({ commit }, params) {
        toastr.success(params.msg);
    },
    pushWarningNotify({ commit }, params) {
        toastr.warning(params.msg);
    },
};

const storeNotify = {
    state,
    actions,
    mutations,
};

export default storeNotify;
