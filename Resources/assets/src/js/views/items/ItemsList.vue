<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <h4><router-link :to="{ name:'Create an item' }">Create a new item</router-link></h4>
        <items-table
          :company="activeCompanyId"
          caption="<i class='fa fa-align-justify'></i> Items table"/>
      </b-col><!--/.col-->
    </b-row>
  </div>
</template>

<script>
import { createNamespacedHelpers } from 'vuex'
import ItemsTable from './ItemsTable'
const { mapState } = createNamespacedHelpers('company')
export default {
  name      : 'ItemsList',
  components: { ItemsTable },
  computed  : { ...mapState({ activeCompanyId: (state) => state.activeCompany.id }) },
}
</script>
