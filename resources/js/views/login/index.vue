<template>
  <main class="py-4">

    <div class="logo">
      <img v-if="device==='phone'" src="/imgs/logoPhone.png" alt="" class="imgPhone">
      <img v-else src="/imgs/logo.png" class="img">
    </div>
    <form class="form">
      <div class="form-group">
        <label for="email" class="label">{{ $t('login.userName') }}</label>
        <div class="col-md-6">
          <input
            id="email"
            v-model="loginForm.email"
            type="email"
            class="form-control"
            name="email"
            required
            autocomplete="email"
            autofocus
          >
        </div>
      </div>
      <div class="form-group">
        <label for="password" class="label">{{ $t('login.password') }}</label>

        <div class="col-md-6">
          <input
            id="password"
            v-model="loginForm.password"
            type="password"
            class="form-control"
            name="password"
            required
            autocomplete="current-password"
          >
        </div>
      </div>
      <div class="form-group row">
        <div class="col-md-6 offset-md-4">
          <div class="form-check">
            <input
              id="remember"
              v-model="loginForm.rememberMe"
              class="form-check-input"
              type="checkbox"
              name="remember"
            >
            <label class="form-check-label" for="remember">{{ $t('login.rememberMe') }}</label>
          </div>
        </div>
      </div>

      <div class="form-group mb-0">
        <div class="col-md-8 offset-md-4">
          <button type="button" class="btn btn-primary" @click="handleLogin">{{ $t('login.login') }}</button>
        </div>
        <div class="rs-pw">
          <a class="btn btn-link passWord" href="/#">{{ $t('login.forGotYourPassword') }}</a>
        </div>
        <div class="rs-pw">
          <a class="btn btn-link domain" href="/#">{{ $t('login.getNewDomain') }}</a>
        </div>
      </div>
    </form>
    <div class="bot">
      <div class="footer">
        <div class="sp">
          <a href="/#">{{ $t('login.support') }}</a>
        </div>
        <div class="tou">
          <a href="/#">{{ $t('login.termsOfUse') }}</a>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import { csrf } from '../../api/auth';
const { body } = document;
export default {
  name: 'Login',
  data() {
    return {
      device: '',
      loginForm: {
        name: '',
        password: '',
        rememberMe: false,
      },
      redirect: undefined,
      otherQuery: {},
    };
  },
  watch: {
    $route: {
      handler: function(route) {
        const query = route.query;
        if (query) {
          this.redirect = query.redirect;
          this.otherQuery = this.getOtherQuery(query);
        }
      },
      immediate: true,
    },
  },
  mounted() {
    this.checkDevice();
    console.log(this.device);
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
    handleLogin() {
      csrf().then(() => {
        this.$store.dispatch('user/login', this.loginForm)
          .then(() => {
            if (this.device === 'phone'){
              this.$router.push('/home');
            } else {
              this.$router.push(
                {
                  path: this.redirect || '/activity',
                  query: this.otherQuery,
                },
                onAbort => {}
              );
            }
          })
          .catch(() => {});
      });
    },
    getOtherQuery(query) {
      return Object.keys(query).reduce((acc, cur) => {
        if (cur !== 'redirect') {
          acc[cur] = query[cur];
        }
        return acc;
      }, {});
    },
  },
};
</script>

<style type='scss' scoped>
    .form-control{
        margin-left: 0 !important;
        margin-bottom: 0;
        margin-top: 1%;
    }
    .py-4 {
        display: flex;
        flex-wrap: wrap;
        justify-content:center;
        width: 100%;
        height:100vh;
        background-color: #fee67a;
    }
    .logo{
        width: 100%;
        height:15%;

        margin-top: 5%;
        display: flex;
        flex-wrap: wrap;
        justify-content:center;

    }
    .imgPhone{
        width: 90%;
    }
    .img {

        width: 80%;

    }
    .form{
        width:90%;
        margin-bottom:5%;
        padding-bottom:3%;
        margin-top: 10%;
    }
    .label{
        margin-left: 8.8%;
    }
    #email{
        width: 90%;

    }
    #password{
        width: 90%;
    }
    .rs-pw{
        width: 80%;
        text-align:center;
    }
    .col-md-6{

        display: flex;
        flex-wrap: wrap;
        justify-content:center;
        Align-items:center;

    }
    .btn-primary{
        background-color: #da8024;
        border-color: #FF9800;
        width: 40%;
        max-width: 200px;
    }
    .btn-link{

        color:#3490dc;

    }
    .passWord{
        margin-top :10%
    }
    .offset-md-4{
        display: flex;
        flex-wrap: wrap;
        justify-content:center;
    }
    .mb-0{
        display: flex;
        flex-wrap: wrap;
        justify-content:center;
        Align-items:center;
    }
    .bot{
        width: 70%;
    }
    .footer{
        width:100%;
        display: flex;
        flex-wrap: wrap;
        justify-content:center;
        Align-items:center;

    }
    .sp{
        width: 30%;
    }
    .tou{
        width: 45%;
    }
    @media only screen and (min-width: 768px) {
        .py-4 {
            display: flex;
            flex-wrap: wrap;
            justify-content:center;
            Align-items:center;
            height:100vh;
            background-color: #fee67a;
            width: 100%;

        }

        .logo {
            margin-top:2%;
            width: 90%;
            display: flex;
            flex-wrap: wrap;
            justify-content:center;
            Align-items:center;
        }
        .img {

            width: 60%;
            max-height: 100px;
        }

        .form{
            width:90%;
            margin-bottom:2%;

            margin-top: 2%;
        }
        .col-md-6 {
            margin-left: 28%;
            width: 40%;
        }
        .label {
            margin-left: 30.8%
        };
        .row {
            width: 50%;
            display: flex;
            flex-wrap: wrap;
            justify-content:center;
        }
        .mb-0{
            display: flex;
            flex-wrap: wrap;
            justify-content:center;
            Align-items:center;
        }
        .form-check{
            margin-left: -14%;
        }
        .btn-primary {
            margin-left: -52%;
            width: 20%;
        }
        .passWord{
            margin-top:3%
        }
        .btn-link {

            text-align: center;
            margin-bottom: 0;
        }

        .bot {
            height: 15%;
        }
        .sp {
            text-align: center;
            width: 20%;
        }
        .tou {
            text-align: center;
            width: 30%;
        }
    }
</style>
