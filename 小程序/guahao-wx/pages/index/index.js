import { config } from '../../utils/config.js'
import { HTTP } from '../..//utils/http.js'
let http = new HTTP()

const app = getApp()

Page({
  data: {
    baseUrl: config.url,
    config: config,
    banners: []
  },

  /*页面加载*/
  onLoad() {
    this.getBanner();
    this.getDoctorTop10();
  },

  /**
   * 加载轮播图
   */
  getBanner() {
    var _this = this;
    http.get('api/getBanner', {}).then(res => {
      _this.setData({
        banners: res.data.data
      });
      console.log(res.data.data);
    });
  },

  /**
   * 加载医生
   */
  getDoctorTop10() {
    var _this = this;
    http.get('api/getDoctorTop10', {}).then(res => {
      _this.setData({
        doctorList: res.data.data
      });
    });
  },



})
