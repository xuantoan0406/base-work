<template>
  <div>
    <div class="pickDate">
      <div href="#" class="switch previous" @click="previousDate()">&laquo; {{ $t('index.previous') }}</div>
      <input id="today" v-model="date" type="date" name="date" class="date">
      <!--            <el-date-picker-->
      <!--                v-model="value"-->
      <!--                type="date"-->
      <!--                placeholder="Pick a day">-->
      <!--            </el-date-picker>-->
      <div href="#" class="switch next" @click="nextDate()">{{ $t('index.next') }} &raquo;</div>
    </div>

    <div class="day" :class="{ isActive: showDetail }">
      <div class="Table" :class="{ isActiveTable: showDetail }">
        <div class="Heading">
          <div class="Cell titleCol">
            <select
              v-model="selected"
              class="col-md-12 control-label select"
              @change="filterByStatus($event)"
            >
              <option value="">
                {{ $t('index.general') }}
              </option>
              <option value="order">
                {{ $t('index.nameOrder') }}
              </option>
              <option
                v-for="(status,index) in statuses"
                :key="index"
                :value="status.id"
              >
                {{ status.status }}
              </option>
            </select>
          </div>
          <div class="CellHour">
            <div v-for=" index in 13" :key="index" class="Cell">
              <p v-if="index < 3">0{{ index + 7 }}:00</p>
              <p v-else>{{ index + 7 }}:00</p>
            </div>
          </div>
        </div>

        <div v-for="user in users" :key="user.id" class="Row userRow">
          <CellUserCreateAct :user="user" :date="date" :statuses="statuses" />
          <div class="lineActivityRow">
            <div v-for="index in 13" :key="index" class="Cell cell-content">
              <p style="width: 45px" />
            </div>
            <TimelineActivity :user="user" :date="date" />
            <div
              v-if="date == nowDate"
              class="lineTimeNow "
              :style="{left: lineTimeNow +'%'}"
            />
          </div>
        </div>
      </div>
      <div v-if="numberPage > 1" class="overflow-auto">
        <paginate
          v-model="pageNum"
          :page-count="numberPage"
          :page-range="3"
          :margin-pages="2"
          :click-handler="clickCallback"
          :prev-text="'Prev'"
          :next-text="'Next'"
          :container-class="'pagination'"
          :page-class="'page-item'"
          :prev-class="'page-item'"
          :next-class="'page-item'"
          :page-link-class="'page-link-item'"
          :prev-link-class="'page-link-item'"
          :next-link-class="'page-link-item'"
          :active-class="'active-class'"
          :hide-prev-next="true"
        />
      </div>
    </div>

    <div v-if="showDetail" class="userDetail">
      <UserDetails :user="userSelect" :date="date" :statuses="statuses" />
    </div>

  </div>

</template>

<script>

import CellUserCreateAct from './CellUserCreateAct';
import TimelineActivity from './TimelineActivity';
import UserDetails from './UserDetails';
// const moment = require('moment-timezone');
// const moment = require('moment');
import moment from 'moment';
import 'moment-timezone';
moment.tz.setDefault('Asia/Tokyo');
// import DatePicker from 'vue2-datepicker'
import EventBus from '../../app';

