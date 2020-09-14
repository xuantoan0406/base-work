<template>
  <div class="content-setting">
    <div class="title"> {{ $t('setting.changePass.title') }}</div>
    <div class="avatar">
      <img v-if="avatar===null" :src="' /imgs/user2.png'" alt="" class="avatar1">
      <img v-else :src="`/imgs/avatarUser/${avatar}`" alt="" class="avatar1">
    </div>

    <div class="form-changePass">
      <div class="form-group">
        <label for="oldPassword" class="lb">{{ $t('setting.changePass.oldPassword') }} </label>
        <input
          id="oldPassword"
          v-model="oldPassword"
          type="password"
          class="form-control"
          required="required"
        >
      </div>
      <div class="form-group">
        <label for="newPassword" class="lb">{{ $t('setting.changePass.newPassword') }}</label>
        <input
          id="newPassword"
          v-model="newPassword"
          type="password"
          class="form-control"
          required="required"
        >
      </div>
      <div class="form-group">
        <label for="cfPassword" class="lb">{{ $t('setting.changePass.confirmPassword') }}</label>
        <input
          id="cfPassword"
          v-model="confirmPassword"
          type="password"
          class="form-control"
          required="required"
        >
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ $t('setting.changePass.changePassword') }}
        </button>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex';
export default {
  data() {
    return {
      oldPassword: '',
      newPassword: '',
      confirmPassword: '',
      error: [],
    };
  },
  computed: {
    ...mapState({
      avatar: state => state.user.imgUser,
    }),
  },
  created() {
  },
};
</script>

<style lang="scss">
    .content-setting {
        height: 90%;
        width: 70%;
        background-color: #efefef;
        float: left;
        margin: 0.5%;

        .title {
            background-color: #fee67a;
            height: 4%;
            margin-bottom: 0.5%;
            padding-left: 2%;
            padding-top: 0.7%;
        }

        .avatar {
            height: 35%;
            max-height: 300px;
            padding-top: 2%;
            text-align: center;
            margin-bottom: 3%;
        }

        .form-group {
            .lb {
                margin-left: 7%;
            }

            .btn-primary {
                margin-left: 7%;
            }
        }

        .form-changePass {
            height: 55%;
            margin-left: 7%;
        }

    }
</style>
