import { config } from '../../utils/config.js'
import { HTTP } from '../..//utils/http.js'
let http = new HTTP()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    tj: {
      yy: 0,
      ks: 0,
      ys: 0,
      je: 0
    }
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var openid = wx.getStorageSync('openid');
    if (!openid) {
      wx.showToast({
        title: '请先登录',
        icon: "error"
      })
      return;
    }
    this.tongji();
  },

  /**
   * 统计
   */
  tongji() {
    var _this = this;
    http.getRequest('api/tongji', {
      openid: wx.getStorageSync('openid')
    }).then(res => {
      _this.setData({
        tj: res.data.data
      });
    });
  },


})