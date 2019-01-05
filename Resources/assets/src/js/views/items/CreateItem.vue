<template>
  <div class="animated fadeIn">
    <b-card>
      <div slot="header">
        <strong>Item</strong> <small>Form</small>
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
      <b-form @submit.prevent="validateBeforeSubmit(item)">
        <span class="form-error">{{ errors.first('name') }}</span>
        <b-form-group>
          <label for="name">Name </label>
          <b-form-input
            type="text"
            id="name"
            name="name"
            placeholder="Item's name"
            v-model="item.name"
            v-validate="'required|max:255'"/>
        </b-form-group>
        <span class="form-error">{{ errors.first('description') }}</span>
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
          variant="primary">Save</b-button>
      </b-form>
    </b-card>
  </div>

</template>

<script>
import { createNamespacedHelpers } from 'vuex'
const { mapState }   = createNamespacedHelpers('company')
const { mapActions } = createNamespacedHelpers('item')
export default {
  name: 'CreateItem',
  data () {
    return {
      item: {
        name       : '',
        description: '',
      },
      serverErrors  : '',
      successMessage: '',
    }
  },
  computed: { ...mapState({ activeCompanyId: (state) => state.activeCompany.id }) },
  methods : {
    ...mapActions({ store: 'store' }),
    validateBeforeSubmit (item) {
      this.$validator.validateAll().then((result) => {
        if (result)
          this.createItem(item)
      })
    },
    createItem (item) {
      item.company_id = this.activeCompanyId
      this.store(item).then(() => {
        this.$router.push({ name: 'items list' })
      }).catch((err) => {
        this.serverErrors = Object.values(err.response.data.errors)
      })
    },
  },
}
</script>
