import { getInfo, login, logout } from '../../api/auth';
import { removeToken, setLogged } from '../../utils/auth';

const state = {
  id: null,
  name: '',
  email: '',
  role: '',
  domain_id: null,
  type: null,
  userLogin: Object,
  avatar: null,
  userSelect: null,
  imgUser: '',
};

const getters = {
  userId: state => {
    return state.id;
  },
};

const actions = {
  setUserSelect({ commit }, userSelect){
    commit('SET_USER_SELECT', userSelect);
  },

  updateInfo({ commit }, name) {
    commit('SET_NAME', name);
  },
  updateAvatar({ commit }, avatar) {
    commit('SET_AVATAR', avatar);
  },

  login({ commit }, data) {
    const { email, password, rememberMe } = data;
    return new Promise((resolve, reject) => {
      login({
        email: email,
        password: password,
        rememberMe: rememberMe,
      }).then(response => {
        console.log(response);
        setLogged('1');
        resolve();
      }).catch(error => {
        console.log(error);
        reject(error);
      });
    });
  },
  getUserInfo({ commit }) {
    return new Promise((resolve, reject) => {
      getInfo().then(response => {
        console.log(response);
        const { data } = response;
        if (!data) {
          reject('Verification failed, please Login again.');
        }
        console.log('getUserInfo');
        console.log(data);
        commit('GET_IMG_USER', data.avatar);
        commit('SET_ID', data.id);
        commit('SET_NAME', data.name);
        commit('SET_ROLE', data.role);
        commit('SET_EMAIL', data.email);
        commit('SET_DOMAIN_ID', data.domain_id);

        resolve(data);
      }).catch(error => {
        console.log(error);
        reject(error);
      });
    });
  },
  logout({ commit }) {
    return new Promise((resolve, reject) => {
      logout()
        .then(() => {
          removeToken();
          commit('SET_ID', null);

          resolve();
        })
        .catch(error => {
          reject(error);
        });
    });
  },
  resetToken({ commit }) {
    return new Promise(resolve => {
      removeToken();
      resolve();
    });
  },
};

const mutations = {
  SET_ID: (state, id) => {
    state.id = id;
  },
  SET_NAME: (state, name) => {
    state.name = name;
  },
  SET_ROLE: (state, role) => {
    state.role = role;
  },
  SET_EMAIL: (state, email) => {
    state.email = email;
  },
  SET_DOMAIN_ID: (state, domain_id) => {
    state.domain_id = domain_id;
  },
  SET_AVATAR: (state, avatar) => {
    state.avatar = avatar;
  },
  SET_USER_SELECT: (state, userSelect) => {
    state.userSelect = userSelect;
  },
  GET_IMG_USER: (state, img) => {
    state.imgUser = img;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
};
