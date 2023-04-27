import {config} from '../../utils/config.js'
import {HTTP} from '../..//utils/http.js'
let http = new HTTP()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    articleList:[
      //{id:1,title:'关于心理健康对于孩子的重要性你知道多少?'},
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.getArticles();
  },

  /**
   * 加载文章
   */
  getArticles(){
    var _this = this;
    http.get('api/getArticles/',{}).then(res => {
      _this.setData({
        articleList:res.data.data
      });
    });
  },

  

  
})