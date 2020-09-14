<template>
  <div class="wrap-note">
    <div class="left">
      <div class="search">
        <input v-model="search" class="form-control" type="text">
        <button class="btn btn-success" type="">Search</button>
      </div>
      <div class="singer-calender">
        <div class="full-calender">
          <FunctionalCalendar
            ref="Calendar"
            v-model="calendarData"
            :configs="calendarConfigs"
            @dayClicked="dayClick"
          />
        </div>
      </div>
      <div class="report-today">
        <div class="row-name">
          <div class="name-lable">ラベル名</div>

          <div class="button-add">
            <button class="btn btn-danger">add lable</button>
          </div>
        </div>

        <hr
          class="hr"
          noshade="noshade"
          width="80%"
        >

        <div class="row-name">
          <div class="name-lable">モノづくりmagazine</div>

          <div class="button-add">
            <button class="btn btn-danger"><i class="fas fa-bars" /></button>
          </div>
        </div>

        <hr
          class="hr1"
          noshade="noshade"
          width="80%"
        >
        <div class="row-name">
          <div class="name-lable">Knowledge Holder 関連</div>

          <div class="button-add">
            <button class="btn btn-danger"><i class="fas fa-bars" /></button>
          </div>
        </div>

        <hr
          class="hr1"
          noshade="noshade"
          width="80%"
        >
        <div class="row-name">
          <div class="name-lable">営業資料</div>

          <div class="button-add">
            <button class="btn btn-danger"><i class="fas fa-bars" /></button>
          </div>
        </div>

        <hr
          class="hr1"
          noshade="noshade"
          width="80%"
        >
        <div class="row-name">
          <div class="name-lable">name lable</div>

          <div class="button-add">
            <button class="btn btn-danger"><i class="fas fa-bars" /></button>
          </div>
        </div>

        <hr
          class="hr1"
          noshade="noshade"
          width="80%"
        >
        <div>
          <select v-model="userSelect" class="select-user">
            <option value="User1" selected>観覧対象のユーザ選択</option>
            <option value="User2">User2</option>
            <option value="User3">User3</option>
            <option value="User4">User4</option>
          </select>
        </div>
      </div>
    </div>
    <div id="my-style" class="right">
      <div class="report">
        <div class="header-report">レポート : {{ yesterday }}</div>
        <hr noshade="noshade" width="95%">

        <div v-for="(prod,FileIndex) in fileReport " :key="FileIndex" class="body-report">
          <div class="file-report">{{ prod }}</div>
          <div class="button">
            <button class="btn btn-success">Preview</button>
            <button class="btn btn-primary">DowLoad</button>
            <button class="btn btn-danger">Delete</button>
          </div>
          <div class="information">
            <div class="clock"><i class="far fa-clock" /> {{ viewTime() }}</div>
            <div class="user"><i class="fas fa-user" /> nareji</div>
          </div>
          <div class="hr-report">
            ................................................................................
            .........................................................................................................
            ................................................................................
          </div>
        </div>
        <div class="mid-white" />
      </div>

      <div class="report">
        <div class="header-report">レポート : {{ beforeYesterday }} </div>
        <hr noshade="noshade" width="95%">

        <div v-for="(prod,indexReport) in fileReport" :key="indexReport" class="body-report">
          <div class="file-report">{{ prod }}</div>
          <div class="button">
            <button class="btn btn-success">Preview</button>
            <button class="btn btn-primary">DowLoad</button>
            <button class="btn btn-danger">Delete</button>
          </div>
          <div class="information">
            <div class="clock"><i class="far fa-clock" /> {{ viewTime() }}</div>
            <div class="user"><i class="fas fa-user" /> nareji</div>
          </div>
          <div class="hr-report">
            .............................................................................
            ............................................................................................................
            ................................................................................
          </div>
        </div>
      </div>

    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {

      fileReport: [
        'DESKTOP/C:/User/AAAAA/BBBBB/CCCCC.docx',
        'DESKTOP/C:/User/AAAAA/BBBBB/CCCCC.docx\n',
        'DESKTOP/C:/User/AAAAA/BBBBB/CCCCC.docx\n',
        'DESKTOP/C:/User/AAAAA/BBBBB/CCCCC.docx\n',
      ],

      calendarData: {},
      calendarConfigs: {
        sundayStart: true,
        dateFormat: 'dd/mm/yyyy',
        isDatePicker: true,
        isDateRange: false,
        markedDates: [],
        hiddenElements: ['leftAndRightDays'],

      },
      day: '',

      dayCount: '',
      daySelect: '',
      userSelect: 'User1',
      search: '',
      yesterday: '',
      beforeYesterday: '',

    };
  },
  created() {
    this.viewTime();
    this.time();
    this.getDayOff();
  },
  methods: {
    time() {
      const today = new Date();
      this.yesterday = today.getFullYear() + '.' + (today.getMonth() + 1) + '.' + (today.getDate() - 1);
      this.beforeYesterday = today.getFullYear() + '.' + (today.getMonth() + 1) + '.' + (today.getDate() - 2);
      console.log(this.beforeYesterday);
    },

    getDayOff(){
      const today = new Date();
      const rangeSaturday = 7 - (today.getDay() + 1);
      const rangeSunday = 7 - today.getDay();
      const arrayMarked = [];
      for (let i = 0; i <= 4; i++){
        const saturdayS = today.getDate() + rangeSaturday + 7 * i;
        const saturdayT = today.getDate() + rangeSaturday - 7 * (i + 1);
        if (saturdayS < 31){
          const saturday = saturdayS + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();
          arrayMarked.push(saturday);
        }
        if (saturdayT > 0){
          const saturday = saturdayT + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();
          arrayMarked.push(saturday);
        }
      }

      for (let i = 0; i <= 4; i++){
        const sundayS = today.getDate() + rangeSunday + 7 * i;
        const sundayT = today.getDate() + rangeSunday - 7 * (i + 1);
        if (sundayS < 31){
          const sunday = sundayS + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();
          arrayMarked.push(sunday);
        }
        if (sundayT > 0){
          const sunday = sundayT + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();
          arrayMarked.push(sunday);
        }
      }
      this.calendarConfigs.markedDates = arrayMarked;

      console.log(this.calendarConfigs.markedDates);
    },

    dayClick(m) {
      console.log(m);
    },
    viewTime() {
      var date = new Date();
      var timeToday = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });
      return timeToday;
    },
  },
};
</script>
<style lang="scss">
    .wrap-note {
        width: 100%;
        height: auto;

        .left {
            float: left;
            width: 33%;
            margin-top: 2%;
            height: 85vh;

            .search {
                margin-left: 8%;

                .form-control {
                    float: left;
                    width: 54%;
                    float: left;
                    margin-top: 2%;
                }

                .btn-success {
                    margin-left: 4%;
                    float: left;
                    margin-top: 2%;
                    background-color: #FF9800;
                    border-color: #FF9800;
                }
            }

            .singer-calender {
                width: 90%;
                float: left;
                margin-top: 4%;
                padding-left: 15%;

                .full-calender {
                    width: 85%;

                    .vfc-main-container {
                        .vfc-space-between {
                            height: 52px;
                            background-color: #fee67a;

                            .vfc-cursor-pointer {
                                margin-top: 29px;
                            }
                        }
                    }

                    .vfc-calendar {
                        .vfc-content {
                            .vfc-week {

                                .vfc-day {
                                    margin: 0;
                                }

                                .vfc-base-start {
                                    background-color: #efefef;
                                }

                                .vfc-marked {
                                    width: 100%;
                                    background-color: #efefef !important;
                                    border-radius: 0;
                                    color: black;
                                }
                            }

                            .vfc-top-date {
                                margin: 8px;
                            }

                            .vfc-today {
                                background-color: #fee67a;
                                color: #1d2124;
                                border-radius: 0;
                            }

                            width: 100%;
                            margin: 0;

                            .vfc-dayNames {
                                margin-bottom: 0;

                                .vfc-day {
                                    background-color: #5a6268;
                                    margin: 0 2px 0 0;
                                    color: white;
                                }

                            }
                        }
                    }
                }
            }

            .report-today {
                margin-left: 8%;

                .select-user {
                    height: 35px;
                    width: 80%;
                    margin-left: 8%;
                    margin-top: 4%
                }

                .hr1 {
                    margin-top: 12%;
                    margin-left: 8%;
                }

                .hr {
                    margin-top: 9%;
                    margin-left: 8%;
                }

                padding-top: 4%;
                height: auto;
                margin-top: 4%;
                float: left;
                width: 80%;

                .row-name {
                    .name-lable {
                        float: left;
                        margin-top: 2%;
                        margin-left: 8%;
                    }

                    .button-add {
                        float: right;
                        margin-right: 12%;

                        .btn {
                            background-color: #fee67a;
                            border-color: #FF9800;
                            border: none;
                            color: #1b1e21;
                        }
                    }
                }
            }
        }

        .right {
            margin-top: 2.5%;
            width: 63%;
            height: 80vh;
            overflow: auto;

            .webkit-scrollbar {
                width: 50px;
                background-color: black;
            }

            float: left;

            .report {
                .mid-white {
                    height: 20px;
                    float: left;
                    width: 100%;
                    background-color: white;
                }

                width: 95%;
                background-color: #efefef;
                float: left;

                .header-report {
                    margin-left: 2%;
                    margin-top: 1%;
                    font-size: 30px
                }

                .file-report {
                    margin-left: 2%;
                    float: left;
                }

                .button {
                    margin-left: 15%;
                    float: left;
                }

                .hr-report {
                    float: left;

                    margin-left: 2%;
                    margin-bottom: 1%;
                }

                .information {
                    width: 20%;
                    float: left;
                    margin-left: 2%;

                    .clock {
                        float: left;
                        margin-left: 10px;
                    }

                    .user {
                        width: 50%;
                        float: right;
                        margin-right: 5px;

                        .fa-user {
                            color: orange;
                        }
                    }
                }
            }
        }
    }

    #my-style::-webkit-scrollbar {
        width: 20px;
    }

    #my-style::-webkit-scrollbar-thumb {
        border-radius: 20px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 15);
        background-color: #efefef;
    }

    #my-style::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 1px rgba(0, 0, 0, 0.3);
        border-radius: 20px;
        background-color: snow;
    }
</style>
