import {config} from '../../utils/config.js'
import {HTTP} from '../..//utils/http.js'
let http = new HTTP()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    article:{
      // id:1,
      // title:'年轻人，你的焦虑如何治愈？丨InfoQ 8 月文章精选',
      // updated_at:'2021-10-26 10:00:00',
      // content:'作者｜小智与其焦虑，不如自律。InfoQ 8 月文章精选，请收下。写在前面你每天在 InfoQ 公众号上都可以读到编辑署名小智的文章，但作者署名小智的却并不多，这是最新的一篇。InfoQ 公众号经我手发出去'
    }
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var id = options.id;
    //console.log(options);
    this.article(id);
  },

  /**
   * 加载文章
   */
  article(id){
    var _this = this;
    http.get('api/article/'+id,{}).then(res => {
      _this.setData({
        article:res.data.data
      });
    });
  },

  
})