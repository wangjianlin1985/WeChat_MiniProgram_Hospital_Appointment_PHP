import {config} from '../../utils/config.js'
import {HTTP} from '../..//utils/http.js'
let http = new HTTP()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    baseUrl: config.url,
    // messageList:[
    //   {
    //     id:1,
    //     receive:'customer',
    //     from:'杨采妮',
    //     avatar:'/static/images/20211025084634548.jpg',
    //     to:'杨逍',
    //     content:'请问医生，什么时候挂你的号可以，最多可以提前多长时间',
    //     updated_at:'2021-10-25 08:43:25'
    //   },
    //   {
    //     id:2,
    //     receive:'doctor',
    //     from:'杨逍',
    //     avatar:'/static/images/20211025084634548.jpg',
    //     to:'杨采妮',
    //     content:'请问医生，什么时候挂你的号可以',
    //     updated_at:'2021-10-25 08:43:25'
    //   },
    // ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var openid = wx.getStorageSync('openid');
    if(!openid){
      wx.showToast({
        title: '请先登录',
        icon:"error"
      })
      return;
    }
    this.setData({
      openid:openid
    });
    this.findMessage(openid);
  },

  /**
   * 查询留言
   */
  findMessage(openid){
    var _this = this;
    http.getRequest('api/findMessage/'+openid,{}).then(res => {
      _this.setData({
        messageList:res.data.data
      });
    });
  },

  
})