<template>
  <div>
    <div class="pickDate">
      <div href="#" class="switch previous" @click="previousMonth()">&laquo; {{ $t('index.previous') }}</div>
      <div class="monthName">
        <p>{{ month }}</p>
      </div>
      <div href="#" class="switch next" @click="nextMonth()">{{ $t('index.next') }} &raquo;</div>
    </div>
    <div class="ActMonth">
      <div class="Table">
        <div class="Heading">
          <div class="Cell titleCol" />
          <div class="CellHour">
            <div v-for=" index in 13" :key="index" class="Cell">
              <p v-if="index < 3">0{{ index + 7 }}:00</p>
              <p v-else>{{ index + 7 }}:00</p>
            </div>
          </div>
        </div>
        <div v-for="actInDay in actInMonth" :key="actInDay.id" class="Row ActDay">
          <div class="Cell Dayname">
            <p>{{ FormatDate(actInDay.date) }} {{ $t(FormatDay(actInDay.date)) }}</p>
          </div>
          <div class="lineActivityRow">
            <div v-for="index in 13" :key="index" class="Cell cell-content">
              <p style="width: 45px" />
            </div>
            <TimelineActivity :user="actInDay" :date="actInDay.date" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment';
import 'moment-timezone';
moment.tz.setDefault('Asia/Tokyo');
import TimelineActivity from './TimelineActivity';
export default {
  components: { TimelineActivity },
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      month: moment().format('YYYY/MM'),
      actInMonth: [],
    };
  },

  created() {
    this.getActOfMonth();
  },

  methods: {
    getActOfMonth() {
      this.$http.get('/api/getActOfMonth/?user_id=' + this.user.id + '&month=' + moment(this.month).format('YYYY-MM'))
        .then(response => {
          console.log(response);
          this.actInMonth = response.data;
        });
    },

    FormatDate(date){
      console.log('FormatDate');
      const dateHistory = moment(date).format('YYYY/MM/DD/');
      return dateHistory;
    },

    FormatDay(date){
      const day = moment(date).day();
      console.log(day);
      let dayHistory = '';
      switch (day) {
        case 1:
          dayHistory = 'userDetails.monday';
          break;
        case 2:
          dayHistory = 'userDetails.tuesday';
          break;
        case 3:
          dayHistory = 'userDetails.wednesday';
          break;
        case 4:
          dayHistory = 'userDetails.thursday';
          break;
        case 5:
          dayHistory = 'userDetails.friday';
          break;
        case 6:
          dayHistory = 'userDetails.saturday';
          break;
        default:
          dayHistory = 'userDetails.sunday';
      }
      return dayHistory;
    },

    previousMonth() {
      console.log('previousMonth');
      const previousMonth = moment(this.month).subtract(1, 'months').format('YYYY/MM');
      console.log(previousMonth);
      this.month = previousMonth;
      this.getActOfMonth();
    },
    nextMonth() {
      console.log('nextMonth');
      const nextMonth = moment(this.month).add(1, 'months').format('YYYY/MM');
      console.log(nextMonth);
      this.month = nextMonth;
      this.getActOfMonth();
    },
  },
};
</script>

<style lang="scss" scoped>
    .Dayname {
        p {
            text-align: center;
            padding-top: 30px;
            padding-bottom: 30px;
        }
    }
    .cell-content {
        height: 90px;
    }
    .Dayname {
        padding: 0px !important;
        float: left;
        width: 12% !important;
        min-width: 120px !important;
        height: 90px;
    }
    .pickDate {
        margin: 30px 80px 0px;
        border-bottom: 2px solid rgb(173, 177, 173);
        position: relative;
    }

    .switch:hover {
        background-color: #ddd;
        color: black;
    }
    .switch {
        background-color: rgb(229, 232, 229);
        color: black;
        text-decoration: none;
        display: inline-block;
        padding: 8px 16px;
    }

    .previous {
        border-radius: 0px 20px 0px 0px;
    }

    .next {
        float: right;
        border-radius: 20px 0px 0px 0px;
    }

    .monthName {
        width: 25%;
        text-align: center;
        left: 40%;
        bottom: 1%;
        position: absolute;
        border: none;
        border-radius: 20px 20px 0px 0px;
        background: rgb(247, 198, 60);
        height: 43px;
        padding-right: 30px;
        padding-left: 30px;
        color: rgb(255, 255, 255);
        font-weight: bold;
        font-size: 24px;
    }

    .lineActivityRow {
        display: inline-block;
        position: relative;
        height: 90px;
        float: left;
        width: 87.7%;
    }
    .ActMonth {
        padding: 40px 40px 30px 40px;
    }

    .Table
    {
        overflow-x: auto;
        height: 650px;
    }

    .Heading
    {
        /*position: fixed;*/
        font-weight: bold;
        text-align: center;
        height: 49px;
        min-width: 1500px;
    }
    .Cell
    {
        display: inline-block;
        border: solid;
        border-color: rgb(186, 194, 188);
        border-width: thin;
        width: 7.692%;
        min-width: 100px;
        padding-top: 10px;
        p {
            margin-bottom: 10px;
        }
    }

    .titleCol {
        float: left;
        width: 12% !important;
        min-width: 120px !important;
        padding: 0px !important;
        height: 49px;
    }

    .CellHour {
        display: inline-block;
        position: relative;
        float: left;
        width: 87.7%;
    }
</style>
