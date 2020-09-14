<template>
  <div class="Cell userCell">
    <div class="info" @click="isHidden = !isHidden">
      <div @click="clickUser">
        <img
          v-if="user.avatar===null"
          width="32"
          :src="' /imgs/user2.png'"
          style="margin:5px;height:32px;"
          class="img-circle"
        >
        <img
          v-else
          width="32"
          :src="`/imgs/avatarUser/${user.avatar}`"
          style="margin:5px;height:32px;"
          class="img-circle"
        >
        {{ user.name }}
      </div>
    </div>

    <select
      v-if="date == nowDate && userRole == 1"
      v-model="selected"
      class="col-md-12 control-label select"
      :style="[condition ? {backgroundColor : statusesSelectedColor(selected) } : {backgroundColor: colorNow}]"
      @change="createActivityNew(user.id,selected,$event)"
    >
      <option disabled value="">
        <div class="dot" />
        {{ activityNow }}
      </option>
      <option value="endWork" style="background-color: #ADB1AD;">
        {{ $t('index.endOfWork') }}
      </option>
      <option
        v-for="(status,index) in statuses"
        :key="index"
        :value="status.id"
        :style="{backgroundColor:status.color}"
      >
        <div class="dot" />
        {{ status.status }}
      </option>
    </select>
    <select
      v-else-if="date == nowDate && userId == user.id"
      v-model="selected"
      class="col-md-12 control-label select"
      :style="[condition ? {backgroundColor : statusesSelectedColor(selected) } : {backgroundColor: colorNow}]"
      @change="createActivityNew(user.id,selected, $event)"
    >
      <option disabled value="">
        <div class="dot" />
        {{ activityNow }}
      </option>
      <option value="endWork" style="background-color: #ADB1AD;">
        {{ $t('index.endOfWork') }}
      </option>
      <option
        v-for="(status,index) in statuses"
        :key="index"
        :value="status.id"
        :style="{backgroundColor:status.color}"
      >
        <div class="dot" />
        {{ status.status }}
      </option>
    </select>
    <span v-else />
  </div>
</template>

<script>
import EventBus from '../../app';
import moment from 'moment';
import 'moment-timezone';
moment.tz.setDefault('Asia/Tokyo');
// import moment from 'moment-timezone/moment-timezone';
const CREATE_ACTIVITY_NEW = 'CREATE_ACTIVITY_NEW';
const SHOW_USER_HISTORY = 'SHOW_USER_HISTORY';
import { mapState } from 'vuex';
export default {
  CREATE_ACTIVITY_NEW: CREATE_ACTIVITY_NEW,
  SHOW_USER_HISTORY: SHOW_USER_HISTORY,
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
      isHidden: true,
      colorNow: '',
      activityNow: '',
    };
  },
  computed: {
    ...mapState({
      userId: state => state.user.id,
      userRole: state => state.user.role,
    }),
  },
  created() {
    console.log('cell info user');
    if (this.user.activityByDate[Object.keys(this.user.activityByDate)[Object.keys(this.user.activityByDate).length - 1]]){
      if (this.user.activityByDate[Object.keys(this.user.activityByDate)[Object.keys(this.user.activityByDate).length - 1]].time_finish === moment().format('YYYY-MM-DD HH:mm:ss')){
        this.colorNow = this.user.activityByDate[Object.keys(this.user.activityByDate)[Object.keys(this.user.activityByDate).length - 1]].status.color;
        this.activityNow = this.user.activityByDate[Object.keys(this.user.activityByDate)[Object.keys(this.user.activityByDate).length - 1 ]].status.status;
      }
    }
  },
  methods: {
    clickUser: function() {
      console.log('clickUser');
      EventBus.$emit(SHOW_USER_HISTORY, this.user, this.isHidden);
    },

    statusesSelectedColor(idStatus){
      console.log('statusesSelectedColor');
      console.log(idStatus);
      let statusesSelectedColor = '';
      if (idStatus === 'endWork'){
        statusesSelectedColor = '#ADB1AD';
      } else {
        for (let i = 0; i < this.statuses.length; i++) {
          if (this.statuses[i].id === idStatus) {
            statusesSelectedColor = this.statuses[i].color;
          }
        }
      }
      console.log(statusesSelectedColor);
      return statusesSelectedColor;
    },

    createActivityNew(userID, statusID, event) {
      console.log('createActivityNew');
      console.log(event.target.value);
      if (event.target.value === 'endWork'){
        this.$http.post('/api/endActivity', { userID: userID })
          .then(response => {
            this.condition = true;
          })
          .catch(error => error);
      } else {
        // console.log(statusID);
        // console.log(userID);
        this.$http.post('/api/activity', { userID: userID, statusID: statusID })
          .then(response => {
            this.condition = true;
            // console.log(response.data);
            console.log('createActivityNew done');
            // console.log(this.user.activityByDate);
            // let act = response.data;
            // console.log(act);
            // this.user.activityByDate[act.id] = act;
            EventBus.$emit(CREATE_ACTIVITY_NEW, this.user);
          })
          .catch(error =>
            error
          );
      }
    },
  },

};
</script>

<style lang="scss" scoped>
    .info {
        width: 220px;
        margin: 10px 0px;
    }

    .select {
        border-color: rgb(186, 194, 188);
        color: white;
    }

    .email {
        overflow: hidden;
        width: 220px;
    }

    .img-circle {
        border-radius: 50%;
    }

    .userCell {
        padding: 0px !important;
        float: left;
        width: 12% !important;
        min-width: 120px !important;
        height: 90px;
    }

    /*.dot {*/
    /*    height: 25px;*/
    /*    width: 25px;*/
    /*    background-color: white;*/
    /*    border-radius: 50%;*/
    /*    display: inline-block;*/
    /*}*/
    .dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        background: white;
        border-radius: 50%
    }

    /*.dot:before {*/
    /*    content: ' \25CF';*/
    /*    font-size: 200px;*/
    /*}*/

    .Cell {
        display: table-cell;
        border: solid;
        border-color: rgb(186, 194, 188);
        border-width: thin;
        padding-left: 10px;
        padding-right: 10px;
        padding-top: 10px;
    }
</style>
