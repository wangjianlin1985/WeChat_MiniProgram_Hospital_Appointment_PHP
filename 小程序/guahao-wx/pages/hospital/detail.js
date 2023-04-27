import { config } from '../../utils/config.js'
import { HTTP } from '../..//utils/http.js'
let http = new HTTP()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    config: config,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.hospital(options.hospital_id);
  },

  /**
   * 加载轮播图
   */
  hospital(id) {
    var _this = this;
    http.get('api/hospital/' + id, {}).then(res => {
      _this.setData({
        hospital: res.data.data
      });
    });
  },

  guahao() {
    var _this = this;
    wx.navigateTo({
      url: '/pages/doctor/index?hospital_id=' + _this.data.hospital.id,
    })
  },


})