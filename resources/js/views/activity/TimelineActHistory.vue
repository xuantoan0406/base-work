<template>
  <div class="timeLineActHistory row">
    <div class="dateHistory col-lg-3">
      <span v-if="monthHistory">{{ monthHistory }} / {{ dateHistory }} ({{ $t(dayHistory) }})</span>
    </div>
    <div class="lineAct col-lg-7">
      <div
        v-for="activity in actHistory"
        :key="activity.id"
        class="line"
        :style="{backgroundColor:activity.status.color,
                 width:calWidth(activity.created_at, activity.time_finish)+'%',
                 left:calLeft(activity.created_at)+'%'}"
      />
    </div>
    <div class="totalWork col-lg-2">
      <span>{{ totalWorkHours }}</span>
    </div>

  </div>
</template>
<script>
const moment = require('moment');
export default {
  props: {
    actHistory: {
      type: Array,
      require: true,
      default: () => [],
    },
  },
  data() {
    return {
      dateHistory: '',
      monthHistory: '',
      dayHistory: '',
      totalWorkHours: '',
      PercentHour: 100 / 13,
    };
  },

  created() {
    console.log('timeLineActHistory');
    console.log(this.actHistory);
    this.calDateHistory();
    this.calTotalWorkHours();
  },
  methods: {
    calDateHistory() {
      console.log('calDateHistory');
      // console.log(this.actHistory[0].time_finish);
      if (this.actHistory.length > 0) {
        this.dateHistory = moment(this.actHistory[0].time_finish).date();
        this.monthHistory = moment(this.actHistory[0].time_finish).format('M');
        const day = moment(this.actHistory[0].time_finish).day();
        console.log(day);
        switch (day) {
          case 1:
            this.dayHistory = 'userDetails.monday';
            break;
          case 2:
            this.dayHistory = 'userDetails.tuesday';
            break;
          case 3:
            this.dayHistory = 'userDetails.wednesday';
            break;
          case 4:
            this.dayHistory = 'userDetails.thursday';
            break;
          case 5:
            this.dayHistory = 'userDetails.friday';
            break;
          case 6:
            this.dayHistory = 'userDetails.saturday';
            break;
          default:
            this.dayHistory = 'userDetails.sunday';
        }
      }
    },
    calTotalWorkHours() {
      console.log('calTotalWorkHours');
      console.log(this.actHistory);
      let totalMinutes = 0;
      // for (let i = 0; i < this.actHistory.length; i++) {
      //   const startTime = moment(this.actHistory[i].created_at);
      //   const finishTime = moment(this.actHistory[i].time_finish);
      //   if (startTime.hour() >= 8 && finishTime.hour() <= 21) {
      //     const timeAct = finishTime.diff(startTime, 'minutes');
      //     const workHour = parseFloat(timeAct);
      //     totalMinutes += workHour;
      //   }
      // }
      for (let i = 0; i < this.actHistory.length; i++) {
        if (this.actHistory[i].status.type === 0) {
          const startTime = moment(this.actHistory[i].created_at);
          console.log(startTime);
          const finishTime = moment(this.actHistory[i].time_finish);
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
      console.log(totalMinutes);
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
      this.totalWorkHours = hours + ':' + minutes;
    },
    calWidth(start, finish) {
      console.log('----------------');
      const startTime = moment(start);
      const finishTime = moment(finish);
      const timeAct = finishTime.diff(startTime, 'seconds');
      console.log(timeAct);
      let actWidth = parseFloat(timeAct) / 3600 * this.PercentHour;
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
    .dateHistory {
        text-align: center;
    }
    .totalWork {
        text-align: center;
    }
    .actHistory {
        border-bottom: 2px solid #ADB1AD;
    }
.timeLineActHistory {
    padding: 10px 10px;
}
.line:hover .status {
    display: inline-block;
    z-index: 100;
}

.line {
    position: absolute;
}

.lineAct {
    height: 27px;
    position: relative;
}
.lineActivity {
    position: absolute;
    top: 35px;
    height: 10px;
    width: 100%;
}
.line {
    height: 27px;
    content: '';
    display: inline-block;
}
</style>
