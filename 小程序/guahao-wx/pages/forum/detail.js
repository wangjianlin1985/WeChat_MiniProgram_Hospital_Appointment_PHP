import {config} from '../../utils/config.js'
import {HTTP} from '../..//utils/http.js'
let http = new HTTP()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    forum_id:1,
    forum:{
      // id:1,
      // title:'这个心理医生好不好啊？',
      // reply:[
      //   {id:1,content:'haoa',from_id:1,from:'洛杉矶',to_id:2,to:'欧派',created_at:'2021-10-10 22:00:00'}
      // ]
    },
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var forum_id = options.forum_id;
    this.setData({
      forum_id:forum_id
    });
    this.forum(this.data.forum_id);
  },


  /**
   * 加载帖子明细
   */
  forum(id){
    var _this = this;
    http.getRequest('api/forum/'+id,{}).then(res => {
      _this.setData({
        forum:res.data.data
      });
      wx.stopPullDownRefresh();
    });
  },

   /**
   * 下拉刷新
   */
  onPullDownRefresh(){
    this.forum(this.data.forum_id);
  },


  /**
   * 回复帖子
   */
  replyTap(e){
    //console.log(e);
    var openid = wx.getStorageSync('openid');
    if(!openid){
      wx.showToast({
        title: '请先登录',
        icon:"error"
      })
      return;
    }
    var forum_id = e.currentTarget.dataset.forum_id;
    var from_id = e.currentTarget.dataset.from_id;
    var from = e.currentTarget.dataset.from;
    wx.navigateTo({
      url: '/pages/forum/reply?forum_id='+forum_id+'&to_id='+from_id+'&to='+from+'&openid='+openid,
    })

  },

  
})