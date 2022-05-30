<template>
  <div id="app-layout" class="layout container-fluid">
      <div class="row">
        <div class="col-sm-4 col-md-2">
          <img src="/img/Chill-Chain_Logo.png" alt="Logo" height="50" width="200">
        </div>
        <div class="col-sm-8 col-md-10">
          <router-view></router-view>
        </div>
      </div>
  </div>
</template>

<script>
export default {
  name: 'Layout',
}
</script>
