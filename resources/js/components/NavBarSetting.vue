<template>
  <div class="btn-group-vertical">
    <div class="button-setting">
      <div type="button" class="btn btn-warning st-s">{{ $t('setting.navBar.setting') }}</div>
    </div>
    <div class="button-setting">
      <div class="mini-color" />
      <div class="bt-st">
        <router-link :to="{name:'personal'}">
          <button type="button" class="btn btn-warning st-sp">
            {{ $t('setting.navBar.settingPersonal') }}
          </button>
        </router-link>
      </div>

    </div>
    <div class="button-setting">
      <div class="mini-color" />
      <div class="bt-st">
        <router-link :to="{name:'changePass'}">
          <button type="button" class="btn btn-warning st-pc">
            {{ $t('setting.navBar.changePass') }}
          </button>
        </router-link>
      </div>

    </div>
    <div v-if="role" class="button-setting">
      <div class="mini-color" />
      <div class="bt-st">
        <router-link :to="{name:'status'}">
          <button type="button" class="btn btn-warning st-ss">
            {{ $t('setting.navBar.settingStatus') }}
          </button>
        </router-link>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex';

export default {
  computed: {
    ...mapState({
      userId: state => state.user.id,
      userName: state => state.user.name,
      userType: state => state.user.type,
      role: state => state.user.role,
    }),
  },
};
</script>
<style lang="css">

    .app-setting {
        height: 100%;
        width: 100%;
        margin-top: 3%;
        margin-left: 5%;
        background-color: #ffffff;

    }

    .btn-group-vertical {
        width: 275px;
        float: left;

    }

    .button-setting {
        margin: 2%;
        width: 260px;
        height: 35px;
    }

    .mini-color {
        float: left;
        width: 1%;
        height: 35px;
        background-color: #fee67a;
        margin-left: 7%;
    }

    .bt-st {
        float: left;
        background-color: #fee67a;
        width: 80%;

    }

    .bt-different {

    }

    .btn-warning {
        background-color: #ffffff !important;
        border: 0;
        border-color: #ffffff;
        width: 100%;
        max-width: 250px;
        margin: 0;
        margin-left: 2%;

    }

    .st-s {
        background-color: #fee67a !important;
        width: 82%;
        margin-left: 7%;
        margin-left: 7%;

    }

    .st-pc {
        background-color: #efefef !important;

    }

    .st-sp {
        background-color: #efefef !important;
    }

    .st-ss {
        background-color: #efefef !important;
    }

</style>
