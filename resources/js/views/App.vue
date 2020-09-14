<template>
  <div id="app">
    <div v-if=" user.id !=null && device==='desktop'">
      <nav-bar />
    </div>
    <div class="wrap">
      <app-main />
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import AppMain from '../components/layout';
import NavBar from '../components/layout/NavBar';
const { body } = document;
export default {
  name: 'App',
  components: { NavBar, AppMain },
  data() {
    return {
      device: '',
    };
  },
  computed: {
    ...mapState({
      user: state => state.user,
    }) },
  mounted() {
    this.checkDevice();
    console.log(this.user.id);
  },

  methods: {
    checkDevice(){
      const rect = body.getBoundingClientRect();
      if (Number(rect.width) < 768){
        this.device = 'phone';
      } else {
        this.device = 'desktop';
      }
    },
  },
};
</script>
<style type="scss" scoped>
    .wrap {
        height: auto;
        /*max-height: 120vh;*/

    }

    #app {
        background-color: #ffffff;
        font-size: 17px;
        height: auto;
    }
</style>
