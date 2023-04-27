import {config} from '../../utils/config.js'
import {HTTP} from '../..//utils/http.js'
let http = new HTTP()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    //forum_id:0,
    //to_id:0,
    //to:''
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var forum_id = options.forum_id;
    var to_id = options.to_id;
    var to = options.to;
    var openid = options.openid;
    this.setData({
      forum_id:forum_id,
      to:to,
      to_id:to_id,
      openid:openid,
    });

  },

  /**
   * 提交发布帖子
   */
  formSubmit: function (e) {
    var openid = wx.getStorageSync('openid');
    if(!openid){
      wx.showToast({
        title: '请先登录',
        icon:"error"
      })
      return;
    }
    var content = e.detail.value.content;
    if (content == null || content.length < 1) {
      wx.showToast({
        title: '请填写回复内容',
        icon:"error"
      })
      return;
    }
    var _this = this;
    http.getRequest('api/replyForum',{
        content:content,
        openid:openid,
        to_id:_this.data.to_id,
        forum_id:_this.data.forum_id
    }).then(res => {
      wx.showToast({
        title: '回帖成功',
        duration:1000
      })
      setTimeout(() => {
        wx.navigateBack();
      }, 1000);
    });
  },
})