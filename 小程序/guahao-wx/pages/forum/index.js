import {config} from '../../utils/config.js'
import {HTTP} from '../..//utils/http.js'
let http = new HTTP()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    tabList: [
      { txt: '论坛帖子'},
      { txt: '发布帖子'},
    ],
    tabIdx: 0,
    forumList:[
      //{id:1,title:'这个心理医生好不好啊？',counts:10}
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.getForums();
  },

  /**
   * 加载帖子
   */
  getForums(){
    var _this = this;
    http.getRequest('api/getForums/',{}).then(res => {
      _this.setData({
        forumList:res.data.data
      });
      wx.stopPullDownRefresh();
    });
  },


  /**
   * 下拉刷新
   */
  onPullDownRefresh(){
    this.getForums();
  },


  /**
   * 导航切换
   * @param {*} e 
   */
  tabTap: function (e) {
    let index = e.target.dataset.id;
    var _this = this;
    if (index != _this.data.tabIdx) {
      _this.setData({
        tabIdx: index
      })
    }
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
    var title = e.detail.value.title;
    if (title == null || title.length < 1) {
      wx.showToast({
        title: '请填写帖子内容',
        icon:"error"
      })
      return;
    }
    var _this = this;
    http.getRequest('api/saveForum',{
        title:title,
        openid:openid
    }).then(res => {
      wx.showToast({
        title: '发帖成功',
        duration:1000
      })
      setTimeout(() => {
        _this.getForums();
        _this.setData({
          tabIdx:0
        });
      }, 1000);
    });
  },


})