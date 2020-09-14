import Vue from 'vue';
import Router from 'vue-router';
import Login from '../views/login';
import Setting from '../views/setting/index';
import ChangePass from '../views/setting/ChangePass';
import SettingStatus from '../views/setting/SettingStatus';
import SettingPersonal from '../views/setting/SettingPersonal';
import Activity from '../views/activity/index';
import Workplaces from '../views/workplaces/index';
import { Roles } from '../utils/auth';
import Home from '../views/viewPhone/Home';

import Report from '../views/manageNote/Report';

import ActivityHistory from '../views/activity/ActivityHistory';

import Note from '../views/manageNote/Note';

Vue.use(Router);

export const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: {
      role: Roles.guest,
    },
  },
  {
    path: '/',
    redirect: '/activity/1',
  },
  {
    path: '/home',
    redirect: '/home/1',
  },
  {
    path: '/home/:pageNumber',
    name: 'home',
    component: Home,
  },

  {
    path: '/activity',
    redirect: '/activity/1',
    name: 'activity',
    component: Activity,
  },

  {
    path: '/activityHistory',
    name: 'activityHistory',
    component: ActivityHistory,
    props: true,
  },

  {
    path: 'workplaces',
    redirect: '/workplaces/1',
    name: 'workplaces',
    component: Workplaces,
  },

  {
    path: '/workplaces/:pageNumber',
    name: 'workplaces',
    component: Workplaces,
    meta: {
      role: Roles.user,
    },
  },

  {
    path: '/activity/:pageNumber',
    name: 'activity',
    component: Activity,
    meta: {
      role: Roles.user,
    },
  },

  {
    path: '/setting',
    redirect: '/setting/personal',
    name: 'setting',
    component: Setting,
    meta: {
      role: Roles.user,
    },
    children: [
      {
        path: '/setting/changePass',
        name: 'changePass',
        component: ChangePass,

      },
      {
        path: '/setting/personal',
        name: 'personal',
        component: SettingPersonal,
      },

      {
        path: '/setting/settingStatus',
        redirect: '/setting/settingStatus/1',
        name: 'status',
        component: SettingStatus,
      },
      {
        path: '/setting/settingStatus/:pageNumber',
        name: 'status',
        component: SettingStatus,
      },
    ],
  },
  {
    path: '/manageNote/report',
    name: 'report',
    component: Report,
    meta: {
      role: Roles.user,
    },
  },
  {
    path: '/manageNote/note',
    name: 'note',
    component: Note,
    meta: {
      role: Roles.user,
    },
  },

];

const router = new Router({
  mode: 'history',
  routes,
});

export default router;