export default {
  components: { CellUserCreateAct, TimelineActivity, UserDetails },
  data() {
    return {
      selected: '',
      users: [],
      date: moment().format('YYYY-MM-DD'),
      nowDate: moment().format('YYYY-MM-DD'),
      pageNumber: this.$route.params.pageNumber, // page so bao nhieu
      pageNum: Number(this.$route.params.pageNumber),
      numberPage: 1, // so trang
      onePage: 4,
      lineTimeNow: '',
      showDetail: false,
      userSelect: [],
      statuses: [],
    };
  },
  watch: {
    // ngay thay doi, goi lai danh sach user
    date() {
      this.listUsers();
    },

    users() {

    },
  },

  created() {
    this.listUsers();
    this.listStatuses();
    EventBus.$on(CellUserCreateAct.CREATE_ACTIVITY_NEW, user => {
      // console.log(`Oh, that's nice. It's gotten ${user.id} clicks! :)`)
      this.listUsers();
      this.nowDate = moment().format('YYYY-MM-DD');
    });

    // EventBus.$on(CellUserCreateAct.SHOW_USER_HISTORY, user => {
    //     console.log(`Oh1 that's nice. It's gotten ${user} clicks! :)`);
    //     this.userSelect = user;
    // });

    EventBus.$on(CellUserCreateAct.SHOW_USER_HISTORY, (user, isHidden) => {
      console.log(`Oh1 that's nice. It's gotten ${user} clicks! :)`);
      this.showDetail = isHidden;
      this.userSelect = user;

      console.log(this.showDetail);
    });

    this.CalLineTimeNow();
  },

  methods: {
    listStatuses() {
      this.$http.get('/api/statuses?type=10')
        .then(response => {
          this.statuses = response.data;
          console.log(this.statuses);
        })
        .catch(error => error.response.data);
    },

    clickCallback(pageNum) {
      this.$http.get('/api/getListUsersWithActivity?page=' + this.pageNum + '&date=' + this.date).then(response => {
        this.users = response.data.data;
      });
      this.pageNumber = pageNum;
      this.$router.push('/activity/' + pageNum);
    },

    listUsers() {
      this.$http.get('/api/getListUsersWithActivity?page=' + this.pageNum + '&date=' + this.date)
        .then(response => {
          console.log('listUsers');
          console.log(response);
          // var usersTemp = [],
          const usersTemp = response.data.data;
          console.log(usersTemp);
          if (this.date === this.nowDate){
            for (let i = 0; i < usersTemp.length; i++) {
              console.log('get-user');
              console.log(usersTemp[i].activityByDate);
              // update time_finish lastElement
              if (usersTemp[i].activityByDate) {
                let lastElement;
                for (lastElement in usersTemp[i].activityByDate) {
                  console.log();
                }
                if (usersTemp[i].activityByDate[lastElement].time_finish === usersTemp[i].activityByDate[lastElement].created_at){
                  usersTemp[i].activityByDate[lastElement].time_finish = moment().format('YYYY-MM-DD HH:mm:ss');
                  console.log(usersTemp[i].activityByDate[lastElement].time_finish);
                }
              }
            }
          }
          this.users = usersTemp;
          this.numberPage = response.data.last_page;
          console.log(this.numberPage);
        })
        .catch(error => error.response.data);
    },
    // filterByStatus
    filterByStatus(event) {
      console.log('filterByStatus');
      console.log(event.target.value);
      if (event.target.value === 'order'){
        this.$http.get('/api/getUsersOrderByName?page=' + this.pageNumber + '&date=' + this.date)
          .then(response => {
            console.log(response);
            // var usersTemp = [],
            const usersTemp = response.data.data;
            console.log(usersTemp);
            if (this.date === this.nowDate){
              for (let i = 0; i < usersTemp.length; i++) {
                console.log('get-user');
                console.log(usersTemp[i].activityByDate);
                // update time_finish lastElement
                if (usersTemp[i].activityByDate) {
                  let lastElement;
                  for (lastElement in usersTemp[i].activityByDate) {
                    console.log();
                  }

                  usersTemp[i].activityByDate[lastElement].time_finish = moment().format('YYYY-MM-DD HH:mm:ss');
                  console.log(usersTemp[i].activityByDate[lastElement].time_finish);
                }
              }
            }
            this.users = usersTemp;
            this.numberPage = response.data.last_page;
            console.log(this.numberPage);
          });
      } else if (event.target.value === ''){
        this.listUsers();
      } else {
        this.$http.get('/api/getListUserFilterByStatus?page=' + this.pageNum + '&date=' + this.date + '&status_id=' + event.target.value)
          .then(response => {
            console.log(response);
            // var usersTemp = [],
            const usersTemp = response.data.data;
            console.log(usersTemp);
            if (this.date === this.nowDate){
              for (let i = 0; i < usersTemp.length; i++) {
                console.log('get-user');
                console.log(usersTemp[i].activityByDate);
                // update time_finish lastElement
                if (usersTemp[i].activityByDate) {
                  let lastElement;
                  for (lastElement in usersTemp[i].activityByDate) {
                    console.log();
                  }

                  usersTemp[i].activityByDate[lastElement].time_finish = moment().format('YYYY-MM-DD HH:mm:ss');
                  console.log(usersTemp[i].activityByDate[lastElement].time_finish);
                }
              }
            }
            this.users = usersTemp;
            this.numberPage = response.data.last_page;
            console.log(this.numberPage);
          })
          .catch(error => error.response.data);
      }
    },
    // lineTimeNow
    CalLineTimeNow() {
      console.log('CalLineTimeNow');
      const percentCell = 100 / 13;
      console.log(percentCell);
      const nowTime = moment();
      console.log(nowTime);
      const originTime = moment('8:00:00', 'HH:mm:ss');
      console.log(originTime);
      const timeAct = nowTime.diff(originTime, 'minutes');
      console.log('timeLineNowTime');
      console.log(timeAct);
      let actWidth = parseFloat(timeAct) / 60 * percentCell;
      console.log(actWidth);
      if (actWidth < 0 || actWidth > 100) {
        actWidth = 0;
      }

      this.lineTimeNow = parseFloat(actWidth);
    },

    // date
    nextDate() {
      console.log('nextDate');
      const nextDate = moment(this.date).add(1, 'days').format('YYYY-MM-DD');
      console.log(nextDate);
      this.date = this.convert(nextDate);
      console.log(this.date);
      this.listUsers();
      // EventBus.$emit('NEXT_DATE','hello');
    },

    previousDate() {
      console.log('previousDate');
      const previousDate = moment(this.date).subtract(1, 'days').format('YYYY-MM-DD');

      console.log(previousDate);
      this.date = this.convert(previousDate);
      console.log(this.date);
      this.listUsers();
    },

    convert(str) {
      const date = new Date(str),
        month = ('0' + (date.getMonth() + 1)).slice(-2),
        day = ('0' + date.getDate()).slice(-2);
      return [date.getFullYear(), month, day].join('-');
    },
  },
};
</script>

