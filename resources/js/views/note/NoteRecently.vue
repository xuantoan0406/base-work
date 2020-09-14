<template>
  <div>
    <span>{{ $t('userDetails.note') }}</span>
    <div
      id="modalLoginForm"
      class="modal fade"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-center">
            <h4 class="modal-title w-100 font-weight-bold">{{ $t('userDetails.writeNote') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body mx-3">
            <div class="md-form" style="margin-top: 10px;">
              <div class="col-form-label"> Title</div>
              <input v-model="title" type="text" class="form-control">
            </div>
            <div class="col-form-label">Content</div>
            <div class="md-form" style="margin-top: 10px;">
              <textarea
                v-model="content"
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
          <div class="modal-footer d-flex justify-content-center">
            <button
              class="btn btn-default seeMore"
              :data-dismiss="[isModal]"
              aria-label="Close"
              aria-hidden="true"
              @click="createNote(user.id,content,title)"
            >Done
            </button>
          </div>
        </div>
      </div>
    </div>

    <div v-if=" userId === user.id || userRole === 1" class="write-note">
      <a
        href=""
        class="btn btn-default btn-rounded"
        data-toggle="modal"
        data-target="#modalLoginForm"
        @click="deleteError()"
      >

        {{ $t('userDetails.writeNote') }}
      </a>
    </div>
    <div class="row div-1">
      <div class="col-lg-12 list-note">
        <div
          v-for="(note, index) in notesRecently"
          :key="index"
          class="note"
        >
          <div class="row">
            <div class="col-lg-8 content">
              {{ note.title }}
            </div>
            <div class="col-lg-4 date">
              {{ convertDate(note.created_at) }}
            </div>
          </div>
        </div>
      </div>
      <div class="button-see">
        <router-link :to="{name:'note'}">
          <button type="button" class="btn btn-block seeMore" @click="getInfoUserSelect">
            {{ $t('userDetails.seeMore') }}
          </button>
        </router-link>
      </div>
    </div>
  </div>

</template>

<script>
import moment from 'moment';
import 'moment-timezone';
import { mapState } from 'vuex';
moment.tz.setDefault('Asia/Tokyo');
export default {
  props: {
    user: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      notesRecently: [],
      content: '',
      errors: '',
      title: '',
      isModal: 'modal',
    };
  },
  computed: {
    ...mapState({
      userId: state => state.user.id,
      userRole: state => state.user.role,
    }),
  },

  created() {
    this.listNotesRecently();
  },

  methods: {
    listNotesRecently() {
      this.$http.get('/api/listNotesRecently?userID=' + this.user.id)
        .then(response => {
          this.notesRecently = response.data;
        })
        .catch(error => error.response.data);
    },

    convertDate(date) {
      const dateFormat = moment(date).format('YYYY.MM.DD');
      return dateFormat;
    },

    deleteError() {
      this.errors = '';
    },

    createNote(userID, content, title) {
      if (content === '' || title === '') {
        this.errors = 'Note content and title is required.';
        this.isModal = '';
      } else {
        this.errors = '';
        this.isModal = 'modal';
        console.log('createNote');
        this.$http.post('/api/notes', { user_id: userID, content: content, title: title })
          .then(response => {
            console.log(response.data);
            console.log('createNote done');
            this.listNotesRecently();
            this.content = '';
            this.title = '';
          })
          .catch(error =>
            error
          );
      }
    },
    getInfoUserSelect() {
      this.$store.dispatch('user/setUserSelect', this.user);
    },

  },

};
</script>

<style lang="scss" scoped>
    .list-note {
        background-color: white;
        padding: 20px 20px;
        overflow: auto;
        max-height: 280px;
    }

    .modal-title {
        padding-left: 25px;
    }

    .div-1 {
        margin-right: 0px;
        margin-left: 0px;
        margin-top: 20px;
        margin-bottom: 10px;
        background-color: white;
    }

    .content {
        resize: none;
    }

    .button-see {
        width: 100%;
        background-color: #f2f5f2;
        text-align: center;
    }

    .seeMore {
        background-color: #faefbb;
        margin-top: 20px;
        color: #FAA100;
    }
    .btn:focus {
        box-shadow: none !important;
    }
    a:hover {
        text-decoration: none !important;
    }
    .note {
        border-bottom: 2px solid #ADB1AD;
        padding: 15px 10px;
    }

    .list-note > div.note:nth-child(4) {
        border-bottom: none;
    }

    .write-note {
        text-align: center !important;
        display: inline-block;
        float: right;
        background-color: white;
        border: 1px solid #FAA100;
        border-radius: 5px;

        a {
            color: #FAA100;
            padding: 3px 10px;
        }
    }

</style>
