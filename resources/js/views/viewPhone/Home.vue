<template>
  <div class="home-moblie">
    <div class="infor">
      <div class="avatar"><img src="/imgs/avatarUser.png" class="img" alt=""></div>
      <div class="infor-user">
        <div class="logout">
          <button type="button" class="btn-logout" @click="handleLogout">{{ $t('navBar.logOut') }}</button>
        </div>

        <div class="nameUser">{{ nameUser }}</div>
        <div>
          ビジネス / 金融会社
        </div>
      </div>

    </div>
    <div class="time">
      <div><img src="/imgs/time.png" alt="t"></div>
      <div class="time-view">{{ viewTime() }}</div>
    </div>
    <div class="activity">
      <div class="statuses">
        <button
          v-for="(prod,index) in arrayStatus"
          :key="index"
          class="buttonSelect"
          :style="{
            width: '170px',height: '75px',backgroundColor:prod.color,}"
          :keys="arrayStatus.id"
          @click="selectColor(index)"
        >
          {{ prod.status }}
        </button>
      </div>
      <div v-if="numberPage>=2" class="overflow-auto">
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
    <div class="footer">
      <img class="footer-img" src="/imgs/logo.png" alt="">
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'HomeVue',
  data() {
    return {

      colorOrigin: '',
      idSelectOld: null,
      idSelectNew: null,
      colorSelectNew: '',
      colorSelectOld: '',
      colorComplete: '#6c757d',
      status_id: 1,

      arrayStatusFull: [],
      numberPage: 1,

      arrayStatus: [],
      pageNumber: this.$route.params.pageNumber, // page so bao nhieu
      pageNum: Number(this.$route.params.pageNumber),
    };
  },
  computed: {
    ...mapState({
      userId: state => state.user.id,
      nameUser: state => state.user.email,
      domainId: state => state.user.domain_id,
    }),
  },
  mounted() {
    this.viewTime();
    this.listStatus();
  },

  methods: {
    listStatus() {
      this.$http.get('/api/statuses/' + this.domainId + '?page=' + this.pageNum)
        .then(response => {
          this.arrayStatusFull = response.data;
          this.arrayStatus = this.arrayStatusFull.data;
          this.numberPage = this.arrayStatusFull.last_page;
          console.log(this.arrayStatusFull);
        })
        .catch(error => error.response.data);
    },

    viewTime() {
      var date = new Date();
      var timeToday = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });
      return timeToday;
    },

    handleLogout() {
      this.$store.dispatch('user/logout').then(() => {
        this.$router.push(`/login?redirect=${this.$route.fullPath}`);
      });
    },

    clickCallback(pageNum) {
      this.$http.get('/api/statuses/' + this.domainId + '?page=' + pageNum).then(response => {
        this.arrayStatusFull = response.data;
        this.arrayStatus = this.arrayStatusFull.data;
      });
      this.pageNumber = pageNum;
      this.$router.push('/home/' + pageNum);
    },

    selectColor(index) {
      if (this.idSelectOld === null) {
        this.idSelectOld = index;
      } else {
        this.idSelectOld = this.idSelectNew;
      }
      this.idSelectNew = index;
      if (this.idSelectOld === this.idSelectNew) {
        if (this.colorSelectNew === '') {
          this.colorSelectNew = this.arrayStatus[index].color;
          this.colorSelectOld = this.arrayStatus[index].color;
          this.arrayStatus[index].color = this.colorComplete;
        } else {
          this.arrayStatus[index].color = this.colorComplete;
        }
      } else {
        this.colorSelectOld = this.colorSelectNew;
        this.colorSelectNew = this.arrayStatus[index].color;
        this.arrayStatus[index].color = this.colorComplete;
        this.arrayStatus[this.idSelectOld].color = this.colorSelectOld;
      }

      this.status_id = this.arrayStatus[index].id;
      this.$http.post('/api/activity', { userID: this.userId, statusID: this.status_id })
        .then(response => {
          console.log(response.data);
        })
        .catch(error => error);
    },
  },
};
</script>

<style lang="scss" scoped>
    .home-moblie {
        background-color: #fee67a;
        height: 100vh;

        .infor {
            display: flex;
            justify-content: center;

            .avatar {
                width: 50%;

                .img {
                    margin-left: 8%;
                    margin-top: 10%;
                    max-width: 140px;
                    max-height: 160px;
                }
            }

            .infor-user {
                width: 50%;
                display: flex;
                justify-content: center;
                flex-wrap: wrap;

                .logout {
                    .btn-logout {
                        width: 80%;
                        background-color: #ffb328e8;
                        border-color: #ffb328e8
                    }

                    text-align: center;
                    margin-top: 10%;
                    width: 60%;
                }

                .nameUser {
                    text-align: center;
                    width: 80%;
                }

            }
        }

        .time {
            margin-top: 2%;
            display: flex;
            justify-content: center;
        }

        .activity {
            min-height: 64%;

            .statuses {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;

                .buttonSelect {
                    backgroud-color: #fee67a;
                    height: 60%;
                    margin-top: 2%;
                    margin-left: 2%
                }
            }

            .overflow-auto {
                Align-items: flex-start;
            }
        }

        .footer {
            width: 100%;
            margin-bottom: 2%;

            .footer-img {
                width: 100%;
            }
        }
    }

</style>