<style lang="scss" scoped>
    /*option:hover{background-color:white;}*/
    /*select option:hover,*/
    /*select option:focus,*/
    /*select option:active {*/
    /*    background: linear-gradient(#000000, #000000);*/
    /*    background-color: #000000 !important; !* for IE *!*/
    /*}*/

    /*select:focus{*/
    /*    border-color: gray;*/
    /*    outline:none;*/
    /*}*/
/*.titleCol {*/
/*    select {*/
/*        option:hover{background-color:white;}*/
/*    }*/
/*}*/

    .CellHour {
        display: inline-block;
        position: relative;
        float: left;
        width: 87.7%;
    }

    .userDetail {
        margin: 0px 40px;
        background-color: #f2f5f2;
        height: 400px !important;
    }
    .isActive {
        height: 310px !important;
    }
    .isActiveTable {
        height: 200px !important;
    }
    .lineTimeNow {
        position: absolute;
        top: 0px;
        height: 100%;
        width: 1px;
        background-color: rgb(255, 0, 0);
    }
    .userRow {
        height: 90px;
        min-width: 1500px;
    }
    .cell-content {
        height: 90px;
    }
    .clearfix:before, .clearfix:after {
        clear: both;
        content: " ";
        display: table;
    }
    .lineActivityRow {
        display: inline-block;
        position: relative;
        height: 90px;
        float: left;
        width: 87.7%;
    }
    .date {
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

    .divDate {
        margin: auto;
        width: 15%;
    }

    .titleCol {
        float: left;
        width: 12% !important;
        min-width: 120px !important;
    }
    .day {
        padding: 40px 40px 0px 40px;
    }

    .Table
    {
        overflow-x: auto;
        height: 600px;
    }

    .titleCol {
        padding: 0px !important;
        select {
            height: 47px;
            option:hover{background-color:white;}
            background-color: #ADB1AD;
            border: none !important;
        }
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
        /*padding-left: 36px;*/
        /*padding-right: 36px;*/
        /*width: 122px;*/
        width: 7.692%;
        min-width: 100px;
        padding-top: 10px;
        p {
            margin-bottom: 10px;
        }
    }
    .mx-icon-calendar {
        width: 10px;
        height: 10px;
    }
    .content {
        /*top: 55px;*/
    }
    input[type="date"]::-webkit-calendar-picker-indicator {
        color: rgba(0, 0, 0, 0);
    }
    input:focus {
        border: none !important;
        outline: none !important;
    }

    /*responsive*/
    @media(max-width: 1440px) {
        .pickDate {
            /*margin: 20px 20px 0px;*/
        }
        .day {
            /*padding: 20px 20px;*/
        }
    }
    /*1024*/
    @media(max-width: 1024px) {}

    @media(max-width: 768px) {}

    @media(max-width: 768px) {}

</style>
