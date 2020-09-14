<template>
  <div v-if="role==='1'" class="content-setting">
    <!--        modal Add-->

    <div
      id="addStatus"
      class="modal fade"
      tabindex="-1"
      role="dialog"
      aria-labelledby="statusLLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 id="statusLLabel" class="modal-title">{{ $t('setting.status.modalAdd.title') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label
                  for="statusName"
                  class="col-form-label"
                >{{ $t('setting.status.modalAdd.statusName') }}</label>
                <input id="statusName" v-model="newStatus.status" type="text" class="form-control">
                <span
                  v-if="error.length>0 && newStatus.status.length===0"
                  class="alert-danger"
                >{{ $t(error) }}</span>

              </div>
              <div class="form-group">
                <label
                  for="color"
                  class="col-form-label"
                >{{ $t('setting.status.modalSelect.title') }}</label>
                <div class="btn-select-color">
                  <button
                    id="color"
                    type="button"
                    :style="{width: '150px',height: '30px',backgroundColor:colorSelect
                    }"
                    class="select-color"
                    data-toggle="modal"
                    data-target="#select"
                  />

                </div>
                <span v-if="error.length>0 && newStatus.color.length===0" class="alert-danger cl">{{ $t(error) }}</span>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="addStatus()">
              {{ $t('setting.status.modalAdd.add') }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!--        modal add fixItem-->

    <div
      id="addStatusFixItem"
      class="modal fade"
      tabindex="-1"
      role="dialog"
      aria-labelledby="statusLLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 id="l2" class="modal-title">{{ $t('setting.status.modalAdd.title') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label
                  for="statusName1"
                  class="col-form-label"
                >{{ $t('setting.status.modalAdd.statusName') }}</label>
                <input id="statusName1" v-model="newStatus.status" type="text" class="form-control">
                <span
                  v-if="error.length>0 && newStatus.status.length===0"
                  class="alert-danger"
                >{{ $t(error) }}</span>

              </div>
              <div class="form-group">
                <label
                  for="color"
                  class="col-form-label"
                >{{ $t('setting.status.modalSelect.title') }}</label>
                <div class="btn-select-color">
                  <button
                    type="button"
                    :style="{width: '150px',height: '30px',backgroundColor:colorSelect
                    }"
                    class="select-color"
                    data-toggle="modal"
                    data-target="#select"
                  />

                </div>
                <span v-if="error.length>0 && newStatus.color.length===0" class="alert-danger cl">{{ $t(error) }}</span>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="addStatusFixItem()">
              {{ $t('setting.status.modalAdd.add') }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!--        modal edit-->

    <div
      id="editStatus"
      class="modal fade"
      tabindex="-1"
      role="dialog"
      aria-labelledby="editStatusLLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 id="editStatusLLabel" class="modal-title">{{ $t('setting.status.modalEdit.title') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label
                  for="editName"
                  class="col-form-label"
                >{{ $t('setting.status.modalEdit.editName') }}</label>
                <input
                  id="editName"
                  v-model="rowEdit.status"
                  type="text"
                  class="form-control"
                >
              </div>
              <span v-if="error.length>0 && rowEdit.status.length===0" class="alert-danger cl">{{ $t(error) }}</span>
              <div class="form-group">
                <label
                  for="color2"
                  class="col-form-label"
                >{{ $t('setting.status.modalSelect.title') }}</label>
                <div class="btn-select-color">
                  <button
                    id="color2"
                    type="button"
                    :style="{width: '150px',height: '30px',backgroundColor:rowEdit.color}"
                    class="select-color"
                    data-toggle="modal"
                    data-target="#selectEdit"
                  />
                </div>

              </div>
            </form>
          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-primary" @click="editStatus(rowEdit)">

              {{ $t('setting.status.modalEdit.edit') }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!--        modal edit fixItem-->

    <div
      id="editStatusFixItem"
      class="modal fade"
      tabindex="-1"
      role="dialog"
      aria-labelledby="editStatusLLabel2"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 id="editStatusLLabel2" class="modal-title">{{ $t('setting.status.modalEdit.title') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label
                  for="editName3"
                  class="col-form-label"
                >{{ $t('setting.status.modalEdit.editName') }}</label>
                <input
                  id="editName3"
                  v-model="rowEditFixItem.status"
                  type="text"
                  class="form-control"
                >
              </div>
              <span v-if="error.length>0 && rowEdit.status.length==0" class="alert-danger cl">{{ $t(error) }}</span>
              <div class="form-group">
                <label
                  for="color1"
                  class="col-form-label"
                >{{ $t('setting.status.modalSelect.title') }}</label>
                <div class="btn-select-color">
                  <button
                    id="color1"
                    type="button"
                    :style="{width: '150px',height: '30px',backgroundColor:rowEditFixItem.color
                    }"
                    class="select-color"
                    data-toggle="modal"
                    data-target="#selectEdit"
                  />
                </div>

              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="editStatusFixItem(rowEditFixItem)">
              {{ $t('setting.status.modalEdit.edit') }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!--        modal select add-->

    <div
      id="select"
      class="modal"
      tabindex="-1"
      aria-labelledby="selectLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 id="selectLabel" class="modal-title">Select Color</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div v-for="(options,index) in option" :key="options.id" class="tableSelect">
              <button class="buttonSelect" data-dismiss="modal" @click="selectColor(index)">
                <div
                  :style="{
                    width: '227px',height: '37px',backgroundColor:options.color,}"
                />
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--        modal select edit-->

    <div
      id="selectEdit"
      class="modal"
      tabindex="-1"
      aria-labelledby="selectLabel1"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 id="selectLabel1" class="modal-title">Edit Color</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div v-for="(options,index) in option" :key="options.id" class="tableSelect">
              <button class="buttonSelect" @click="selectColor(index)">
                <div
                  :style="{
                    width: '227px',height: '37px',backgroundColor:options.color,}"
                />
              </button>
            </div>
          </div>
          <div class="modal-footer">
            <button
              v-if="editFreeItem===1"
              type="button"
              class="btn btn-primary"
              data-dismiss="modal"
              @click="editColor"
            >
              {{ $t('setting.status.modalAdd.add') }}
            </button>

            <button
              v-else
              type="button"
              class="btn btn-primary"
              data-dismiss="modal"
              @click="editColorFixItem"
            >
              {{ $t('setting.status.modalAdd.add') }}
            </button>

          </div>
        </div>
      </div>
    </div>

    <!-- confirm delete -->
    <div
      id="deleteStatus"
      class="modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="deleteStatus"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ $t('setting.status.modalDelete.title') }}</h5>
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
              data-dismiss="modal"
              @click="deleteStatus(rowDelete,indexRowSelect)"
            >
              {{ $t('setting.status.modalDelete.agree') }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!--        confirm delete fixed item-->
    <div
      id="deleteStatusFixItem"
      class="modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="deleteStatus"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ $t('setting.status.title') }}</h5>
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
              data-dismiss="modal"
              @click="deleteStatusFix(rowDeleteFix,indexRowSelectFix)"
            >
              {{ $t('setting.status.modalDelete.agree') }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!--        table status-->

    <div class="header"> {{ $t('setting.status.title') }}</div>
    <div class="label">{{ $t('setting.status.freeItem') }}</div>
    <div class="table-item ">
      <table class="table table-bordered">
        <tr class="row-text">
          <th>{{ $t('setting.status.color') }}</th>
          <th>{{ $t('setting.status.status') }}</th>
          <th class="active">
            <button
              type="button"
              class="btn add"
              data-toggle="modal"
              data-target="#addStatus"
              @click="deleteError()"
            >
              <i class="fas fa-plus" />
            </button>
          </th>
        </tr>
        <tr v-for="(prod,index) in arrayStatus" :key="prod.id">
          <td class="color-column">
            <div
              :style="{
                width: '227px',height: '37px',backgroundColor:prod.color
              }"
            />
          </td>
          <td class="status-column">{{ prod.status }}</td>
          <td class="active">
            <button
              class="btn edit"
              data-toggle="modal"
              data-target="#editStatus"
              @click="dataEdit(prod,index)"
            >
              <i class="fas fa-pencil-alt" /></button>

            <button
              type="button"
              class="btn delete"
              data-toggle="modal"
              data-target="#deleteStatus"
              @click="dataDelete(prod,index)"
            >

              <i class="fas fa-eraser" />
            </button>
          </td>
        </tr>
      </table>
      <div v-if="numberPage>=2" class="overflow-auto">
        <paginate
          v-model="pageNum"
          :page-count="numberPage"
          :page-range="3"
          :margin-pages="2"
          :click-handler="paginateFreeItem"
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

    <div class="label">{{ $t('setting.status.fixedItem') }}</div>
    <div class="table-item fixed">
      <table class="table table-bordered">
        <tr class="row-text">
          <th>{{ $t('setting.status.color') }}</th>
          <th>{{ $t('setting.status.status') }}</th>
          <th class="active">
            <button
              type="button"
              class="btn add"
              data-toggle="modal"
              data-target="#addStatusFixItem"
              @click="deleteError()"
            >
              <i class="fas fa-plus" />
            </button>
          </th>
        </tr>
        <tr v-for="(prod,indexMaster) in statusMaster" :key="prod.id">
          <td class="color-column">
            <div
              :style="{
                width: '227px',height: '37px',backgroundColor:prod.color
              }"
            />
          </td>
          <td class="status-column">{{ prod.status }}</td>
          <td class="active">
            <button
              class="btn edit"
              data-toggle="modal"
              data-target="#editStatusFixItem"
              @click="dataFixItem(prod,indexMaster)"
            >
              <i class="fas fa-pencil-alt" /></button>

            <button
              type="button"
              class="btn delete"
              data-toggle="modal"
              data-target="#deleteStatusFixItem"
              @click="dataDeleteFixItem(prod,indexMaster)"
            >

              <i class="fas fa-eraser" />
            </button>
          </td>
        </tr>
      </table>
      <div v-if="numberPageMaster>=2" class="overflow-auto">
        <paginate
          v-model="pageNumMaster"
          :page-count="numberPageMaster"
          :page-range="3"
          :margin-pages="2"
          :click-handler="paginateMaster"
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

import { mapState } from 'vuex';

export default {
  data() {
    return {
      closeModal: false,
      error: '',
      option: [
        { id: 1, color: '#f8b62d' },
        { id: 2, color: '#4dc0b5' },
        { id: 3, color: '#e3342f' },
        { id: 4, color: '#4dc0b5' },
        { id: 5, color: '#f66d9b' },
        { id: 6, color: '#ffed4a' },
        { id: 7, color: '#6c757d' },
        { id: 8, color: '#6574cd' },
        { id: 9, color: '#6cb2eb' },
        { id: 10, color: '#9561e2' },
      ],

      statusMasterFull: [],
      statusMaster: [],
      pageNumMaster: 1,
      numberPageMaster: 1,
      rowEditFixItem: {
        id: '',
        status: '',
        color: '',
      },

      rowDeleteFix: {
        id: '',
        status: '',
        color: '',
      },
      indexRowSelectFix: '',

      arrayStatusFull: [],
      arrayStatus: [],
      newStatus: {
        status: '',
        color: '',

      },
      rowDelete: {
        id: '',
        status: '',
        color: '',

      },
      editFreeItem: null,
      newStatusAdd: '',
      rowEdit: {
        id: '',
        status: '',
        color: '',
      },

      colorSelect: '',
      indexRowSelect: null,

      pageNumber: this.$route.params.pageNumber, // page so bao nhieu
      pageNum: Number(this.$route.params.pageNumber),
      numberPage: 1, // so trang
      onePage: 4,

    };
  },
  computed: {
    ...mapState({
      userId: state => state.user.id,
      userName: state => state.user.name,
      userType: state => state.user.type,
      domainId: state => state.user.domain_id,
      role: state => state.user.role,
    }),
  },
  created() {
    this.listStatus();
    this.getStatusesFixed();
  },
  methods: {

    paginateFreeItem(pageNum) {
      this.$http.get('/api/statuses/' + this.domainId + '?page=' + pageNum).then(response => {
        this.arrayStatusFull = response.data;
        this.arrayStatus = this.arrayStatusFull.data;
      });
      this.pageNumber = pageNum;
      this.$router.push('/setting/settingStatus/' + pageNum);
    },
    addColor() {
      this.newStatus.color = this.colorSelect;
    },
    editColor() {
      this.rowEdit.color = this.colorSelect;
    },
    selectColor(indexRowSelect) {
      this.colorSelect = this.option[indexRowSelect].color;
      this.newStatus.color = this.colorSelect;
    },
    deleteError() {
      this.error = '';
    },
    listStatus() {
      this.$http.get('/api/statuses?type=0&page=' + this.pageNum)
        .then(response => {
          this.arrayStatusFull = response.data;
          this.arrayStatus = this.arrayStatusFull.data;
          this.numberPage = this.arrayStatusFull.last_page;
        })
        .catch(error => error.response.data);
    },
    addStatus() {
      if (this.newStatus.status.length > 0 && this.newStatus.color.length > 0) {
        this.$http.post('/api/statuses', {
          status: this.newStatus.status,
          color: this.newStatus.color,
          domain_id: this.domainId,
          type: 0,
        })
          .then(response => {
            this.newStatusadd = response.data;
            this.newStatusAdd = this.newStatusadd.data;
            this.arrayStatus.push(response.data.data);
            this.newStatus.color = '';
            this.newStatus.status = '';
            this.colorSelect = '';
            $('#addStatus').modal('hide');
          })
          .catch(error => {
            error.response.data;
          });
      } else {
        this.error = 'setting.status.validate';
      }
    },

    deleteStatus(row, index) {
      this.$http.delete('/api/statuses/' + row.id)
        .then(response => {
          this.arrayStatus.splice(index, 1);
        })
        .catch(error => {
          error.response.data;
        });
    },
    dataDelete(row, index) {
      this.rowDelete.id = row.id;
      this.rowDelete.status = row.status;
      this.rowDelete.color = row.color;
      this.indexRowSelect = index;
    },

    dataEdit(row, index) {
      this.rowEdit = row;
      this.indexRowSelect = index;
      this.editFreeItem = 1;
    },

    editStatus(row) {
      if (this.rowEdit.status.length > 0) {
        this.$http.put('/api/statuses/' + row.id, { status: row.status, color: row.color })
          .then(response => {
            this.rowEdit = response.data.data;
            this.arrayStatus[this.indexRowSelect] = this.rowEdit;
            $('#editStatus').modal('hide');
            this.error = '';

            console.log(this.arrayStatus);
          }).catch(error => {
            error.response.data;
          });
      } else {
        this.error = 'setting.status.validate';
      }
    },

    // status Master === table fixItem

    addStatusFixItem() {
      if (this.newStatus.status.length > 0 && this.newStatus.color.length > 0) {
        this.$http.post('/api/statuses', {
          status: this.newStatus.status,
          color: this.newStatus.color,
          domain_id: this.domainId,
          type: 1,
        })
          .then(response => {
            this.newStatusadd = response.data;
            this.newStatusAdd = this.newStatusadd.data;
            this.statusMaster.push(this.newStatusAdd);
            this.newStatus.color = '';
            this.newStatus.status = '';
            this.colorSelect = '';
            this.error = '';

            $('#addStatusFixItem').modal('hide');
          })
          .catch(error => {
            error.response.data;
          });
      } else {
        this.error = 'setting.status.validate';
      }
    },
    dataDeleteFixItem(row, index) {
      this.rowDeleteFix.id = row.id;
      this.rowDeleteFix.status = row.status;
      this.rowDeleteFix.color = row.color;
      this.indexRowSelectFix = index;
      console.log(row);
      console.log(index);
    },
    deleteStatusFix(row, index) {
      this.$http.delete('/api/statuses/' + row.id)
        .then(response => {
          this.statusMaster.splice(index, 1);
        })
        .catch(error => {
          error.response.data;
        });
    },
    dataFixItem(row, index) {
      this.rowEditFixItem = row;
      this.indexRowSelectFix = index;
      this.editFreeItem = 0;
    },
    editColorFixItem() {
      this.rowEditFixItem.color = this.colorSelect;
    },

    editStatusFixItem(row) {
      if (this.rowEditFixItem.status.length > 0) {
        this.$http.put('/api/statuses/' + row.id, { status: row.status, color: row.color })
          .then(response => {
            this.rowEditFixItem = response.data.data;
            this.statusMaster[this.indexRowSelectFix] = this.rowEditFixItem;
            $('#editStatusFixItem').modal('hide');
            console.log(this.rowEditFixItem);
          }).catch(error => {
            error.response.data;
          });
      } else {
        this.error = 'setting.status.validate';
      }
    },

    paginateMaster(pageNumMaster) {
      this.pageNumMaster = pageNumMaster;
      this.$http.get('/api/showStatusMaster?page=' + pageNumMaster)
        .then(response => {
          this.statusMasterFull = response.data;
          this.statusMaster = this.statusMasterFull.data;
        });
    },
    getStatusesFixed() {
      this.$http.get('/api/statuses?type=1&page=' + this.pageNum)
        .then(response => {
          this.statusMasterFull = response.data;
          this.statusMaster = this.statusMasterFull.data;
          this.numberPageMaster = this.statusMasterFull.last_page;
          console.log(response.data);
        })
        .catch(error => {
          error.response.data;
        });
    },
  },
};
</script>
<style lang="scss">
    .wrap {

    }

    .content-setting {

        width: 70%;
        height: auto;
        background-color: #efefef;
        float: left;
        margin: 0.3%;

        .table-item {
            height: auto;
            margin-bottom: 2%;

        }

        .header {
            background-color: #fee67a;
            height: 4%;
            padding-left: 2%;
            padding-top: 0.7%;
        }

        .label {
            margin: 2% 0 0.5% 5.5%;

        }

        .table-bordered {
            height: auto;
            width: 88%;
            max-width: 1300px;
            background-color: #ffffff;
            margin: 0 0 0 5.5%;

            .color-column {
                width: 25%;
                text-align: center;

                .status-color {
                    background-color: #3f9ae5;
                    width: 227px;
                    height: 37px;
                }
            }

            .status-column {
                width: 60%;
                text-align: left;
                padding: 2.2% 0 0 3%;;
            }

            .row-text {
                text-align: center;
            }

            .active {
                .add {
                    background-color: #3fe576;

                }

                .edit {
                    background-color: #efefef;
                    margin-left: 15%;
                }

                .delete {
                    margin-left: 10%;
                    background-color: #ff8400;
                }
            }

        }
    }

    .modal-header {

        background-color: #fee67a;
    }

    .col-form-label {
        margin-left: 7%;
    }

    .buttonSelect {
        background-color: white;
        border: 0;
        padding: 0px;
    }

    .btn-select-color {
        margin-left: 7%;
    }

    .alert-danger {
        margin-left: 7%;

        .cl {
            margin-top: 5%;
        }
    }

    .tableSelect {
        float: left;
        margin: 0.8%;

    }

    .pagination {
        justify-content: center;
        display: flex;
        padding-left: 0;
        list-style: none;
        margin-top: 1rem;
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    .page-item {
        color: #337ab7;
    }

    .page-link-item {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;

    }

    .active-class {
        color: red;
        background-color: #3f9ae5;

    }

</style>
