<template>
  <div class="wrap-note">

    <!--        model confirm delete-->
    <div
      id="deleteNote"
      class="modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="deleteNote"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ $t('note.titleDelete') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ $t('setting.status.modalDelete.content') }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
              {{ $t('setting.status.modalDelete.disagree') }}
            </button>
            <button
              type="button"
              class="btn btn-primary"
              aria-hidden="true"
              @click="deleteNote(rowSelect,indexRowSelect)"
            >
              {{ $t('setting.status.modalDelete.agree') }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!--        modal edit-->

    <div
      id="editNote"
      class="modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="editNote"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ $t('note.titleEdit') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="returnData()">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body mx-3">
            <div class="md-form" style="margin-top: 10px;">
              <div class="col-form-label"> Title</div>
              <input v-model="rowSelect.title" type="text" class="form-control">
            </div>
            <div class="col-form-label">Content</div>
            <div class="md-form" style="margin-top: 10px;">
              <textarea
                v-model="rowSelect.content"
                name="paragraph_text"
                cols="41"
                rows="5"
                placeholder="Enter note content"
                class="form-control"
              />
            </div>
            <p v-if="errors">
              {{ errors }}
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="returnData()">
              {{ $t('setting.status.modalDelete.disagree') }}
            </button>
            <button
              type="button"
              class="btn btn-primary"
              aria-hidden="true"
              @click="editNote(rowSelect,indexRowSelect)"
            >
              {{ $t('setting.status.modalDelete.agree') }}
            </button>
          </div>
        </div>
      </div>
    </div>

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
      </div>
    </div>
    <div class="right">
      <div v-if="userSelect" class="note-wrap">

        <div v-for="(dataNote,dataNoteIndex) in note" :key="dataNoteIndex" class="dataApi">
          <div class="data">
            <div>{{ dataNote.title }}</div>
            <div>{{ dataNote.content }}</div>
          </div>
          <div class="info">
            <div v-if="nameUserLogin===userSelect.name" class="button">
              <button class="btn btn-success" data-toggle="modal" data-target="#editNote" @click="dataEdit(dataNote,dataNoteIndex)">編集</button>
              <button data-toggle="modal" data-target="#deleteNote" class="btn btn-danger" @click="dataDelete(dataNote,dataNoteIndex)">削除</button>
            </div>
            <div class="timeG">
              <div class="clock"><i class="far fa-clock" /> {{ dataNote.updated_at }}</div>
            </div>
            <div class="nameUser"><i class="fas fa-user" /> {{ userSelect.name }}</div>
          </div>
        </div>
      </div>

      <div v-else class="note-wrap">
        <div v-for="(dataNote,dataNoteIndex) in note" :key="dataNoteIndex" class="dataApi">
          <div class="data">
            <div>{{ dataNote.title }}</div>
            <div>{{ dataNote.content }}</div>
          </div>
          <div class="info">
            <div class="button">
              <button class="btn btn-success" data-toggle="modal" data-target="#editNote" @click="dataEdit(dataNote,dataNoteIndex)">編集</button>
              <button data-toggle="modal" data-target="#deleteNote" class="btn btn-danger" @click="dataDelete(dataNote,dataNoteIndex)">削除</button>
            </div>
            <div class="timeG">
              <div class="clock"><i class="far fa-clock" /> {{ dataNote.updated_at }}</div>
            </div>
            <div class="nameUser"><i class="fas fa-user" /> {{ nameUserLogin }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex';

export default {
  data() {
    return {
      note: [],
      listNote: [],

      calendarData: {},
      calendarConfigs: {
        sundayStart: true,
        dateFormat: 'dd-mm-yyyy',
        isDatePicker: true,
        isDateRange: false,
        markedDates: [],
        hiddenElements: ['leftAndRightDays'],

      },
      day: '',
      dayCount: '',
      daySelect: '',
      search: '',

      rowSelect: [],
      indexRowSelect: '',
      errors: '',

    };
  },
  computed: {
    ...mapState({
      userSelect: state => state.user.userSelect,
      idUserLogin: state => state.user.id,
      nameUserLogin: state => state.user.name,
    }),
  },
  created() {
    this.getDayOff();
    this.getNote();
  },

  methods: {
    editNote(rowSelect, indexRowSelect){
      console.log(rowSelect);
      this.$http.put('/api/notes/' + rowSelect.id, { title: rowSelect.title, content: rowSelect.content })
        .then(response => {
          const dataNote = response.data;
          this.note[indexRowSelect] = dataNote;
          console.log(response.data);
          this.rowSelect = [];
          this.indexRowSelect = '';
          $('#editNote').modal('hide');
        });
    },

    dataEdit(row, index){
      this.rowSelect = row;
      this.indexRowSelect = index;
    },

    deleteNote(rowSelect, indexRowSelect){
      this.$http.delete('/api/notes/' + rowSelect.id)
        .then(response => {
          this.note.splice(indexRowSelect, 1);
          this.rowSelect = [];
          this.indexRowSelect = '';
          $('#deleteNote').modal('hide');
        })
        .catch(error => error);
    },
    dataDelete(rowSelect, index){
      this.rowSelect = rowSelect;
      this.indexRowSelect = index;
    },
    returnData(){
      this.getListNote();
      console.log(this.daySelect);
    },

    getToday() {
      const today = new Date();
      this.daySelect = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
    },
    getNote() {
      this.getToday();
      this.getListNote();
    },

    getDayOff() {
      const today = new Date();
      const rangeSaturday = 7 - (today.getDay() + 1);
      const rangeSunday = 7 - today.getDay();
      const arrayMarked = [];
      for (let i = 0; i <= 4; i++) {
        const saturdayS = today.getDate() + rangeSaturday + 7 * i;
        const saturdayT = today.getDate() + rangeSaturday - 7 * (i + 1);
        if (saturdayS < 31) {
          const saturday = saturdayS + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
          arrayMarked.push(saturday);
        }
        if (saturdayT > 0) {
          const saturday = saturdayT + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
          arrayMarked.push(saturday);
        }
      }

      for (let i = 0; i <= 4; i++) {
        const sundayS = today.getDate() + rangeSunday + 7 * i;
        const sundayT = today.getDate() + rangeSunday - 7 * (i + 1);
        if (sundayS < 31) {
          const sunday = sundayS + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
          arrayMarked.push(sunday);
        }
        if (sundayT > 0) {
          const sunday = sundayT + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
          arrayMarked.push(sunday);
        }
      }

      this.calendarConfigs.markedDates = arrayMarked;

      console.log(this.calendarConfigs.markedDates);
    },
    dayClick(data) {
      this.daySelect = data.date;
      this.getListNote();
    },
    getTimeNote(data) {
      data.forEach(function callback(currentValue) {
        let time = new Date(currentValue.updated_at);
        time = time.getHours(time) + ':' + time.getMinutes(time);
        currentValue.updated_at = time;
      });
    },
    getListNote() {
      if (this.userSelect) {
        this.$http.post('/api/getNoteUserSelect', { userId: this.userSelect.id, daySelect: this.daySelect })
          .then(response => {
            const note = response.data;
            this.getTimeNote(note);
            this.note = note;
          });
      } else {
        this.$http.post('/api/getNoteUserSelect', { userId: this.idUserLogin, daySelect: this.daySelect })
          .then(response => {
            const note = response.data;
            this.getTimeNote(note);
            this.note = note;
          });
        console.log(this.note);
      }
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
                                    width: 90%;
                                    background-color: #efefef !important;
                                    border-radius: 0;
                                    color: black;
                                }
                            }
                            .vfc-top-date {
                                margin: 8px;
                            }

                            .vfc-today {
                                width: 90%;
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
            float: left;
            Display: Flex;
            flex-wrap: wrap;
            Justify-content: center;

            .note-wrap {
                width: 100%;
                height: auto;

                .dataApi {
                    width: 100%;
                    Display: Flex;
                    flex-wrap: wrap;
                    Justify-content: center;
                    background-color: #efefef;

                    .data {
                        overflow: auto;
                        width: 60%
                    }

                    .info {
                        margin-left: 2%;
                        Display: Flex;
                        Justify-content: center;
                        align-items: flex-end;
                        padding-bottom: 0.5%;

                        width: 35%;

                        .button {
                            .btn {
                                min-width: 75px;
                            }

                            width: 45%;
                        }

                        .timeG {
                            margin-left: 5%;
                            width: 25%;
                        }

                        .nameUser {
                            width: 30%;
                        }
                    }

                    margin-bottom: 2%;

                }

            }
        }
    }
</style>
