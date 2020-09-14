<template>
  <div class="row">
    <div class="col-lg-8 col-left">
      <div class="row">
        <div class="col-lg-3 info">
          <div class="contentInfo">

            <img v-if="user.avatar===null" :src="' /imgs/user2.png'" class="img-circle">

            <img v-else :src="`/imgs/avatarUser/${user.avatar}`" class="img-circle">

            <p class="name">{{ user.name }}</p>
          </div>

          <select
            v-if=" userId == user.id || userRole == 1"
            v-model="selected"
            class="col-md-12 control-label select"
            @change="createActivityNew(user.id,statuses[selected].id)"
          >
            <option disabled value="">
              <span class="dot" :style="[condition ? {backgroundColor : statuses[selected].color} : {backgroundColor: colorNow}]" />
              {{ activityNow }}
            </option>
            <option
              v-for="(status,index) in statuses"
              :key="index"
              :value="index"
              :style="{backgroundColor:status.color}"
            >
              {{ status.status }}
            </option>
          </select>
          <p class="industry">{{ user.industry }} / {{ user.main_company }}</p>
          <div class="time">
            <img src="/imgs/timeLogo.png" alt="t" height="80%" width="80%">
            {{ timeWorkToday }}
          </div>
          <div class="comment">{{ user.comment }}</div>
          <router-link :to="{name:'personal'}" class="a-setting"><img class="setting" src="/imgs/setting-logo.png"></router-link>
        </div>
        <div class="col-lg-9">
          <div class="row">
            <div class="col-lg-6 log-task-cell">
              <span>{{ $t('userDetails.logTask') }}</span>
              <div class="row">
                <div class="col-lg-12" />
              </div>
            </div>
            <div class="col-lg-6 note-cell">
              <NoteRecently :user="user" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 cellHistory" style="margin-top: 10px;">
      <span>{{ $t('userDetails.activityHistory') }}</span>
      <div class="row">
        <div class="col-lg-12 actsHistory">
          <div
            v-for="(actHistory, index) in listActHistory"
            :key="index"
          >
            <div class="actHistory">
              <TimelineActHistory :act-history="actHistory.activityByDate" />
            </div>
          </div>

          <router-link :to="{name:'activityHistory', params: { user } }">
            <button type="button" class="btn btn-block seeMore">
              {{ $t('userDetails.seeMore') }}
            </button>
          </router-link>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EventBus from '../../app';
import TimelineActHistory from './TimelineActHistory';
import NoteRecently from './../note/NoteRecently';
import moment from 'moment';
import 'moment-timezone';
moment.tz.setDefault('Asia/Tokyo');
const CREATE_ACTIVITY_NEW = 'CREATE_ACTIVITY_NEW';
import { mapState } from 'vuex';
export default {
  components: { TimelineActHistory, NoteRecently },
  props: {
    user: {
      type: Object,
      required: true,
    },
    date: {
      type: String,
      required: true,
      default: '',
    },
    statuses: {
      type: Array,
      require: true,
      default: () => [],
    },
  },
  data() {
    return {
      selected: '',
      condition: false,
      nowDate: moment().format('YYYY-MM-DD'),
      listActHistory: [],
      colorNow: '',
      activityNow: '',
      timeWorkToday: '',
    };
  },

  computed: {
    ...mapState({
      userId: state => state.user.id,
      userRole: state => state.user.role,
    }),
  },

  created() {
    if (this.user.activityByDate[Object.keys(this.user.activityByDate)[Object.keys(this.user.activityByDate).length - 1]]){
      this.colorNow = this.user.activityByDate[Object.keys(this.user.activityByDate)[Object.keys(this.user.activityByDate).length - 1]].status.color;
      this.activityNow = this.user.activityByDate[Object.keys(this.user.activityByDate)[Object.keys(this.user.activityByDate).length - 1 ]].status.status;
    }
    this.getActInFourDaysPrevious();
    this.calTimeWorkToday();
  },
  methods: {
    calTimeWorkToday() {
      console.log('calTimeWorkToday');
      let totalMinutes = 0;
      const activityByDate = Object.entries(this.user.activityByDate);
      console.log(activityByDate);
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
      var hours = Math.floor(totalMinutes / 60);
      if (parseInt(hours) === 0) {
        hours = '00';
      } else if (hours < 10) {
        hours = '0' + hours;
      }
      var minutes = totalMinutes % 60;
      if (parseInt(minutes) === 0) {
        minutes = '00';
      } else if (minutes < 10) {
        minutes = '0' + minutes;
      }
      this.timeWorkToday = hours + ':' + minutes;
    },

    getActInFourDaysPrevious(){
      this.$http.get('/api/getActInFourDaysPrevious?userID=' + this.user.id)
        .then(response => {
          console.log('getActInFourDaysPrevious');
          this.listActHistory = response.data;
          for (let i = 0; i < this.listActHistory.length; i++) {
            this.listActHistory[i].activityByDate = Object.values(this.listActHistory[i].activityByDate);
          }
        })
        .catch(error => error.response.data);
    },
    createActivityNew(userID, statusID) {
      this.$http.post('/api/activity', { userID: userID, statusID: statusID })
        .then(response => {
          this.condition = true;
          // console.log(response.data);
          console.log('createActivityNew done');
          EventBus.$emit(CREATE_ACTIVITY_NEW, this.user);
        })
        .catch(error =>
          error
        );
    },
  },
};
</script>
<style lang="scss" scoped>
    .actsHistory > div.actHistory:nth-child(4){
        border-bottom: none;
    }
    .setting {
        width: 40px;
        display: inline-block;
        float: right;
    }
    .a-setting {
        bottom: 0%;
        position: absolute;
        right: 0%;
    }

    .note-cell {
        margin-top: 10px;
    }
    .seeMore {
        background-color: #faefbb;
        margin-top: 20px;
        color: #FAA100;
    }
    .btn:focus {
        box-shadow: none !important;
    }
    .timeLineActHistory {
        padding: 15px 10px;
    }
    a:hover {
        text-decoration: none !important;
    }
    .contentInfo {
        position: relative;
        height: 150px;
    }

    .time > img {
        float: left;
        width: 40px;
    }
    .time {
        display: inline-block;
        padding: 0px 50px;
        font-size: 30px;
    }
    .comment {
        margin-top: 10px;
        text-align: center;
        font-size: 14px;
    }
    .industry {
        text-align: center;
    }
    /*.time {*/
    /*    position: relative;*/
    /*    left: 25%;*/
    /*}*/
    .dot {
        height: 25px;
        width: 25px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
    }
    .name {
        text-align: center;
        bottom: 0;
        position: absolute;
        margin: auto;
        font-size: 25px;
        left: 0;
        right: 0;
    }
    .img-circle {
        width: 100px;
        height: 100px;
        position: absolute;
        margin: auto;
        top: 5%;
        left: 0;
        right: 0;
        border-radius: 50%;
    }
    .info {
        background-color: #faa100;
        color: white;
        height: 400px !important;
    }

    .col-left > .row {
        height: 100%;
    }

    .cellHistory > .row {
        margin-right: 0px;
        margin-left: 0px;
        margin-top: 20px;
        margin-bottom: 10px;
        background-color: white;
    }

    .actHistory {
        border-bottom: 2px solid #ADB1AD;
    }

    .userDetail >.row {
        margin-right: 0px;
        margin-left: 0px;
    }
    .actsHistory {
        background-color: white;
        padding: 20px 20px;
    }
</style>
