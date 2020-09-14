<template>
  <div class="content-setting">

    <div id="exampleModal" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Save Information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ message }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="head-ps">{{ $t('setting.settingPersonal.title') }}</div>
    <div class="content-ps">
      <div class="up-avt">
        <div class="avt">
          <label class="btn1">
            <img
              v-if="imgAvatar===null && newAvatar==='' "
              :src="' /imgs/user2.png'"
              alt="noAvatar"
              width="100%"
              height="100%"
              class="avatar1"
            >
            <img v-else-if="imgAvatar===null && newAvatar" class="avatar1" :src="newAvatar" alt="">
            <img
              v-else-if="imgAvatar && newAvatar==='' "
              class="avatar1"
              :src="`/imgs/avatarUser/${imgAvatar}`"
              alt="avatar"
              width="100%"
              height="100%"
            >
            <img v-else class="avatar1" :src="newAvatar" alt="">
            <i class="fas fa-camera" />

            <input
              type="file"
              style="display: none;"
              @change="handleUploadFile"
            >
          </label>
        </div>

      </div>
    </div>
    <div class="form-group">
      <label for="name" class="lb">{{ $t('setting.settingPersonal.name') }}</label>
      <input
        id="name"
        v-model="informationUser.name"
        type="text"
        class="form-control"
        placeholder="Enter Name"
        required
      >
      <label for="wt" class="lb">{{ $t('setting.settingPersonal.workType') }}</label>
      <input
        id="wt"
        v-model="informationUser.industry"
        type="text"
        class="form-control"
        placeholder="Enter Work Type"
        required
      >
      <label for="wp" class="lb">{{ $t('setting.settingPersonal.workPlace') }}</label>
      <input
        id="wp"
        v-model="informationUser.work_place"
        type="text"
        class="form-control"
        placeholder="Enter Work Place"
        required
      >
      <label for="cmt" class="lb">{{ $t('setting.settingPersonal.comment') }}</label>
      <input
        id="cmt"
        v-model="informationUser.comment"
        type="text"
        class="form-control"
        placeholder="Comment"
        required
      >
      <button
        data-toggle="modal"
        data-target="#exampleModal"
        type="button"
        class="btn btn-primary"
        @click="saveInformation"
      >{{ $t('setting.settingPersonal.save')
      }}
      </button>
    </div>

  </div>
</template>
<script>
import { mapState } from 'vuex';

export default {
  data() {
    return {

      message: '',
      informationUser: {
        id: null,
        name: '',
        industry: '',
        work_place: '',
        comment: '',
      },
      imgAvatar: null,
      newAvatar: '',
      avatar: '',

    };
  },
  computed: {
    ...mapState({
      userId: state => state.user.id,
      role: state => state.user.role,
    }),
  },
  created() {
    this.showInformationUser();
    console.log(this.role);
  },
  methods: {
    showInformationUser() {
      this.$http.get('/api/users/' + this.userId).then(response => {
        this.informationUser.id = response.data.id;
        this.informationUser.name = response.data.name;
        this.informationUser.industry = response.data.industry;
        this.informationUser.work_place = response.data.work_place;
        this.informationUser.comment = response.data.comment;
        this.imgAvatar = response.data.avatar;
      }).catch(error => console.log(error.response.data));
    },
    handleUploadFile(e) {
      this.avatar = e.target.files[0];
      const reader = new FileReader();
      reader.readAsDataURL(this.avatar);
      reader.onload = (e) => {
        this.newAvatar = e.target.result;
      };
      console.log(this.newAvatar);
    },
    saveInformation() {
      this.informationUser.id = this.userId;
      const formData = new FormData();
      formData.append('avatar', this.avatar);
      for (var key in this.informationUser) {
        formData.append(key, this.informationUser[key]);
      }
      this.$http.post('/api/updateInformation', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      }
      ).then(response => {
        this.message = 'change information success !';
        this.$store.dispatch('user/updateInfo', this.informationUser.name);
        this.$store.dispatch('user/updateAvatar', response.data.avatar);
        console.log('ok');
      }
      )
        .catch(error => error);
    },

  },

};
</script>
<style lang="css">

    .up-avt {
        margin-top: 2%;
        margin-bottom: 2%;
        text-align: center;
    }

    .btn1 {
        min-height: 180px;
        min-width: 210px;

    }

    .avatar1 {
        height: 200px;
        width: 200px;
        border-radius: 50%;
        position:relative;

    }
    .fa-camera{
        position:absolute;
        left:57%;
        top:39.5%;
        font-size:50px;
        color:#9b9e9d;
      z-index:1
    }

    .head-ps {
        background-color: #fee67a;
        height: 4%;
        margin-bottom: 0.5%;
        padding-left: 2%;
        padding-top: 0.7%;

    }

    .content-setting {
        height: auto;
        width: 70%;
        background-color: #efefef;
        float: left;
        margin: 0.5%;
    }

    .form-control {
        width: 80%;
        margin-left: 7%;
        margin-bottom: 2%;
        margin-top: 1%;
    }

    .lb {
        margin-left: 7%;

    }

    .btn-primary {
        background-color: #fee67a;
        min-width: 90px;
        color: black;
        border-color: orange;
    }

</style>
