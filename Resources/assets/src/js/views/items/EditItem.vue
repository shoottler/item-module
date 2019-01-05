<template>
  <b-card>
    <div slot="header">
      <strong>Edit item</strong> <small>{{ item.name }}</small>
    </div>
    <div
      v-if="serverErrors"
      class="server-error">
      <div
        v-for="(value, key) in serverErrors"
        :key="key">
        {{ value[0] }}
      </div>
    </div>
    <b-form @submit.prevent="validateBeforeSubmit(id)">
      <b-form-group>
        <label for="name">Item</label>
        <b-form-input
          type="text"
          id="name"
          name="name"
          placeholder="Item's Name"
          v-model="item.name"
          v-validate="'required|max:255'"/>
      </b-form-group>
      <b-form-group>
        <label for="description">Description</label>
        <b-form-input
          type="text"
          id="description"
          name="description"
          placeholder="Description"
          v-model="item.description"
        />
      </b-form-group>
      <b-button
        type="submit"
        variant="primary">Update</b-button>
      <b-button
        @click="deleteWarning = true"
        variant="link"> delete</b-button>
    </b-form>

    <b-modal
      title="You are about to delete an item. Are you sure?"
      class="modal-danger"
      v-model="deleteWarning"
      @ok="deleteItem(id)"
      ok-variant="danger">
      When you delete an item, all its information and all its related records get permanently erased.
      This process can't be undone.
      Proceed only if you are completely sure.
    </b-modal>
  </b-card>
</template>
<script>
import { createNamespacedHelpers } from 'vuex'
const { mapActions } = createNamespacedHelpers('item')
export default {
  name : 'EditItem',
  props: { id: '' },
  data () {
    return {
      item: {
        name       : '',
        description: '',
      },
      serverErrors  : '',
      successMessage: '',
      deleteWarning : false,
    }
  },
  mounted () {
    this.getItem(this.id)
  },
  methods: {
    ...mapActions({
      show   : 'show',
      update : 'update',
      destroy: 'destroy',
    }),
    getItem (id) {
      this.show(id).then((response) => {
        this.item =  response.data.data
      }).catch((err) => {
        this.serverErrors = Object.values(err.response.data.errors)
      })
    },
    validateBeforeSubmit (id) {
      this.$validator.validateAll().then((result) => {
        if (result)
          this.updateItem(id, this.item)
      })
    },
    updateItem (id, item) {
      this.update({ id, item }).then(() => {
        this.$router.push({ name: 'items list' })
      }).catch((err) => {
        this.serverErrors = Object.values(err.response.data.errors)
      })
    },
    deleteItem (id) {
      this.deleteWarning = false
      this.destroy(id).then(() => this.$router.push({ name: 'items list' }))
    },
  },
}
</script>
