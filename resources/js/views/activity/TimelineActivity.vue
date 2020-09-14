<template>
  <div class="lineActivity">
    <div v-if="user.activityByDate" class="lineAct">
      <div
        v-for="activity in user.activityByDate"
        :key="activity.id"
        class="line"
        :style="{backgroundColor:activity.status.color,
                 width:calWidth(activity.created_at, activity.time_finish)+'%',
                 left:calLeft(activity.created_at)+'%'}"
      >
        <div class="status" :style="{backgroundColor: activity.status.color}">
          <div class="content" :style="{backgroundColor: activity.status.color}">
            <div class="circle" />
            {{ activity.status.status }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import EventBus from '../../app';
// import CellUserCreateAct from './CellUserCreateAct';
const moment = require('moment-timezone');
// const moment = require('moment');
export default {
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
  },
  data() {
    return {
      PercentHour: '',
    };
  },
  created() {
    console.log(this.user.id);
    // if (this.user.activityByDate[Object.keys(this.user.activityByDate)[Object.keys(this.user.activityByDate).length - 1]]){
    //     if(this.user.activityByDate[Object.keys(this.user.activityByDate)[Object.keys(this.user.activityByDate).length - 1]].time_finish == this.user.activityByDate[Object.keys(this.user.activityByDate)[Object.keys(this.user.activityByDate).length - 1]].created_at){
    //         this.user.activityByDate[Object.keys(this.user.activityByDate)[Object.keys(this.user.activityByDate).length - 1]].time_finish = moment().format('YYYY-MM-DD HH:mm:ss');
    //     };
    // }
  },
  mounted() {
    // this.getActivityByDate();
    this.CalPercentHours();
  },

  methods: {
    // getActivityByDate() {
    //     console.log(this.user);
    //     this.$http.post('/api/getActivityByDate', {date: this.date, userID: this.user.id })
    //         .then( response => {
    //             this.condition = true;
    //             this.lineActivityDays = response.data.data;
    //             console.log(this.lineActivityDays);
    //         })
    //         .catch(error => {
    //            error.response.data;
    //         });
    // },

    CalPercentHours() {
      this.PercentHour = 100 / 13;
    },

    calWidth(start, finish) {
      console.log('----------------');
      // console.log(id);
      const startTime = moment(start);
      const finishTime = moment(finish);
      console.log(startTime);
      console.log(finishTime);
      // console.log(startTime.hour());
      // console.log(finishTime.hour());
      if (startTime.hour() < 8 && finishTime.hour() >= 8 && finishTime.minute() > 0){
        console.log('set hour = 8');
        startTime.set('hour', 8).set('minute', 0).set('second', 0);
        console.log(startTime);
      }
      if (finishTime.hour() > 21 && finishTime.second() > 0) {
        finishTime.set('hour', 21).set('minute', 0).set('second', 0);
      }
      if (finishTime.hour() < 8 || startTime.hour() > 20) {
        console.log('delete');
        return 0;
      }
      const date = moment(this.date);
      console.log(startTime.date());
      console.log(finishTime.date());
      if (startTime.date() < finishTime.date() || startTime.month() < finishTime.month()) {
        console.log('start nho hon');
        startTime.set('hour', 8).set('minute', 0).set('second', 0);
        startTime.set({ 'year': finishTime.year(), 'month': finishTime.month(), 'date': finishTime.date() });
        console.log(startTime);
      }
      if (finishTime.date() > date.date()) {
        // console.log('lon hon');
        finishTime.set('hour', 21).set('minute', 0).set('second', 0);
        finishTime.subtract(1, 'd');
        // console.log(finishTime);
      }
      // console.log(startTime.hour());
      // console.log(finishTime.hour());
      const timeAct = finishTime.diff(startTime, 'seconds');
      console.log(timeAct);
      let actWidth = parseFloat(timeAct) / 3600 * this.PercentHour;
      // console.log('result')
      console.log(parseFloat(actWidth));
      if (actWidth > 100){
        console.log('lon hon 100');
        actWidth = 100;
      }
      return parseFloat(actWidth);
    },

    calLeft(start){
      const startTime = moment(start);
      const originTime = moment(start).set('hour', 8).set('minute', 0).set('second', 0);
      const timeAct = startTime.diff(originTime, 'seconds');
      let actLeft = parseFloat(timeAct) / 3600 * this.PercentHour;
      if (actLeft < 0 && actLeft > -90){
        actLeft = -900;
      }
      return parseFloat(actLeft);
    },
  },

};
</script>

<style lang="scss" scoped>
    .borderNow {
        display: inline-block;
        width: 2px;
        background-color: rgb(0, 0, 0);
        height: 20px;
        margin-left: -4px;
    }
    .circle {
        display: inline-block;
        width: 10px;
        height: 10px;
        background: white;
        border-radius: 50%
    }
    .status {
        display: none;
        /*padding: 0px 10px;*/
        text-align: center;
        font-size: 10px;
        min-width: 80px;
        color: white;
        position: absolute;
        left: 30%;
        top: -30px;
    }

    .content {
        position: relative;
        padding: 2px 5px 2px;
    }

    .content:after {
        content: '';
        position: absolute;
        bottom: -7.5px;
        left: 40%;
        background-color: inherit;
        width: 0;
        height: 0;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
        /*border-top: 100px solid inherit;*/
    }
    .line:hover .status {
        display: inline-block;
        z-index: 100;
    }

    .line {
        position: absolute;
    }
    .lineActivity {
        position: absolute;
        top: 30px;
        height: 30px;
        width: 100%;
    }
    .line {
        height: 30px;
        content: '';
        display: inline-block;
    }

    /*responsive*/
    /*1024*/

</style>
