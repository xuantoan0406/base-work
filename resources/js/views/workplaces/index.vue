<template>
  <div id="">
    <div class="pickDate">
      <div href="#" class="switch previous" @click="previousDate()">&laquo; Previous</div>
      <input id="today" v-model="date" type="date" name="date" class="date">
      <div href="#" class="switch next" @click="nextDate()">Next &raquo;</div>
    </div>

    <div class="day">
      <div class="Table">
        <div class="Heading">
          <div class="Cell titleColum">
            <p style="width: 200px">全体</p>
          </div>
          <div class="Cell">
            <p>08:00</p>
          </div>
          <div class="Cell">
            <p>09:00</p>
          </div>
          <div v-for=" index in 11" :key="index" class="Cell">
            <p>{{ index + 9 }}:00</p>
          </div>
        </div>
        <div class="Center">
          <div v-for="user in users" :key="user.id" class="Row userRow">
            <CellUserCreateWorkplace :user="user" :date="date" :user-login="userLogin" />
            <div class="lineWorkplaceRow">
              <div v-for="index in 13" :key="index" class="Cell cell-content">
                <p style="width: 45px" />
              </div>
              <TimelineWorkplace :user="user" :date="date" />
              <div
                v-if="date == nowDate"
                class="lineTimeNow "
                :style="{left: lineTimeNow +'%'}"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="overflow-auto">
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

  </div>

</template>

<script>

import CellUserCreateWorkplace from './CellUserCreateWorkplace';
import TimelineWorkplace from './TimelineWorkplace';
const moment = require('moment');
// import DatePicker from 'vue2-datepicker'
import EventBus from '../../app';

export default {
  components: { CellUserCreateWorkplace, TimelineWorkplace },
  data() {
    return {
      users: [],
      date: moment().format('YYYY-MM-DD'),
      nowDate: moment().format('YYYY-MM-DD'),
      pageNumber: this.$route.params.pageNumber, // page so bao nhieu
      pageNum: Number(this.$route.params.pageNumber),
      numberPage: 1, // so trang
      onePage: 4,
      userLogin: Object,
      lineTimeNow: '',
      showDetail: false,
      userSelect: [],
    };
  },
  watch: {
    // ngay thay doi, goi lai danh sach user
    date() {
      this.listUsers();
    },

    // users() {
    //
    // },
  },

  created() {
    this.listUsers();

    this.$http.get('/api/auth/user')
      .then(res => {
        this.userLogin = res.data.data;
      });
    EventBus.$on(CellUserCreateWorkplace.CREATE_WORKPLACE_NEW, user => {
      console.log(`Oh, that's nice. It's gotten ${user.id} clicks! :)`);
      this.listUsers();
      this.nowDate = moment().format('YYYY-MM-DD');
    });

    EventBus.$on(CellUserCreateWorkplace.SHOW_USER_HISTORY, user => {
      console.log(`Oh1 that's nice. It's gotten ${user.id} clicks! :)`);
      this.showDetail = true;
      this.userSelect = user;
    });

    this.CalLineTimeNow();
  },

  methods: {

    clickCallback(pageNum) {
      this.$http.get('/api/getListUsersWithWorkplaces?page=' + this.pageNum + '&date=' + this.date).then(response => {
        this.users = response.data.data;
      });
      this.pageNumber = pageNum;
      this.$router.push('/workplaces/' + pageNum);
    },

    listUsers() {
      this.$http.get('/api/getListUsersWithWorkplaces?page=' + this.pageNum + '&date=' + this.date)
        .then(response => {
          console.log(response);
          this.users = response.data.data;
          if (this.date === this.nowDate){
            for (let i = 0; i < this.users.length; i++) {
              console.log('get-user');
              if (this.users[i].workplaceByDate){
                console.log(this.users[i].workplaceByDate);
                // update time_finish lastElement
                let lastElement;
                for (lastElement in this.users[i].workplaceByDate){
                  console.log();
                }
                this.users[i].workplaceByDate[lastElement].time_finish = moment().format('YYYY-MM-DD HH:mm:ss');
              }
            }
          }
          this.numberPage = response.data.last_page;
        })
        .catch(error => error.response.data);
    },
    // lineTimeNow
    CalLineTimeNow() {
      const cellPixel = 100 / 13;
      console.log(cellPixel);
      const percentCell = 100 / 13;
      console.log(percentCell);
      const nowTime = moment();
      console.log(nowTime);
      const originTime = moment('8:00:00', 'HH:mm:ss');
      console.log(originTime);
      const timePlace = nowTime.diff(originTime, 'minutes');
      console.log('timeLineNowTime');
      console.log(timePlace);
      let placeWidth = parseFloat(timePlace) / 60 * percentCell;
      if (placeWidth < 0 || placeWidth > 100) {
        placeWidth = 0;
      }
      this.lineTimeNow = parseFloat(placeWidth);
    },

    // date
    nextDate() {
      const nextDate = moment(this.date).add(1, 'd');
      this.date = this.convert(nextDate);
      this.listUsers();
      // EventBus.$emit('NEXT_DATE','hello');
    },

    previousDate() {
      const previousDate = moment(this.date).subtract(1, 'd');
      this.date = this.convert(previousDate);
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
    .Center {
        /*position: absolute;*/
        /*top: 55px;*/
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
    }
    .cell-content {
        height: 90px;
    }
    .clearfix:before, .clearfix:after {
        clear: both;
        content: " ";
        display: table;
    }
    .lineWorkplaceRow {
        display: inline-block;
        position: relative;
        height: 90px;
        float: left;
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

    .titleColum {
        float: left;
        width: 20%;
    }
    .day {
        padding: 40px 80px;
    }

    .Table
    {
        overflow-x: scroll;
        height: 450px;
        position: relative;
    }

    .Heading
    {
        /*display: initial;*/
        /*position: fixed;*/
        z-index: 10;
        /*background-color: #E5E8E5;*/
        font-weight: bold;
        text-align: center;
    }
    .Cell
    {
        display: table-cell;
        border: solid;
        border-color: rgb(186, 194, 188);
        border-width: thin;
        padding-left: 25px;
        padding-right: 25px;
        padding-top: 10px;
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
