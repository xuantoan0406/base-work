<template>
  <div class="app-setting">
    <div class="wrap-setting">
      <nav-bar-setting />

      <router-view />

    </div>
  </div>
</template>

<script>

import { mapState } from 'vuex';
import NavBarSetting from '../../components/NavBarSetting';
export default {
  components: { NavBarSetting },
  computed: {
    ...mapState({
      userId: state => state.user.id,
      userName: state => state.user.name,
      userType: state => state.user.type,
    }),
  },
};
</script>
<style lang="css">

    .app-setting {
        height: auto;
        width: 95%;
        margin-top: 3%;
        margin-left: 5%;
        background-color: #ffffff;

    }

    .wrap-setting {
        height: auto;
        margin: 2%;
        background-color: #ffffff;

    }

</style>
