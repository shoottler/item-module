<template>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="items-module mb-4">
        <Sidebar
          :nav-items="nav"
          :show-company-switch="false"
          :show-minimizer="false"
        />
        <main>
          <router-view/>
        </main>
      </div>
    </div>
  </div>
</template>

<script>
import nav from '../_nav'
import { Sidebar } from '../../../../../../../resources/js/coreui/components'
export default {
  name      : 'ItemsContainer',
  components: { Sidebar },
  data () {
    return { nav: nav.items }
  },
}
</script>

<style scoped>

</style>
