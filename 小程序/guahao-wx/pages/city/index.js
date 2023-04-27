import { config } from '../../utils/config.js'
import { HTTP } from '../..//utils/http.js'
let http = new HTTP()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    config: config,
    classIndex: 0,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.getCityHospital();
  },

  classTap: function (e) {
    this.setData({
      classIndex: e.currentTarget.dataset.index
    });
  },

  /**
   * 加载城市医院
   */
  getCityHospital() {
    var _this = this;
    http.get('api/getCityHospital', {}).then(res => {
      _this.setData({
        cates: res.data.data
      });
    });
  },


})