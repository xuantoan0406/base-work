<template>
  <div class="Cell userCell">
    <div class="info" @click="clickUser">
      <img width="32" :src="' /imgs/user1.png'" style="margin:5px;height:32px;" class="img-circle">
      {{ user.name }}
    </div>

    <select
      v-if="date == nowDate && userLogin.role == 1"
      v-model="selected"
      class="col-md-12 control-label select"
      :style="[condition ? {backgroundColor : places[selected].color} : {backgroundColor: colorNow}]"
      @change="createworkplaceNew(user.id,places[selected].id)"
    >
      <option disabled value="">{{ workplaceNow }}</option>
      <option
        v-for="(place,index) in places"
        :key="index"
        :value="index"
        :style="{backgroundColor:place.color}"
      >
        <span class="dot" />
        {{ place.place }}
      </option>
    </select>
    <select
      v-else-if="date == nowDate && userLogin.id == user.id"
      v-model="selected"
      class="col-md-12 control-label select"
      :style="[condition ? {backgroundColor : places[selected].color} : {backgroundColor: colorNow}]"
      @change="createworkplaceNew(user.id,places[selected].id)"
    >
      <option disabled value="">{{ workplaceNow }}</option>
      <option
        v-for="(place,index) in places"
        :key="index"
        :value="index"
        :style="{backgroundColor:place.color}"
      >
        <span class="dot" />
        {{ place.place }}
      </option>
    </select>
    <span v-else />
  </div>
</template>

<script>
import EventBus from '../../app';
const moment = require('moment');
const CREATE_WORKPLACE_NEW = 'CREATE_WORKPLACE_NEW';
const SHOW_USER_HISTORY = 'SHOW_USER_HISTORY';

export default {
  CREATE_WORKPLACE_NEW: CREATE_WORKPLACE_NEW,
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
    userLogin: {
      type: Object,
      required: true,

    },
  },
  data() {
    return {
      places: [],
      selected: '',
      condition: false,
      nowDate: moment().format('YYYY-MM-DD'),
      colorNow: '',
      workplaceNow: '',
    };
  },

  created() {
    this.listplaces();
    console.log('cell info user');
    console.log(this.places);
    if (this.user.workplaceByDate[Object.keys(this.user.workplaceByDate)[Object.keys(this.user.workplaceByDate).length - 1]]) {
      this.colorNow = this.user.workplaceByDate[Object.keys(this.user.workplaceByDate)[Object.keys(this.user.workplaceByDate).length - 1]].place.color;
      this.workplaceNow = this.user.workplaceByDate[Object.keys(this.user.workplaceByDate)[Object.keys(this.user.workplaceByDate).length - 1 ]].place.place;
    }
  },
  methods: {

    listplaces() {
      this.$http.get('/api/getAllPlaces')
        .then(response => {
          this.places = response.data;
          console.log(this.places);
        })
        .catch(error => error.response.data);
    },

    clickUser: function() {
      console.log('clickUser');
      EventBus.$emit(SHOW_USER_HISTORY, this.user);
    },

    createworkplaceNew(userID, placeID) {
      this.$http.post('/api/workplace', { userID: userID, placeID: placeID })
        .then(response => {
          this.condition = true;
          console.log('createworkplaceNew done');
          EventBus.$emit(CREATE_WORKPLACE_NEW, this.user);
        })
        .catch(error =>
          error
        );
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
        overflow:hidden;
        width:220px;
    }

    .img-circle {
        border-radius: 50%;
    }
    .userCell {
        padding: 0px !important;
        float: left;
        width: 20%;
        height: 90px;
    }
    .dot {
        height: 25px;
        width: 25px;
        background-color: white;
        border-radius: 50%;
        display: inline-block;
    }

    .Cell
    {
        display: table-cell;
        border: solid;
        border-color: rgb(186, 194, 188);
        border-width: thin;
        padding-left: 10px;
        padding-right: 10px;
        padding-top: 10px;
    }
</style>
