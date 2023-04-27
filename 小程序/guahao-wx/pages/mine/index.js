import {config} from '../../utils/config.js'
import {HTTP} from '../..//utils/http.js'
let http = new HTTP()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    openid:null,
    customer:{},
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    var openid = wx.getStorageSync('openid');
    if(openid){
      this.setData({
        openid:openid
      });
      this.getInfo();
    }
   
  },

  /**
   * 获取个人信息
   */
  getInfo(){
    var _this = this;
    http.getRequest('api/getInfo/'+_this.data.openid,{}).then(res => {
      _this.setData({
        customer:res.data.data
      });
    });
  },
  
  /**
   * 退出登录
   */
  logoutTap(){
    var _this = this;
    wx.showModal({
      title: '确定',
      content:'是否确定要退出登录',
      success(res){
        if(res.confirm){
          wx.removeStorageSync('openid');
          _this.setData({
            openid:null
          });
        }
      }
    })
  },
  
})