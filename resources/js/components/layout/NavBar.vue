<template>
  <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="logo">

      <router-link to="/activity"><img src="/imgs/logo.png" width="80%" height="100%"></router-link>

      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon" />
      </button>
    </div>
    <div class="t">
      <router-link to="/"><img src="/imgs/t.png" alt="t" height="80%" width="80%"></router-link>
    </div>
    <div class="k">
      <router-link to="/"><img src="/imgs/k.png" alt="t" height="80%" width="80%"></router-link>
    </div>
    <div class="time">
      <div class=" time-png">
        <router-link to="/"><img src="/imgs/time.png" alt="t" width="90%"></router-link>
      </div>
      <div class="time-view">{{ timeToday }}</div>
    </div>
    <div class="user">
      <div class="img">
        <router-link to="/setting">
          <img v-if="avatar===null && userAvatar===null" :src="' /imgs/user2.png'" alt="" class="mini-avatar">
          <img v-else-if="avatar && userAvatar===null" :src="`/imgs/avatarUser/${avatar}`" alt="" class="mini-avatar">
          <img v-else-if="avatar===null && userAvatar" :src="`/imgs/avatarUser/${userAvatar}`" alt="" class="mini-avatar">
          <img v-else :src="`/imgs/avatarUser/${userAvatar}`" alt="" class="mini-avatar">
        </router-link>
      </div>
      <div class="name">{{ userName }}</div>
    </div>
    <div class="setting">
      <div>
        <router-link :to="{name:'setting'}"><img src="/imgs/setting.png" alt="t" height="80%" width="80%">
        </router-link>
      </div>
    </div>
    <div class="logout">
      <button type="button" class="btn btn-warning" @click="handleLogout">{{ $t('navBar.logOut') }}</button>
    </div>

  </nav>
</template>

<script>
import { mapState } from 'vuex';
import moment from 'moment';

export default {
  data() {
    return {
      timeToday: '',
      timeWorkToday: '',
      avatar: null,
      user: {},
    };
  },
  computed: {
    ...mapState({
      userId: state => state.user.id,
      userName: state => state.user.name,
      userType: state => state.user.type,
      userAvatar: state => state.user.avatar,
    }),
  },
  mounted() {
    this.calTimeWork();
    this.getInfoUser();
  },
  methods: {
    getInfoUser(){
      this.$http.get('/api/users/' + this.userId)
        .then(response => {
          this.avatar = response.data.avatar;
          console.log(this.avatar);
        });
    },
    handleLogout() {
      this.$store.dispatch('user/logout').then(() => {
        this.$router.push(`/login?redirect=${this.$route.fullPath}`);
      });
      this.$store.dispatch('user/updateAvatar', null);
    },
    calTimeWork() {
      const date = new Date();
      const timeToday = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });
      this.timeToday = timeToday;

      this.$http.get('/api/getActTodayByAuth')
        .then(response => {
          console.log('calTimeWorkAuth');
          console.log(response.data);
          const actArray = response.data.data;
          console.log(actArray);
          let totalMinutes = 0;
          if (actArray.length){
            const activityByDate = Object.entries(response.data.data);
            let lastElement;
            for (lastElement in activityByDate) {
              console.log();
            }
            if (activityByDate[lastElement].time_finish === activityByDate[lastElement].created_at){
              activityByDate[lastElement][1].time_finish = moment().format('YYYY-MM-DD HH:mm:ss');

              console.log(activityByDate[lastElement][1].time_finish);
            }
            // console.log(activityByDate);
            for (let i = 0; i < activityByDate.length; i++) {
              if (activityByDate[i][1].status.type === 0) {
                const startTime = moment(activityByDate[i][1].created_at);
                console.log(startTime);
                const finishTime = moment(activityByDate[i][1].time_finish);
                console.log(finishTime);
                if (startTime.hour() >= 8 && finishTime.hour() <= 21) {
                  const timeAct = finishTime.diff(startTime, 'minutes');
                  console.log(timeAct);
                  const workHour = parseFloat(timeAct);
                  console.log(workHour);
                  totalMinutes += workHour;
                }
              }
            }
          }

          console.log('workHour');
          var hours = Math.floor(totalMinutes / 60);
          if (parseInt(hours) === 0) {
            hours = '00';
          } else if (hours < 10) {
            hours = '0' + hours;
          }
          console.log(hours);
          var minutes = totalMinutes % 60;
          if (parseInt(minutes) === 0) {
            minutes = '00';
          } else if (minutes < 10) {
            minutes = '0' + minutes;
          }
          console.log(minutes);
          this.timeWorkToday = hours + ':' + minutes;
        })
        .catch(error => error.response.data);
    },
  },
};
</script>
<style lang="scss">
    .bg-white {
        background-color: rgb(254, 230, 122) !important;
    }

    .logo {

        height: 100%;
        width: 50%;
    }

    .navbar {
        height: 8%;
    }

    .navbar-brand {
        height: 100%;
        margin-left: 8%;
        width: 85%;
        padding: 0;
    }

    .k {
        margin-left: 1%;
    }

    .time {

        margin-left: 3%;

        .time-png {
            width: 45px;
            float: left;
        }

        .time-view {
            float: left;
            font-size: x-large;
        }
    }

    .user {
        height: 90%;
        margin-top: 0.5%;
        width: 16%;

        .img {
            margin-bottom: 5%;
            margin-left: 10%;
            float: left;
            .mini-avatar{
                width: 45px;
                height:45px;
                border-radius: 50%;
            }
        }

        .name {
            float: left;
            margin-top: 5px;
            margin-left: 17px;
            height: 80%;
            font-size: x-large;

        }
    }

    .btn-warning {
        background-color: #f9b739 !important;
    }

    .setting {

    }

    .logout {
        margin-left: 2%;
    }
</style>

